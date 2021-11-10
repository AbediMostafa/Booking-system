<?php

namespace App\Http\Controllers;

use App\Classes\Pagination;
use App\Http\Resources\cities\CitiesResource;
use App\Models\City;
use Illuminate\Http\Request;

class CitiesController extends Controller
{
    public function index()
    {
        return CitiesResource::collection(City::paginate(Pagination::$cityPaginateCount));
    }
}
