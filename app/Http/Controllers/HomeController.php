<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
use Illuminate\Http\Request;
use App\SeatMap;
use Lang;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $request->validate([
            'search' => 'max:100 | string| nullable',
        ]);
        $maps = SeatMap::getSeatMap($request->search, $request->page);
        $searchNoti =  Lang::get('notification.search');
        return view('home', ['maps' => $maps->appends(Input::except('page')), 'search' => $request->search,'searchNoti'=> $searchNoti]);
    }
}
