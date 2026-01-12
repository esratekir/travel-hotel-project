<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Turlar;
use App\Models\TourProgram;

class TurController extends Controller
{
    public function ToursPage(){
        $tours = Turlar::latest()->paginate(5);
        return view('frontend.pages.tours_page', compact('tours'));
    }

    public function ToursDetails($id) {
        $tours = Turlar::findOrFail($id);
        $tour_program = TourProgram::where('tour_id', "=", $id)->get();
        return view('frontend.pages.tours_details_page', compact('tours','tour_program'));
    }
}
