<?php

namespace App\Http\Controllers;

use App\Models\HolidayType;
use App\Models\Hour;
use App\Models\HourType;
use Illuminate\Http\Request;

class HourTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(): array
    {
        return ifIsSuperUser(function () {
            return [
                'hours' => Hour::select('id', 'start_time', 'end_time')
                    ->orderBy('start_time')
                    ->get(),

                'hourTypes' => HourType::with(['hours' => function ($query) {
                    $query->orderBy('start_time');
                }])
                    ->select('id', 'name')
                    ->get()
            ];
        });
    }

    public function updateEntity(Request $request)
    {
        $request->validate([
            'value' => 'required|max:255'
        ]);

        return ifIsSuperUser(function () use ($request) {
            return tryCatch(function () use ($request) {
                $entity = $request->input('type') === 'holiday'
                    ? HolidayType::class
                    : HourType::class;

                $entity::find($request->input('id'))->update(['name' => $request->input('value')]);

            }, 'success', 'error');
        });
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request): array
    {
        $request->validate([
            'name' => 'required'
        ]);

        return ifIsSuperUser(function () use ($request) {
            return tryCatch(function () use ($request) {
                HourType::create($request->all());
            }, 'success', 'error');
        });
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id): array
    {
        $hourType = HourType::findOrFail($id);

        return tryCatch(function () use ($request, $hourType) {
            $hourType->hours()->sync($request->input('hourIds'));
        }, 'success', 'error');
    }
}
