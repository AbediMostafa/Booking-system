<?php

namespace App\Http\Controllers;

use App\Classes\UltraFastSendSms;
use App\Classes\Vars;
use App\Classes\Zarinpal;
use App\Http\Requests\CheckoutFormRequest;
use App\Models\CustomPrice;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Room;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CheckoutController extends Controller
{
    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return object
     */
    public function store(Request $request)
    {
        $validator = Validator::make(
            json_decode($request->input('data'), true),
            CheckoutFormRequest::rules(),
            [],
            CheckoutFormRequest::getAttributes()
        );

        if ($validator->fails()) {

            return redirect()->back()->with([
                'validationData' => $request->input('data'),
                'errors' => json_encode($validator->errors()->getMessages())
            ]);
        }

        $data = json_decode($request->input('data'))->postData;

        $payment = Payment::initialConstruction($data->prePayed);

        $reservation = $payment->makeReservation($data);

        foreach ($this->getFilteredPersons($data->reservedPersons) as $key => $person) {
            $user = User::getFirstOrCreate($person);
            $userType = $key === 0 ? 'main' : 'optional';

            $reservation->users()
                ->wherePivot('user_type', $userType)
                ->whereId($user->id)
                ->doesntExist()
            &&
            $reservation->users()
                ->attach([$user->id => ['user_type' => $userType]]);
        }

        $zp = new Zarinpal();
        $zp->request($this->zarinInitials($user, $payment, $data));

        if ($zp->statusIsOk()) {
            $zp->then($payment);

        } else {

            $zp->catch($payment);

            return redirect()->back()->with([
                'validationData' => $request->input('data'),
                'errorMessage' => "error"
            ]);
        }
    }

    public function zarinInitials($user, $payment, $data)
    {
        $amount = $data->prePayed;
        $roomId = $data->roomId;

        $description = "room reserve for user : $user->id - $user->name - $user->email";
        $callbackUrl = url("checkout/payment-callback/{$roomId}/$payment->id/$amount");

        return [
            'amount' => $amount,
            'description' => $description,
            'callbackUrl' => $callbackUrl
        ];
    }

    public function getFilteredPersons($persons)
    {
        return array_filter($persons, function ($person) {
            return $person->name && $person->phone;
        });
    }

    public function paymentCallBack(Request $request, Room $room, Payment $payment, $amount)
    {
        $zp = new Zarinpal();
        $result = $zp->verify($amount);
        $status = 0;
        $msg = 'success';
        $refId = '';

        if (isset($result["Status"]) && $result["Status"] == 100) {

            $payment->status = 'success';
            $payment->description = $payment->description . 'success' . $result["Authority"];
            $payment->transaction_id = $result["RefID"];
            $payment->save();

            $status = 1;
            $msg = "success{$result['RefID']}";
            $refId = $result["RefID"];

            $this->sendCheckoutSms($room, $payment);

        } else {
            $payment->status = 'failed';
            $payment->description = "error" . $result["Status"] . ' - ' . $result["Message"];
            $payment->save();
        }

        return redirect("/rooms/{$room->id}")->with([
            'reserveStatus' => $status
            , 'msg' => $msg
            , 'refId' => $refId
            , 'paymentCallback' => 1
        ]);
    }

    public function sendCheckoutSms($room, $payment)
    {
        $user = $payment->reservation->users()->wherePivot('user_type', 'main')->first();
        $reservation = $payment->reservation;
        $hour = $reservation->hour;

        $user->score = $user->score + Vars::$reservationScore;
        $user->save();

        $ultra = new UltraFastSendSms();
        $ultra->reservationSms(
            $user->phone,
            $user->name,
            $room->name,
            $reservation->reservation_date,
            $hour->start_time,
            $payment->transaction_id,
            url("checkout/comment/$reservation->id")
        )->UltraFastSend();

        User::whereHas(
            'role',
            function ($role) {
                $role->whereName('admin')->orWhere('name', 'manager');
            })
            ->orWhereHas(
                'rooms',
                function ($rooms) use ($room) {
                    $rooms->where('rooms.id', $room->id);
                })
            ->get()
            ->each(
                function ($admin) use ($ultra, $user, $reservation, $hour, $payment, $room) {
                    $ultra->reservationSmsToAdmins(
                        $admin->phone,
                        $user->phone,
                        $user->name,
                        $room->name,
                        $reservation->reservation_date,
                        $hour->start_time,
                    )->UltraFastSend();
                });
    }

    public function commentingAfterCheckout(Reservation $reservation)
    {
        return redirect("phone-check/{$reservation->room->id}");
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return array
     */
    public function show($id): array
    {
        $room = Room::with([
                'holidayType.days' => function ($day) {
                    $day->select('days.id', 'name', 'number');
                },
                'extraHolidays' => function ($extraHoliday) {
                    $extraHoliday->select('date', 'room_id');
                },
                'hourType.hours' => function ($hour) {
                    $hour->select('hours.id', 'start_time', 'end_time')
                        ->orderBy('start_time');
                },
                'closedHours' => function ($closedHour) {
                    $closedHour->with([
                        'hour' => function ($hour) {
                            $hour->select('id', 'start_time', 'end_time');
                        },
                        'day' => function ($day) {
                            $day->select('id', 'name', 'number');
                        },
                    ])->select('hour_id', 'day_id', 'room_id');
                }
            ]
        )->whereReservable(1)->findOrFail($id);

        $reservations = $room->reservations()
            ->with([
                'hour' => function ($hour) {
                    $hour->select('id', 'start_time', 'end_time');
                },
                'payment' => function ($payment) {
                    $payment->select('id', 'status');
                }
            ])
            ->select('hour_id', 'id', 'reservation_date', 'payment_id')
            ->get();

        $customPrice = CustomPrice::customQuery()->whereRoomId($room->id)->get();

        return [
            'customReserves' => $room->extraHolidays,
            'ordinaryReserves' => $room->holidayType->days,
            'closedHours'=>$room->closedHours,
            'hours' => $room->hourType->hours,
            'reservations' => $reservations,
            'peopleCount' => range($room->min_person, $room->max_person),
            'image' => $room->mediaType()->first()->path,
            'address' => $room->address,
            'name' => $room->name,
            'customPrice' => $customPrice,
            'price' => $room->price,
            'ticketCount' => $room->ticket_count
        ];
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
