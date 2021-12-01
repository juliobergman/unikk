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

class EtlIncomeController extends Controller
{

        protected $rfields;

        protected $levels = ['lvl1','lvl2','lvl3'];
        protected $ck = [
            'jan' => ['month_name_short','jan'],
            'feb' => ['month_name_short','feb'],
            'mar' => ['month_name_short','mar'],
            'qr1' => ['quarter',1],
            'apr' => ['month_name_short','apr'],
            'may' => ['month_name_short','may'],
            'jun' => ['month_name_short','jun'],
            'qr2' => ['quarter',2],
            'jul' => ['month_name_short','jul'],
            'aug' => ['month_name_short','aug'],
            'sep' => ['month_name_short','sep'],
            'qr3' => ['quarter',3],
            'oct' => ['month_name_short','oct'],
            'nov' => ['month_name_short','nov'],
            'dec' => ['month_name_short','dec'],
            'qr4' => ['quarter',4],
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
                    DB::raw('sum(amount) as total_amount')
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

        protected function group($request, $group, $lvl)
        {

            DB::statement(DB::raw('set @lvl="'.$lvl.'"'));

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
            array_push($structure_select[$lvl], DB::raw('@lvl as lvl'));
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

        protected function process_income(Request $request, $lvl, $report)
        {
            $groups = CodeGroup::where('type','income')->orderBy('oby', 'asc')->get();

            $key = 1;
            foreach ($this->ck as $selector => $value) {
                $payload[$selector] = 0;
            }

            foreach ($groups as $group) {

                $data = $this->facts($request, $group->id, $lvl, $report);
                $build = $this->group($request, $group->id, $lvl);

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

                // Payload
                foreach ($this->ck as $selector => $where) {
                    $payload[$selector] += $data->where($where[0], '=', $where[1])->sum('total_amount');;
                }

                $result[$key]['row'] = $key;
                $result[$key]['result_field'] = $this->result_field($group->name);
                $result[$key]['lvl'] = $lvl;
                $result[$key]['category_id'] = null;
                $result[$key]['branch'] = null;
                $result[$key]['row_class'] = 'result-row';
                $result[$key]['name'] = $group->name;

                foreach ($this->ck as $selector => $where) {
                    $result[$key][$selector] = $payload[$selector];
                }

                $result[$key]['hidden'] = 0;

                $key++;
            }


            // Second Part of Report

            // Dividers
            foreach (array_keys($result[1]) as $divkey) {
                $result[$key][$divkey] = null;
            }
            $result[$key]['row'] = $key;
            $result[$key]['row_class'] = 'divider';
            $result[$key]['hidden'] = 0;
            $key++;

            $extra_rows = ['EBIT' => 6,'EBITDA' => 5];

            foreach ($extra_rows as $name => $row) {

                $er_data = collect($result)->where('category_id', '=', $row);

                foreach ($er_data as $value) {
                        $hiderow = 1;

                        $result[$key]['row'] = $key;
                        $result[$key]['result_field'] = $this->result_field($value['name']);
                        $result[$key]['lvl'] = $lvl;
                        $result[$key]['category_id'] = $value['category_id'];
                        $result[$key]['branch'] = $value['branch'];
                        $result[$key]['row_class'] = 'data-row';
                        $result[$key]['name'] = $value['name'];

                        foreach ($this->ck as $k => $v) {
                            if($value[$k]){ $hiderow = 0; }
                            $result[$key][$k] = $value[$k] * -1;
                            $payload[$k] += $value[$k] * -1;
                        }

                        $result[$key]['hidden'] = $hiderow;


                        $key++;
                    }

                    $result[$key]['row'] = $key;
                    $result[$key]['result_field'] = $this->result_field($name);
                    $result[$key]['lvl'] = $lvl;
                    $result[$key]['category_id'] = null;
                    $result[$key]['branch'] = null;
                    $result[$key]['row_class'] = 'result-row';
                    $result[$key]['name'] = $name;

                    foreach ($this->ck as $k => $v) {
                        $result[$key][$k] = $payload[$k];
                    }

                    $result[$key]['hidden'] = 0;

                $key++;
            }

            return $result;

        }

        public function extract(Request $request)
        {
            $this->ck['yar'] = ['year', $request->year];
            $this->rfields = Result::all();
            $reports = Report::where('type', 'income')->get();

            $result = [];
            foreach ($reports as $report) {
                $rep = [];
                foreach ($this->levels as $klvl => $level) {
                    $lvl_data = $this->process_income($request, $level, $report);
                    // $lvl_data = $this->process_income($request, 'lvl1', $report);

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
                'hidden',
            ];

            $compare = [
                'year',
                'company_id',
                'lvl',
                'report_id',
            ];

            $ret = DB::table('data_warehouse')->upsert($upsert, $compare, $colUpdate);
            // Response
            return new JsonResponse(['message' => 'Success', 'rows' => $ret], 200);
        }
}
