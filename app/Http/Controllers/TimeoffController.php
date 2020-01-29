<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimeoffController extends Controller
{
    function timeofflist()
    {
        if (auth()->user()->is_admin) {
            $activeMenu = 'admin';
        } else {
            $activeMenu = 'submit';
        }

    	return view('timeoff.index', compact('activeMenu'));
    }
}
