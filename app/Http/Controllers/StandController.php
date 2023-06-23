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
         ->orderBy('day')
         ->get(); 

      $templates = $templates->map(static function ($item) {
          $item->standPublishers = $item->standPublishers->keyBy('time');

          return $item;
      });  

       return view('stand.index', ['templates' => $templates]);
    }
}
