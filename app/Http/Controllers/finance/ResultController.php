<?php

namespace App\Http\Controllers\finance;

use Illuminate\Http\Request;
use App\Models\finance\Result;
use App\Http\Controllers\Controller;
use App\Models\finance\DataWarehouse;

class ResultController extends Controller
{


    protected $ck = [
        'jan',
        'feb',
        'mar',
        // 'qr1',
        'apr',
        'may',
        'jun',
        // 'qr2',
        'jul',
        'aug',
        'sep',
        // 'qr3',
        'oct',
        'nov',
        'dec',
        // 'qr4',
        // 'yar',
    ];

    protected function sparklines()
    {
        $sparklines = Result::query();
        $sparklines->where('sparkline', 'yes');
        return $sparklines->get();
    }

    public function index()
    {
        return Result::all();
    }

    public function spark(Request $request)
    {
        $month_lenght = date('n');
        $month_offset = 0;
        $months = array_slice($this->ck, $month_offset, $month_lenght);

        $sparklines = $this->sparklines();


        $wherin = [];
        foreach ($sparklines as $sparkline) {
            $wherin[] = $sparkline->id;
        }

        $dw = DataWarehouse::query();

        $dw->where('result_field', '!=', null);
        $dw->where('company_id', $request->company);
        $dw->where('year', $request->year);
        $dw->whereIn('result_field', $wherin);
        $dw->whereIn('report_id', [1,3,5]);
        $dw->groupBy('result_field');
        $data = $dw->get();

        $ret = [];
        foreach ($data as $key => $sparkline) {
            $ret[$key]['id'] = $key+1;
            $ret[$key]['name'] = $sparkline->name;
            // Values
            foreach ($months as $k => $val) {
                $ret[$key]['labels'][$k] = strtoupper($val);
                // $ret[$key]['value'][$k] = (float)$sparkline[$val];
                $ret[$key]['value'][$k] = (float)rand(100,2000);
            }
        }

        return $ret;
    }

    public function data(Request $request)
    {
        $month_lenght = date('n');
        $month_offset = 0;
        $months = array_slice($this->ck, $month_offset, $month_lenght);

        $list = Result::query();
        $results = $list->get();

        $wherin = [];
        foreach ($results as $result) {
            $wherin[] = $result->id;
        }

        $dw = DataWarehouse::query();
        $dw->where('result_field', '!=', null);
        $dw->where('company_id', $request->company);
        $dw->where('year', $request->year);
        $dw->whereIn('result_field', $wherin);
        $dw->whereIn('report_id', [1,3,5]);
        $dw->groupBy('result_field');
        $data = $dw->get();

        $month = $this->ck[(date('n') - 2)];

        $ret = [];
        foreach ($data as $key => $value) {
            $ret[$key]['id'] = $value->result_field;
            $ret[$key]['name'] = $value->name;
            $ret[$key]['month_name'] = $month;
            $ret[$key]['format'] = $value->format;
            // $ret[$key]['amount'] = (float)$value->$month;
            $ret[$key]['amount'] = (float)rand(10000,50000);

            // Values
            foreach ($months as $k => $val) {
                $ret[$key]['labels'][$k] = strtoupper($val);
                // $ret[$key]['value'][$k] = (float)$value[$val];
                $ret[$key]['value'][$k] = (float)rand(100,2000);
            }


        }

        return $ret;

    }


}
