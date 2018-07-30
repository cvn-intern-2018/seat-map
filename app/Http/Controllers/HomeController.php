<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;
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
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
    {
        $request->validate([
            'title' => 'bail|required|unique:posts|max:255',
            'page' => 'r',
        ]);
        $maps = SeatMap::getSeatMap($request->search, $request->page);
        return view('home', ['maps' => $maps->appends(Input::except('page')), 'search' => $request->search]);
    }
}
