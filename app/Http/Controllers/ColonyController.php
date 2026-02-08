<?php

namespace App\Http\Controllers;

use App\Models\Colony;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class ColonyController extends Controller
{
    public function index(): View
    {
        $colonies = Auth::user()->colonies()->orderBy('created_at', 'DESC')->get();

        return view('colonies/index')->with([
            'colonies' => $colonies,
        ]);
    }

    public function show(Colony $colony): View
    {
        // TODO: Auth

        return view('colonies/show')->with([
            'colony' => $colony,
        ]);
    }
}
