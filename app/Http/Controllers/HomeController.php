<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SeatMap;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
     
        $maps = SeatMap::getSeatMap($request->search,$request->page);
        return view('home',['maps'=>$maps]);
    }
}
