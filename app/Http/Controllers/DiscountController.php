<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountController extends Controller
{
    public function index()
    {
        $discounts=DB::table('discounts')->select('amount','room_id')
        ->orderBy('created_at','desc')->limit(2)->get();
        return $discounts;
        
    }
}
