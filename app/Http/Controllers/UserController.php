<?php

namespace App\Http\Controllers;

use App\Models\Day;
use App\Models\HolidayType;
use App\Models\Hour;
use App\Models\HourType;
use App\Models\Role;
use App\Models\Room;
use App\Models\SiteVariables;
use \App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return array
     */
    public function index()
    {
        return [
            'reservationCount' => Auth::user()->reservations->count(),
            'score'=>Auth::user()->score,
            'howtoText' => SiteVariables::whereVariable('ho_to_increase_score')->first()->value
        ];
    }

    public function getInitialEntities()
    {
        return [
            'roles' => Role::select('id', 'name', 'persian_name')->whereNotIn('name', ['admin', 'user'])->get(),
            'rooms' => Room::select('id', 'name')->get(),
            'days' => Day::select('id', 'name')->get(),
            'hours' => Hour::select('id', 'start_time', 'end_time')
                ->orderBy('start_time')
                ->get(),
            'hourTypes' => HourType::with(['hours' => function ($query) {
                $query->orderBy('start_time');
            }])
                ->select('id', 'name')
                ->get(),
            'holidayTypes' => HolidayType::select('id', 'name')->with(['days' => function ($dayQuery) {
                $dayQuery->select('days.id', 'name');
            }])->get(),

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
            'email' => 'required|unique:users,email|max:255',
            'name' => 'max:255',
            'password' => ['required']
        ]);

        return ifIsSuperUser(function () use ($request) {

            return tryCatch(function () use ($request) {

                $user = User::create([
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'role_id' => $request->input('role.id'),
                    'password' => Hash::make($request->input('password')),
                ]);

                $user->rooms()->sync($request->input('rooms'));

            }, 'کاربر با موفقیت ایجاد شد', 'خطا در ایجاد کاربر');
        });

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return array
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'email' => 'nullable|unique:users,email,' . $request->input('id') . ',id',
            'name' => 'max:255',
        ]);

        return tryCatch(function () use ($request, $id) {
            $user = User::findOrFail($id);

            $role = Role::findOrFail($request->input('role.id'));

            $user->role()->associate($role)->save();
            $user->rooms()->sync($request->input('rooms'));

            if ($request->input('name')) {
                $user->name = $request->input('name');
            }

            if ($request->input('email')) {
                $user->email = $request->input('email');
            }

            if ($request->input('phone')) {
                $user->phone = $request->input('phone');
            }

            if ($request->input('password')) {
                $user->password = Hash::make($request->input('password'));
            }

            if ($request->input('score')) {
                $user->score = $request->input('score');
            }

            $user->save();

        }, 'بروزرسانی با موفقیت انجام شد', 'خطایی در بروزرسانی بوجود آمده');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id): array
    {
        $user = User::findOrFail($id);

        return $user->isAdmin()
            ? [
                'status' => false,
                'msg' => 'کاربر ادمین نمی تواند پاک شود'
            ]
            : tryCatch(function () use ($user) {
                $user->delete();
            }, 'کاربر با موفقیت حذف شد', 'خطا در حذف کاربر');
    }

    public function getUserAndRoles(Request $request, $id = null)
    {
        return ifIsSuperUser(function () use ($id){
            $updatingUser = User::where('id', $id)->select('id', 'name', 'email', 'phone', 'role_id', 'score')->with([
                'role' => function ($role) {
                    $role->select('id', 'name', 'persian_name');
                },
                'rooms' => function ($q) {
                    $q->select('rooms.id', 'name');
                }
            ])->first();

            return [
                'updatingUser' => $updatingUser,
                'roles' => Auth::user()->isSuperUser() ?
                    Role::select('id', 'name', 'persian_name')->whereNotIn('name', ['admin', 'user'])->get()
                    : []
                , 'rooms' => Auth::user()->isSuperUser() ?
                    Room::select('id', 'name')->get() :
                    []
            ];

        });
    }

    public function getUserAndUsers()
    {
        return ifIsSuperUser(function (){
            return [
                'user' => Auth::check() ? Auth::user()->only(['id', 'name', 'email', 'type']) : '',
                'users' => User::with([
                    'role' => function ($q) {
                        $q->select('id', 'name', 'persian_name');
                    },
                    'rooms' => function ($q) {
                        $q->select('rooms.id', 'name');
                    }
                ])->select('id', 'name', 'email', 'role_id')->orderBy('role_id')->paginate(10)
            ];
        });
    }
}
