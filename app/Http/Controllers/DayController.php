<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\HolidayType;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class DayController extends Controller
{
    public function index()
    {
        return Day::select('name', 'number')->get();
    }

    public function holidayDays()
    {
        return ifIsSuperUser(function (){
            return [
                'holidayTypes' => HolidayType::select('id', 'name')->with(['days' => function ($dayQuery) {
                    $dayQuery->select('days.id', 'name');
                }])->get(),

                'days' => Day::select('id', 'name')->orderBy('id')->get()
            ];
        });
    }

    public function addHoliday(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:holiday_types']
        ]);

        $holiday = HolidayType::create([
            'name' => $request->input('name')
        ]);

        return [
            'status' => true,
            'msg' => 'success',
            'holidayId' => $holiday->id
        ];
    }

    public function deleteHoliday(HolidayType $holidayType)
    {

        if($holidayType->rooms()->exists()){
            return [
              'status'=>false,
              'msg'=>''
            ];
        }

        tryCatch(function () use ($holidayType) {
            $holidayType->days()->detach();
            $holidayType->delete();
        }, 'success', 'error');
    }

    public function addHolidayDay(Request $request, HolidayType $holidayType)
    {

        $dayIds = Arr::pluck($request->input('days'), 'id');

        $holidayType->days()->sync($dayIds);

        return [
            'status' => true,
            'msg' => 'success'
        ];
    }
}
