<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\StandTemplate;

class StandController extends Controller
{
    public function index()
    {
       $templates = StandTemplate::with('stand', 'congregation', 'standPublishers.user')
                                 ->orderBy('day')
                                 ->get();

       return view('stand.index', ['templates' => $templates]);
    }
}
