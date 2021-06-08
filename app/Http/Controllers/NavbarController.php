<?php

namespace App\Http\Controllers;

use App\Models\Navbar;
use Illuminate\Http\Request;

class NavbarController extends Controller
{
    
    /**
     * get all routes
     */
    public function index()
    {
        return Navbar::select('id', 'name', 'title', 'route')->get()->keyBy('name');
    }
}
