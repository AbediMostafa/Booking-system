<?php

namespace App\Http\Controllers;

use App\Models\Hour;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class HourController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Hour::select('id', 'start_time', 'end_time')
            ->orderBy('start_time')
            ->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'start_time' => ['date_format:H:i'],
//            'end_time' => [
//                'date_format:H:i'
//                , 'after:start_time'
//                , Rule::unique('hours')->where(function ($query) use ($request) {
//                    return $query->where('start_time', $request->input('start_time'))
//                        ->where('end_time', $request->input('end_time'));
//                })
//            ],
        ]);

        return ifIsSuperUser(function () use ($request) {
            return tryCatch(function () use ($request) {
                Hour::create([
                    'start_time' => $request->input('start_time'),
                ]);
            }, 'بازه زمانی با موفقیت ثبت شد.', 'خطا در ثبت بازه زمانی');
        });
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
     * @return array
     */
    public function destroy(int $id)
    {
        return tryCatch(function () use ($id) {
            Hour::findOrFail($id)->delete();
        }, 'ساعت با موفقیت حذف شد', 'مشکل در حذف ساعت');
    }
}
