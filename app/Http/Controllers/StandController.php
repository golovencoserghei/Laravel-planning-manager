<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\StandTemplate;

class StandController extends Controller
{
    public function index()
    {
       $templates = StandTemplate::with([
           'stand',
           'standPublishers.user',
           'standPublishers.user2',
           'congregation',
       ])
         ->groupBy(['stand_id', 'congregation_id'])
         ->get(); // `->get()` because model doesn't have `->map()` method

       $templates = $templates->map(static function ($relations) {
           $relations->standPublishers = $relations->standPublishers->keyBy(static function($standPublishers) {
               return $standPublishers->day . '_' . $standPublishers->time;
           });
 
           return $relations;
       });

       return view('stand.index', ['template' => $templates->first()]);
    }
}
