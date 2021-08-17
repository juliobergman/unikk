<?php

namespace App\Http\Controllers\finance;

use App\Http\Controllers\Controller;
use App\Models\finance\DataWarehouse;
use Illuminate\Http\Request;

class DataWarehouseController extends Controller
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

    public function cfields(Request $request)
    {
        $field_data = DataWarehouse::query();
        $field_data->where('name','!=', null);
        $field_data->where('lvl', 'lvl1');
        $field_data->select('name','report_type');
        $field_data->groupBy('name');
        $field_data->orderBy('name','asc');
        $data = $field_data->get();

        return $data;

    }

    public function cdata(Request $request)
    {

        $report = DataWarehouse::query();
        $report->join('reports', 'data_warehouse.report_id', '=', 'reports.id');
        $report->select(['data_warehouse.*', 'reports.af']);
        $report->where('year', $request->year);
        $report->where('company_id', $request->company);
        $report->where('data_warehouse.result_field', $request->branch['id']);
        $report->where('data_warehouse.report_type', $request->branch['report_type']);
        $report->where('lvl', 'lvl1');
        $report->orderBy('row');

        $data = $report->get()->take(2);

        $cdata = [];

        // Labels
        foreach ($this->ck as $key => $value) {
            $cdata['labels'][$key] = strtoupper($value);
        }
        // Colors
        $colors = [
            'rgba(88, 149, 255, 0.5)',
            'rgba(88, 255, 177, 0.5)',
            'rgba(0, 0, 0, 0.8)',
        ];
        $colorKey = 0;

        // ChartData
        foreach ($data as $key => $value) {
            if($colorKey >= count($colors)){ $colorKey = 0; }
            $cdata['datasets'][$key]['label'] = ucwords($value['af']);
            $cdata['datasets'][$key]['backgroundColor'] = $colors[$colorKey];
            foreach ($this->ck as $k => $v) {
                // $cdata['datasets'][$key]['data'][$k] = (float)$value[$v];
                $cdata['datasets'][$key]['data'][$k] = (float)rand(1000,1505);
            }
            $colorKey++;
        }

        return $cdata;




    }
}
