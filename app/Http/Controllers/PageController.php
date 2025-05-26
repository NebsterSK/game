<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function index(): View
    {
        return view('index');
    }

    public function dashboard(): View
    {
        return view('dashboard');
    }

    public function game(): View
    {
        return view('game');
    }
}
