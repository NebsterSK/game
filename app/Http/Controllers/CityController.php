<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class CityController extends Controller
{
    public function index(): View
    {
        $cities = Auth::user()->cities()->orderBy('created_at', 'DESC')->get();

        return view('cities/index')->with([
            'cities' => $cities,
        ]);
    }

    public function show(City $city): View
    {
        // TODO: Auth

        return view('cities/show')->with([
            'city' => $city,
        ]);
    }
}
