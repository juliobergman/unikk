<?php

namespace App\Http\Controllers\finance;

use App\Models\finance\Code;
use App\Models\finance\Fact;
use Illuminate\Http\Request;
use App\Models\finance\Report;
use App\Models\finance\Result;
use App\Models\finance\CodeGroup;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EtlBalanceController extends Controller
{

    protected $rfields;

    protected $levels = ['lvl1','lvl2','lvl3'];
    protected $ck = [
        'jan' => ['month_name_short','jan'],
        'feb' => ['month_name_short','feb'],
        'mar' => ['month_name_short','mar'],
        'qr1' => ['month_name_short','mar'],
        'apr' => ['month_name_short','apr'],
        'may' => ['month_name_short','may'],
        'jun' => ['month_name_short','jun'],
        'qr2' => ['month_name_short','jun'],
        'jul' => ['month_name_short','jul'],
        'aug' => ['month_name_short','aug'],
        'sep' => ['month_name_short','sep'],
        'qr3' => ['month_name_short','sep'],
        'oct' => ['month_name_short','oct'],
        'nov' => ['month_name_short','nov'],
        'dec' => ['month_name_short','dec'],
        'qr4' => ['month_name_short','dec'],
        'yar' => ['year', null],
    ];

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

        // Extract, Transform and Load
        protected function facts($request, $group, $lvl, $report)
        {
            $data_select = [
                'lvl1' => [
                    'code_groups.id as group_id',
                    'code_groups.name as group',
                    'parents.name AS name',
                    'month',
                    'month_name',
                    'month_name_short',
                    'quarter',
                    'quarter_name',
                    'year',
                    DB::raw('SUM(amount) as total_amount')
                ],
                'lvl2' => [
                    'code_groups.id as group_id',
                    'code_groups.name as group',
                    'code_categories.name AS name',
                    'month',
                    'month_name',
                    'month_name_short',
                    'quarter',
                    'quarter_name',
                    'year',
                    DB::raw('SUM(amount) as total_amount')
                ],
                'lvl3' => [
                    'code_groups.id as group_id',
                    'code_groups.name as group',
                    'codes.name AS name',
                    'month',
                    'month_name',
                    'month_name_short',
                    'quarter',
                    'quarter_name',
                    'year',
                    DB::raw('SUM(amount) as total_amount')
                ]
            ];

            $facts = Fact::query();
            $facts->where('facts.company_id', $request->company);
            $facts->where('facts.report_id', $report->id);
            $facts->whereHas('date', function ($query) use ($request) {
                $query->whereYear('date', $request->year);
            });
            // Selects
            $facts->select($data_select[$lvl]);
            $facts->where('codes.group', $group);
            // Joins
            $facts->join('codes', 'facts.code_id', '=', 'codes.id');
            $facts->join('date_dimensions as date', 'facts.date', '=', 'date.date');
            $facts->join('code_categories', 'codes.code_category_id', '=', 'code_categories.id');
            $facts->join('code_categories as parents', 'parents.id', '=', 'code_categories.parent');
            $facts->join('code_groups', 'code_groups.id', '=', 'codes.group');
            // Groups
            $facts->groupBy('name','month');
            // Order
            $facts->orderBy('codes.oby');
            $data = $facts->get();

            return $data;

        }

        protected function process_group($request, $group, $lvl)
        {
            $structure_select = [
                'lvl1' => [
                    'parents.id AS branch_id',
                    'parents.name AS branch',
                    'parents.name AS name',
                ],
                'lvl2' => [
                    'parents.id AS branch_id',
                    'parents.name AS branch',
                    'code_categories.name AS name',
                ],
                'lvl3' => [
                    'parents.id AS branch_id',
                    'parents.name AS branch',
                    'codes.name as name',
                ]
            ];

            $schema = Code::query();
            $schema->where('group', $group);
            // Selects
            $schema->select($structure_select[$lvl]);
            // Joins
            $schema->join('code_categories', 'code_categories.id', '=', 'codes.code_category_id');
            $schema->join('code_categories as parents', 'parents.id', '=', 'code_categories.parent');
            $schema->join('code_groups', 'code_groups.id', '=', 'codes.group');
            // Groups
            $schema->groupBy('name');
            // Order
            $schema->orderBy('codes.oby');
            // Get
            return $schema->get();
        }

        protected function process_balance(Request $request, $lvl, $report)
        {
            $groups = CodeGroup::where('type','balance')->orderBy('oby', 'asc')->get();

            $key = 1;
            foreach ($this->ck as $selector => $value) {
                $payload[$selector] = 0;
                $payload_assets[$selector] = 0;
                $payload_liabilities[$selector] = 0;
                $payload_equity[$selector] = 0;
            }

            foreach ($groups as $group) {

                $data = $this->facts($request, $group->id, $lvl, $report);
                $build = $this->process_group($request, $group->id, $lvl);

                foreach ($build as $value) {
                    $hiderow = 1;

                    $result[$key]['row'] = $key;
                    $result[$key]['result_field'] = $this->result_field($value->name);
                    $result[$key]['lvl'] = $lvl;
                    $result[$key]['category_id'] = $value->branch_id;
                    $result[$key]['branch'] = $value->branch;
                    $result[$key]['row_class'] = 'data-row';
                    $result[$key]['name'] = $value->name;

                    foreach ($this->ck as $selector => $where) {
                        $values = $data->where('name', '=', $value->name)->where($where[0], '=', $where[1])->sum('total_amount');
                        if($values){ $hiderow = 0; }
                        $result[$key][$selector] = $values;
                    }
                    $result[$key]['hidden'] = $hiderow;
                    $key++;

                }

                // Total Row
                if ($lvl != 'lvl1') {

                    $result[$key]['row'] = $key;
                    $result[$key]['result_field'] = $this->result_field($group->name);
                    $result[$key]['lvl'] = $lvl;
                    $result[$key]['category_id'] = null;
                    $result[$key]['branch'] = null;
                    $result[$key]['row_class'] = 'result-row';
                    $result[$key]['name'] = $group->name;

                    foreach ($this->ck as $selector => $where) {
                        $result[$key][$selector] = $data->where($where[0], '=', $where[1])->sum('total_amount');
                    }
                    $result[$key]['hidden'] = 0;

                    $key++;
                }

                // Payload
                foreach ($this->ck as $selector => $where) {
                    $payload[$selector] = $data->where($where[0], '=', $where[1])->sum('total_amount');
                    if ($group->id == 5 || $group->id == 6) {
                        $payload_assets[$selector] += $data->where($where[0], '=', $where[1])->sum('total_amount');
                    }
                    if ($group->id == 7 || $group->id == 8) {
                        $payload_liabilities[$selector] += $data->where($where[0], '=', $where[1])->sum('total_amount');
                    }
                    if ($group->id == 9) {
                        $payload_equity[$selector] += $data->where($where[0], '=', $where[1])->sum('total_amount');
                    }
                }

                if ($group->id == 6) {

                    $result[$key]['row'] = $key;
                    $result[$key]['result_field'] = $this->result_field('Total Assets');
                    $result[$key]['lvl'] = $lvl;
                    $result[$key]['category_id'] = null;
                    $result[$key]['branch'] = null;
                    $result[$key]['row_class'] = 'result-row';
                    $result[$key]['name'] = 'Total Assets';

                    foreach ($this->ck as $selector => $where) {
                        $result[$key][$selector] = $payload_assets[$selector];
                    }
                    $result[$key]['hidden'] = 0;
                    $key++;
                }

                if ($group->id == 8) {

                    $result[$key]['row'] = $key;
                    $result[$key]['result_field'] = $this->result_field('Total Liabilities');
                    $result[$key]['lvl'] = $lvl;
                    $result[$key]['category_id'] = null;
                    $result[$key]['branch'] = null;
                    $result[$key]['row_class'] = 'result-row';
                    $result[$key]['name'] = 'Total Liabilities';

                    foreach ($this->ck as $selector => $where) {
                        $result[$key][$selector] = $payload_liabilities[$selector];
                    }
                    $result[$key]['hidden'] = 0;
                    $key++;
                }

                if ($group->id == 9) {

                    $result[$key]['row'] = $key;
                    $result[$key]['result_field'] = $this->result_field('Total Liabilities + Equity');
                    $result[$key]['lvl'] = $lvl;
                    $result[$key]['category_id'] = null;
                    $result[$key]['branch'] = null;
                    $result[$key]['row_class'] = 'result-row';
                    $result[$key]['name'] = 'Total Liabilities + Equity';

                    foreach ($this->ck as $selector => $where) {
                        $result[$key][$selector] = $payload_liabilities[$selector] + $payload_equity[$selector];
                    }
                    $result[$key]['hidden'] = 0;
                    $key++;
                }
            }

            // $key++;

            return $result;

        }

        public function extract(Request $request)
        {
            $this->ck['yar'] = ['year', $request->year];
            $this->rfields = Result::all();
            $reports = Report::where('type', 'balance')->get();

            $result = [];
            foreach ($reports as $report) {
                $rep = [];
                foreach ($this->levels as $klvl => $level) {
                    $lvl_data = $this->process_balance($request, $level, $report);

                    $rep[$klvl] = $lvl_data;

                    // Common Data
                    foreach ($rep[$klvl] as $cdk => $nonuse) {
                        $rep[$klvl][$cdk]['year'] = $request->year;
                        $rep[$klvl][$cdk]['company_id'] = $request->company;
                        $rep[$klvl][$cdk]['report_id'] = $report->id;
                        $rep[$klvl][$cdk]['report_type'] = $report->type;
                        $rep[$klvl][$cdk]['report_af'] = $report->af;
                    }

                    $result[$report->id] = $rep;
                }
            }

            $merged = [];
            foreach ($result as $value) {
                $merged = array_merge($merged, $value);
            }

            $upsert = [];
            foreach ($merged as $value) {
                $upsert = array_merge($upsert, $value);
            }

            $upsert = array_values($upsert);

            // Columns to Update
            $colUpdate = [
                'row',
                'jan',
                'feb',
                'mar',
                'qr1',
                'apr',
                'may',
                'jun',
                'qr2',
                'jul',
                'aug',
                'sep',
                'qr3',
                'oct',
                'nov',
                'dec',
                'qr4',
                'yar',
                'hidden'
            ];

            $compare = [
                'year',
                'company_id',
                'lvl',
                'report_id',
            ];

            // return $upsert;

            $ret = DB::table('data_warehouse')->upsert($upsert, $compare, $colUpdate);
            // Response
            return new JsonResponse(['message' => 'Success', 'rows' => $ret], 200);
        }
}
