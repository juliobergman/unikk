<?php

namespace App\Http\Controllers\finance;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\finance\DataWarehouse;

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
        $report->where('hidden', false);
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
        $report->join('results', 'data_warehouse.result_field', '=', 'results.id');

        $report->select(['data_warehouse.*', 'reports.af','results.chart as chart']);

        $report->where('year', $request->year);
        $report->where('company_id', $request->company);
        $report->where('data_warehouse.result_field', $request->branch['id']);
        $report->where('data_warehouse.report_type', $request->branch['report_type']);
        $report->where('lvl', 'lvl1');
        $report->orderBy('row');

        $data = $report->get()->take(2);

        if(!count($data)){
            return new JsonResponse(['message' => 'No Data Found'], 204);
        }

        $cdata = [];

        $cdata['format'] = $data[0]['format'];
        // Labels
        foreach ($this->ck as $key => $value) {
            $cdata['labels'][$key] = strtoupper($value);
        }
        // Colors
        $colors = [
            'rgba(88, 149, 255, 0.9)',
            'rgba(88, 255, 177, 0.9)',
            'rgba(0, 0, 0, 0.8)',
            'rgba(0, 0, 0, 0.8)',
            'rgba(0, 0, 0, 0.8)',
        ];
        $colorKey = 0;

        // ChartData
        $cdata['tableheaders'][0]['text'] = '';
        $cdata['tableheaders'][0]['value'] = 'name';
        $cdata['tableheaders'][0]['format'] = null;
        foreach ($data as $key => $value) {
            if($colorKey >= count($colors)){ $colorKey = 0; }
            $cdata['datasets'][$key]['label'] = strtoupper($value['af']);
            $cdata['datasets'][$key]['backgroundColor'] = $colors[$colorKey];
            $cdata['tableitems'][$key]['name'] = ucwords($value['af']);
            foreach ($this->ck as $k => $v) {
                $cdata['datasets'][$key]['data'][$k] = (float)$value[$v];
                // $cdata['datasets'][$key]['data'][$k] = (float)rand(100,2000);
                $cdata['tableheaders'][$k+1]['text'] = strtoupper($v);
                $cdata['tableheaders'][$k+1]['value'] = $v;
                $cdata['tableheaders'][$k+1]['format'] = $data[0]['format'];
                $cdata['tableitems'][$key][$v] = $cdata['datasets'][$key]['data'][$k];
            }
            $colorKey++;

            // Table Header


        }

        return $cdata;




    }
}
