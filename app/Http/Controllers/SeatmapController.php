<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SeatmapController extends Controller
{
    /**
     * Load homepage
     */
    public function index()
    {
        return view('welcome');
    }
    /**
     * Load detail page
     */
    public function detail(int $seatmap_id)
    {
        return 'Detail page.';
    }
    /**
     * Load add seat map page
     */
    public function getAddSeatmapPage()
    {
        return 'Load add seat map page';
    }

    /**
     * Handle add group request submit
     */
    public function addGroupHandler( Request $request)
    {
        return 'Handle add group request';
    }

    /**
     * Load add seat map page
     */
    public function getEditSeatmapPage()
    {
        return 'Load edit seat map page';
    }
    
    /**
     * Handle edit group request submit
     */
    public function editGroupHandler( Request $request)
    {
        return 'Handle edit group request';
    }

    /**
     * Handle delete group request submit
     */
    public function deleteGroupHandler( Request $request)
    {
        return 'Handle delete group request';
    }
}
