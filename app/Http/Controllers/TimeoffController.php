<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimeoffController extends Controller
{
    function timeofflist()
    {
        $activeMenu = 'admin';

    	return view('timeoff.index', compact('activeMenu'));
    }
}
