<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        return view('index');
    }

    public function dashboard(): View
    {
        $cities = Auth::user()->cities()->get();

        return view('dashboard')->with([
            'cities' => $cities,
        ]);
    }

    public function city(City $city): View
    {
        // TODO: Auth

        return view('city')->with([
            'city' => $city,
        ]);
    }
}
