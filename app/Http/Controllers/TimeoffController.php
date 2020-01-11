<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TimeoffController extends Controller
{
    function timeofflist()
    {
    	return view('timeoff.index');
    }
}
