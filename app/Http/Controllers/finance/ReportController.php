<?php

namespace App\Http\Controllers\finance;

use Carbon\CarbonPeriod;
use App\Models\finance\Code;
use App\Models\finance\Fact;
use Illuminate\Http\Request;
use App\Models\finance\Report;
use App\Models\finance\CodeGroup;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\finance\DateDimension;
use GrahamCampbell\ResultType\Result;
use PHPUnit\TextUI\XmlConfiguration\Groups;
use Illuminate\Database\Eloquent\Factories\Sequence;

class ReportController extends Controller
{
    public function index(Request $request)
    {
       $reports = Report::query();
       if($request->type){ $reports->where('type', $request->type); }
       if($request->not){ $reports->where('type', '!=', $request->not); }
       return $reports->get();
    }

    public function store(Request $request)
    {

    }

    public function show(Request $request)
    {
        return Report::where('id', $request->id)->first();
    }

    public function update(Request $request, Report $report)
    {
        //
    }

    public function destroy(Report $report)
    {
        //
    }
}
