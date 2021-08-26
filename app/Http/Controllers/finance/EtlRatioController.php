<?php

namespace App\Http\Controllers\finance;

use App\Models\Settings;
use Illuminate\Http\Request;
use App\Models\finance\Report;
use App\Models\finance\Result;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\finance\DataWarehouse;

class EtlRatioController extends Controller
{

    protected $rfields;

    protected function result_field($name)
    {

        $resfield = $this->rfields->where('name', '=', $name)->first();
        if(is_object($resfield)){
            $res = $resfield->id;
        } else {
            $res = null;
        }
        return $res;
    }

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
        'yar',
    ];



    protected function divide($a,$b)
    {
        if($b == 0){
            $result = 0;
        } else {
            $result = $a / $b;
        }
        return (float)$result;
    }

    protected function minus($a,$b)
    {
        return (float)($a - $b);
    }

    protected function cash_ratio($a,$b,$c)
    {
        if($c == 0){
            $result = 0;
        } else {
            $result = ($a + $b) / $c;
        }
        return (float)$result;
    }

    protected function percentage($a,$b)
    {
        if($b == 0){
            $result = 0;
        } else {
            $result = ($a / $b) * 100;
        }
        return (float)$result;
    }

    protected function nopat($a,$b)
    {
        $c = $b / 100;
        return $a * (1 - $c);
    }

    protected function roic($a,$b,$c,$d)
    {
        $divider = ($b + $c) - $d;
        if($divider == 0){
            return 0;
        } else {
            return ($a / $divider) * 100;
        }
    }


    protected function process_ratio($request, $af)
    {

        // Result Field Data
        $this->rfields = Result::all();

        $reports = [
            'actual' => [1,3],
            'forecast' => [2,4]
        ];
        $repratio = [
            'actual' => 5,
            'forecast' => 6
        ];

        $dw = DataWarehouse::query();
        $dw->where('company_id', $request->company);
        $dw->where('year', $request->year);
        $dw->whereIn('report_id', $reports[$af]);
        $data = $dw->get();


        if (!count($data)) {
            return new JsonResponse([], 200);
        }

        $search_vars = [
            'Income',
            'Gross Profit',
            'Operative Income',
            'Interest expenses on loans',
            'Net Income',
            'EBITDA',
            'EBIT',
            'Cash and cash equivalents',
            'Short-term Assets listed Stock Exchange',
            'Total Current Assets',
            'Short-term Liabilites',
            'Total Liabilities',
            'Total Equity',
        ];

        $frs = [
            'Current Ratio',
            'Working Capital',
            'Cash Ratio',
            'Net Income (%)',
            'Net Income',
            'Gross Profit (%)',
            'Gross Profit',
            'Return on equity',
            'EBITDA',
            'EBITDA',
            'Debt to equity',
            'Interest coverage',
            'NOPAT',
            'ROIC',
            'Adjusted Equity',
            'Book Value per share',
        ];

        $vars = array();
        foreach ($search_vars as $key => $var_name) {
            $vkey = strtolower(preg_replace("/[^a-zA-Z]+/", "_", $var_name));
            $vars[$vkey] = $data->where('name', '=', $var_name)->first();
        }


        if (in_array(null, $vars, true)) {
            return response()->json([], 200);
        }

        // effective_tax_rate
        // number_of_shares

        $constants = Settings::where('company_id', $request->company)->where('selector', 'financial_ratio')->get();
        foreach ($constants as $e) {
            $ckey = strtolower(preg_replace("/[^a-zA-Z]+/", "_", $e->name));
            if ($e->type == 'float') {
                $constant[$ckey] = (float)$e->value;
            } else {
                $constant[$ckey] = $e->value;
            }
        }

        // Builds

        $hiderow = 1;
        $ratio['name'] = 'Current Ratio';
        foreach ($this->ck as $col) {
            $ratio[$col] = $this->divide(
                $vars['total_current_assets'][$col],
                $vars['short_term_liabilites'][$col]
            );
            if($ratio[$col]){ $hiderow = 0; }
        }
        $ratio['result_field'] = $this->result_field($ratio['name']);
        $ratio['format'] = 'number';
        $ratio['hidden'] = $hiderow;
        $return[] = $ratio;





        $hiderow = 1;
        $ratio['name'] = 'Working Capital';
        foreach ($this->ck as $col) {
            $ratio[$col] = $vars['total_current_assets'][$col] - $vars['short_term_liabilites'][$col];
            if($ratio[$col]){ $hiderow = 0; }
        }
        $ratio['result_field'] = $this->result_field($ratio['name']);
        $ratio['format'] = 'currency';
        $ratio['hidden'] = $hiderow;
        $return[] = $ratio;



        $hiderow = 1;
        $ratio['name'] = 'Cash Ratio';
        foreach ($this->ck as $col) {
            $ratio[$col] = $this->cash_ratio(
                $vars['cash_and_cash_equivalents'][$col],
                $vars['short_term_assets_listed_stock_exchange'][$col],
                $vars['short_term_liabilites'][$col]
            );
            if($ratio[$col]){ $hiderow = 0; }
        }
        $ratio['result_field'] = $this->result_field($ratio['name']);
        $ratio['format'] = 'number';
        $ratio['hidden'] = $hiderow;
        $return[] = $ratio;


        $hiderow = 1;
        $ratio['name'] = 'Net Income (%)';
        foreach ($this->ck as $col) {
            $ratio[$col] = $this->percentage(
                $vars['net_income'][$col],
                $vars['income'][$col]
            );
            if($ratio[$col]){ $hiderow = 0; }
        }
        $ratio['result_field'] = $this->result_field($ratio['name']);
        $ratio['format'] = 'percentage';
        $ratio['hidden'] = $hiderow;
        $return[] = $ratio;



        $hiderow = 1;
        $ratio['name'] = 'Net Income';
        foreach ($this->ck as $col) {
            $ratio[$col] = (float)$vars['net_income'][$col];
            if($ratio[$col]){ $hiderow = 0; }
        }
        $ratio['result_field'] = $this->result_field($ratio['name']);
        $ratio['format'] = 'currency';
        $ratio['hidden'] = $hiderow;
        $return[] = $ratio;



        $hiderow = 1;
        $ratio['name'] = 'Gross Profit (%)';
        foreach ($this->ck as $col) {
            $ratio[$col] = $this->percentage(
                $vars['gross_profit'][$col],
                $vars['income'][$col]
            );
            if($ratio[$col]){ $hiderow = 0; }
        }
        $ratio['result_field'] = $this->result_field($ratio['name']);
        $ratio['format'] = 'percentage';
        $ratio['hidden'] = $hiderow;
        $return[] = $ratio;



        $hiderow = 1;
        $ratio['name'] = 'Gross Profit';
        foreach ($this->ck as $col) {
            $ratio[$col] = (float)$vars['gross_profit'][$col];
            if($ratio[$col]){ $hiderow = 0; }
        }
        $ratio['result_field'] = $this->result_field($ratio['name']);
        $ratio['format'] = 'currency';
        $ratio['hidden'] = $hiderow;
        $return[] = $ratio;



        $hiderow = 1;
        $ratio['name'] = 'Return on equity';
        foreach ($this->ck as $col) {
            $ratio[$col] = $this->percentage(
                $vars['net_income'][$col],
                $vars['total_equity'][$col]
            );
            if($ratio[$col]){ $hiderow = 0; }
        }
        $ratio['result_field'] = $this->result_field($ratio['name']);
        $ratio['format'] = 'percentage';
        $ratio['hidden'] = $hiderow;
        $return[] = $ratio;



        $hiderow = 1;
        $ratio['name'] = 'EBITDA (%)';
        foreach ($this->ck as $col) {
            $ratio[$col] = $this->percentage(
                $vars['ebitda'][$col],
                $vars['income'][$col]
            );
            if($ratio[$col]){ $hiderow = 0; }
        }
        $ratio['result_field'] = $this->result_field($ratio['name']);
        $ratio['format'] = 'percentage';
        $ratio['hidden'] = $hiderow;
        $return[] = $ratio;



        $hiderow = 1;
        $ratio['name'] = 'EBITDA';
        foreach ($this->ck as $col) {
            $ratio[$col] = (float)$vars['ebitda'][$col];
            if($ratio[$col]){ $hiderow = 0; }
        }
        $ratio['result_field'] = $this->result_field($ratio['name']);
        $ratio['format'] = 'currency';
        $ratio['hidden'] = $hiderow;
        $return[] = $ratio;



        $hiderow = 1;
        $ratio['name'] = 'Debt to Equity';
        foreach ($this->ck as $col) {
            $ratio[$col] = $this->divide(
                $vars['total_liabilities'][$col],
                $vars['total_equity'][$col]
            );
            if($ratio[$col]){ $hiderow = 0; }
        }
        $ratio['result_field'] = $this->result_field($ratio['name']);
        $ratio['format'] = 'number';
        $ratio['hidden'] = $hiderow;
        $return[] = $ratio;



        $hiderow = 1;
        $ratio['name'] = 'Interest coverage';
        foreach ($this->ck as $col) {
            $ratio[$col] = $this->divide(
                $vars['ebit'][$col],
                $vars['interest_expenses_on_loans'][$col]
            );
            if($ratio[$col]){ $hiderow = 0; }
        }
        $ratio['result_field'] = $this->result_field($ratio['name']);
        $ratio['format'] = 'number';
        $ratio['hidden'] = $hiderow;
        $return[] = $ratio;



        $hiderow = 1;
        // Calculated Variables - NOPAT
        $ratio['name'] = 'NOPAT';
        foreach ($this->ck as $col) {
            $operation = $this->nopat(
                $vars['operative_income'][$col],
                $constant['effective_tax_rate']
            );

            $ratio[$col] = $operation;
            if($ratio[$col]){ $hiderow = 0; }
            $calculated['nopat'][$col] = $operation;
        }
        unset($operation);
        $ratio['result_field'] = $this->result_field($ratio['name']);
        $ratio['format'] = 'currency';
        $ratio['hidden'] = $hiderow;
        $return[] = $ratio;



        $hiderow = 1;
        // Calculated Variables - ROIC
        $ratio['name'] = 'ROIC';
        foreach ($this->ck as $col) {
            $operation = $this->roic(
                $calculated['nopat'][$col],
                $vars['total_liabilities'][$col],
                $vars['total_equity'][$col],
                $vars['cash_and_cash_equivalents'][$col]
            );

            $ratio[$col] = $operation;
            if($ratio[$col]){ $hiderow = 0; }
            $calculated['roic'][$col] = $operation;
        }
        unset($operation);
        $ratio['result_field'] = $this->result_field($ratio['name']);
        $ratio['format'] = 'percentage';
        $ratio['hidden'] = $hiderow;
        $return[] = $ratio;



        $hiderow = 1;
        // Calculated Variables - Adjusted Equity
        $ratio['name'] = 'Adjusted Equity';
        foreach ($this->ck as $col) {
            $operation = array_sum([
                $vars['total_equity'][$col],
                $vars['net_income'][$col]
            ]);
            $ratio[$col] = $operation;
            if($ratio[$col]){ $hiderow = 0; }
            $calculated['adjusted_equity'][$col] = $operation;
        }
        $ratio['result_field'] = $this->result_field($ratio['name']);
        $ratio['format'] = 'currency';
        $ratio['hidden'] = $hiderow;
        $return[] = $ratio;



        $hiderow = 1;
        // Calculated Variables - Book Value per Share
        $ratio['name'] = 'Book Value per Share';
        foreach ($this->ck as $col) {
            $operation = $this->divide(
                $calculated['adjusted_equity'][$col],
                $constant['number_of_shares']
            );
            $ratio[$col] = $operation;
            if($ratio[$col]){ $hiderow = 0; }
            $calculated['bvps'][$col] = $operation;
        }
        $ratio['result_field'] = $this->result_field($ratio['name']);
        $ratio['format'] = 'currency';
        $ratio['hidden'] = $hiderow;
        $return[] = $ratio;




        // Shared & Aditional Information
        foreach ($return as $key => $value) {
            $return[$key]['row'] = ($key +1);
            $return[$key]['year'] = $request->year;
            $return[$key]['lvl'] = 'lvl1';
            $return[$key]['company_id'] = $request->company;
            $return[$key]['report_id'] = $repratio[$af];
            $return[$key]['report_type'] = 'ratio';
            $return[$key]['row_class'] = 'data-row';
            $return[$key]['branch'] = null;
            $return[$key]['category_id'] = null;
        }

        // Upsert DataBase

        // Columns to Update
        $colUpdate = [
            'row',
            'result_field',
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
            'yar',
            'hidden'
        ];

        $compare = [
            'year',
            'company_id',
            'lvl',
            'report_id',
        ];

        return DB::table('data_warehouse')->upsert($return, $compare, $colUpdate);

    }

    public function extract(Request $request)
    {
        $reports = ['actual','forecast'];

        $ret = 0;
        foreach ($reports as $report) {
            $ret += $this->process_ratio($request, $report);
        }

        // Response
        return new JsonResponse(['message' => 'Success', 'rows' => $ret], 200);
    }

}
