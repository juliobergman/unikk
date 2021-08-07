<?php

namespace App\Http\Controllers\finance;

use App\Http\Controllers\Controller;
use App\Models\finance\DateDimension;
use Illuminate\Http\Request;

class DateDimensionController extends Controller
{

    public function show(Request $request)
    {
        $date = DateDimension::query();
        $date->whereMonth('date', '09');
        return $date->get();
    }

    public function years()
    {
        $date = DateDimension::query();
        $date->select('year');
        $date->groupBy('year');
        return $date->get();
    }
}
