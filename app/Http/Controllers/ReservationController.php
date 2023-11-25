<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\ExtraHoliday;
use App\Models\Payment;
use App\Models\Reservation;
use App\Models\Room;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        if(Auth::user()->isModerator()){
            return [
                'rooms' => Room::when(Auth::user()->type === 'room_owner', function ($room) {
                    $room->whereHas('user', function ($user) {
                        $user->where('users.id', Auth::id());
                    });
                })->whereReservable(1)->select('id', 'name')->get(),

                'days' => Day::select('id', 'name', 'number')->get()
            ];
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function store(Request $request)
    {
        $request->validate([
            'room.id' => 'required|exists:rooms,id',
            'customReserves' => Rule::requiredIf($request->input('actionType') !== 'doCloseHours'),
            'hours' => Rule::requiredIf($request->input('actionType') === 'doReserve')
        ]);

        return $this->{$request->input('actionType')}();
    }

    public function doReserve(): array
    {
        return tryCatch(function () {

            $room = Room::findOrFail(\request()->input('room.id'));
            $payment = Payment::create([
                'status' => 'manual'
            ]);

            $reservation = $room->reservations()->create([
                'reservation_date' => \request()->input('customReserves'),
                'hour_id' => \request()->input('hours.id'),
                'payment_id' => $payment->id
            ]);

            $reservation->users()->attach([Auth::id() => ['user_type' => 'main']]);

        }, 'success', 'error');
    }

    public function doOpen(): array
    {
        return tryCatch(function () {
            $room = Room::findOrFail(\request()->input('room.id'));

            forEvery(\request()->input('customReserves'), function ($customReserve) use ($room) {
                $holiday = $room->extraHolidays()->where('date', $customReserve);
                $holiday->exists() ? $holiday->delete() : $holiday->create(['date' => $customReserve]);
            });

        }, 'success', 'error');
    }

    public function doClose(): array
    {
        return tryCatch(function () {
            $this->doOpen();
        }, 'success', 'error');
    }

    public function doCloseHours(): array
    {
        return tryCatch(function () {
            $room = Room::findOrFail(\request()->input('room.id'));
            $day = \request()->input('day.id');

            $closedHourQuery = $room->closedHours()->where('day_id', $day);
            $closedHourQuery->delete();

            forEvery(\request()->input('hours'), function ($hour) use ($closedHourQuery, $day) {
                $closedHourQuery->create([
                    'hour_id' => $hour['id'],
                    'day_id' => $day
                ]);
            });

        }, 'success', 'error');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return array
     */
    public function show($id)
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
            'reservations' => function ($reservation) {
                $reservation->with([
                    'users' => function ($user) {
                        $user->wherePivot('user_type', 'main')->select('id', 'name');
                    },
                    'hour' => function ($hour) {
                        $hour->select('id', 'start_time', 'end_time');
                    },
                    'payment' => function ($payment) {
                        $payment->select('id', 'status');
                    }
                ])->select('hour_id', 'id', 'reservation_date', 'room_id', 'payment_id');
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
        ])->findOrFail($id);

        return [
            'ordinaryReserves' => $room->holidayType->days,
            'customReserves' => $room->extraHolidays,
            'hours' => $room->hourType->hours,
            'reservations' => $room->reservations,
            'closedHours' => $room->closedHours
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return array
     */
    public function destroy($id)
    {
        return tryCatch(function () use ($id) {
            Reservation::destroy(json_decode($id));
        }, 'success', 'error');
    }

    public function search(Request $request)
    {

        $userIsNotManager = Auth::user()->type === 'room_owner' || Auth::user()->type === 'user';

        return Reservation::when($userIsNotManager, function ($reservation) {
            $reservation->whereHas('users', function ($user) {
                $user->where('users.id', Auth::id());
            });
        })
            ->when($request->input('key'), function ($reservation) use ($request) {
                $reservation->whereHas('room', function ($room) use ($request) {
                    $room->where('name', 'like', '%' . $request->input('key') . '%');
                });
            })
            ->with([
                'mainUser' => function ($user) {
                    $user->select('id', 'name', 'email')->orderBy('name');
                },
                'optionalUser' => function ($user) {
                    $user->select('id', 'name', 'email');
                },
                'room' => function ($room) {
                    $room->select('id', 'name');
                },
                'hour' => function ($hour) {
                    $hour->select('id', 'start_time', 'end_time');
                },
                'payment'

            ])
            ->select('id', 'created_at', 'reservation_date', 'people_count', 'room_id', 'hour_id', 'payment_id')
            ->orderBy('created_at', 'DESC')
            ->orderBy('room_id')
            ->orderBy('reservation_date')
            ->paginate(10);
    }
}
