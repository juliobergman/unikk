<?php

namespace App\Http\Controllers\finance;

use App\Http\Controllers\Controller;
use App\Models\finance\DataWarehouse;
use Illuminate\Http\Request;

class DataWarehouseController extends Controller
{
    public function report(Request $request)
    {
        $report = DataWarehouse::query();
        $report->where('year', $request->year);
        $report->where('company_id', $request->company);
        $report->where('lvl', $request->lvl);
        $report->where('report_id', $request->report);

        $report->orderBy('row','asc');


        return $report->get();

    }
}
