<?php

namespace App\Http\Controllers;

use App\Models\CustomPrice;
use App\Models\Day;
use App\Models\Hour;
use App\Models\Room;
use Illuminate\Http\Request;

class CustomPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return object
     */
    public function search(Request $request)
    {
        return ifIsSuperUser(function ()use ($request) {
            return CustomPrice::customQuery()
                ->when(
                    $request->input('room'),
                    function ($customPrice) use ($request) {
                        $customPrice->whereHas('room', function ($room) use ($request) {
                            $room->where('name', 'like', '%' . $request->input('room') . '%');
                        });
                    })->paginate(10);
        });
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(): array
    {
        return [
            'rooms' => Room::select('id', 'name')->get(),
        ];
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
            'room_id' => 'exists:rooms,id',
            'day_id' => 'exists:days,id',
            'hour_id' => 'exists:hours,id',
            'price' => 'required'
        ]);

        return ifIsSuperUser(function () use ($request){
            return tryCatch(function () use ($request) {

                CustomPrice::updateOrCreate(
                    $request->except('price')
                    , ['price' => $request->input('price')]
                );
            }, 'قیمت با موفقیت بروزرسانی - ثبت شد.', 'خطا در ثبت قیمت');
        });

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return array
     */
    public function show($id)
    {
        $room = Room::findOrFail($id);

        return [
            'days' => Day::select('id', 'name', 'number')->get(),
            'holidayDays' => $room->holidayType->days()->select('days.id', 'name', 'number')->get(),
            'hours' => $room->hourType
                ->hours()
                ->select('hours.id', 'start_time', 'end_time')
                ->orderBy('start_time')
                ->get(),
            'customPrices' => $room->customPrice,
            'roomPrice' => $room->price
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return array
     */
    public function destroy($id): array
    {
        return tryCatch(function () use ($id) {
            CustomPrice::findOrFail($id)->delete();
        }, 'قیمت با موفقیت حذف شد', 'خطا در حذف قیمت');
    }
}
