<?php

namespace App\Http\Controllers\finance;

use App\Models\finance\Code;
use App\Models\finance\Fact;
use Illuminate\Http\Request;
use App\Models\finance\CodeGroup;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EtlBalanceController extends Controller
{
        // Extract, Transform and Load
        protected function getgroup($request, $group, $lvl)
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
            $facts->where('facts.report_id', $request->report);
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

        protected function process_balance(Request $request, $lvl)
        {
            $groups = CodeGroup::where('type','balance')->orderBy('oby', 'asc')->get();

            $key = 1;
            $payload = [
                'jan'  => 0,
                'feb'  => 0,
                'mar'  => 0,
                'qr1'  => 0,
                'apr'  => 0,
                'may'  => 0,
                'jun'  => 0,
                'qr2'  => 0,
                'jul'  => 0,
                'aug'  => 0,
                'sep'  => 0,
                'qr3'  => 0,
                'oct'  => 0,
                'nov'  => 0,
                'dec'  => 0,
                'qr4'  => 0,
                'yar' => 0
            ];
            $payload_assets = [
                'jan'  => 0,
                'feb'  => 0,
                'mar'  => 0,
                'qr1'  => 0,
                'apr'  => 0,
                'may'  => 0,
                'jun'  => 0,
                'qr2'  => 0,
                'jul'  => 0,
                'aug'  => 0,
                'sep'  => 0,
                'qr3'  => 0,
                'oct'  => 0,
                'nov'  => 0,
                'dec'  => 0,
                'qr4'  => 0,
                'yar' => 0
            ];
            $payload_liabilities = [
                'jan'  => 0,
                'feb'  => 0,
                'mar'  => 0,
                'qr1'  => 0,
                'apr'  => 0,
                'may'  => 0,
                'jun'  => 0,
                'qr2'  => 0,
                'jul'  => 0,
                'aug'  => 0,
                'sep'  => 0,
                'qr3'  => 0,
                'oct'  => 0,
                'nov'  => 0,
                'dec'  => 0,
                'qr4'  => 0,
                'yar' => 0
            ];
            $payload_equity = [
                'jan'  => 0,
                'feb'  => 0,
                'mar'  => 0,
                'qr1'  => 0,
                'apr'  => 0,
                'may'  => 0,
                'jun'  => 0,
                'qr2'  => 0,
                'jul'  => 0,
                'aug'  => 0,
                'sep'  => 0,
                'qr3'  => 0,
                'oct'  => 0,
                'nov'  => 0,
                'dec'  => 0,
                'qr4'  => 0,
                'yar' => 0
            ];

            foreach ($groups as $group) {

                $data = $this->getgroup($request, $group->id, $lvl);
                $build = $this->process_group($request, $group->id, $lvl);

                foreach ($build as $value) {
                    $result[$key] = [
                        'row'  => $key,
                        'year' => $request->year,
                        'company_id' => $request->company,
                        'lvl' => $lvl,
                        'report_id' => $request->report,
                        'category_id'  => $value->branch_id,
                        'branch'  => $value->branch,
                        'row_class'  => 'data-row',
                        'name' => $value->name,
                        'jan' => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'jan')->sum('total_amount'),
                        'feb' => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'feb')->sum('total_amount'),
                        'mar' => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'mar')->sum('total_amount'),
                        'qr1' => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'mar')->sum('total_amount'),
                        'apr' => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'apr')->sum('total_amount'),
                        'may' => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'may')->sum('total_amount'),
                        'jun' => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'jun')->sum('total_amount'),
                        'qr2' => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'jun')->sum('total_amount'),
                        'jul' => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'jul')->sum('total_amount'),
                        'aug' => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'aug')->sum('total_amount'),
                        'sep' => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'sep')->sum('total_amount'),
                        'qr3' => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'sep')->sum('total_amount'),
                        'oct' => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'oct')->sum('total_amount'),
                        'nov' => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'nov')->sum('total_amount'),
                        'dec' => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'dec')->sum('total_amount'),
                        'qr4' => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'dec')->sum('total_amount'),
                        'yar' => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'dec')->sum('total_amount'),
                    ];
                    $current_branch = $value->branch;
                    $key++;
                }


                // Total Row
                if ($lvl != 'lvl1') {
                    $result[$key] = [
                        'row'  => $key,
                        'year' => $request->year,
                        'company_id' => $request->company,
                        'lvl' => $lvl,
                        'report_id' => $request->report,
                        'category_id'  => null,
                        'branch'  => null,
                        'row_class'  => 'result-row',
                        'name' => $group->name,
                        'jan' => $data->where('month_name_short', '=', 'jan')->sum('total_amount'),
                        'feb' => $data->where('month_name_short', '=', 'feb')->sum('total_amount'),
                        'mar' => $data->where('month_name_short', '=', 'mar')->sum('total_amount'),
                        'qr1' => $data->where('month_name_short', '=', 'mar')->sum('total_amount'),
                        'apr' => $data->where('month_name_short', '=', 'apr')->sum('total_amount'),
                        'may' => $data->where('month_name_short', '=', 'may')->sum('total_amount'),
                        'jun' => $data->where('month_name_short', '=', 'jun')->sum('total_amount'),
                        'qr2' => $data->where('month_name_short', '=', 'jun')->sum('total_amount'),
                        'jul' => $data->where('month_name_short', '=', 'jul')->sum('total_amount'),
                        'aug' => $data->where('month_name_short', '=', 'aug')->sum('total_amount'),
                        'sep' => $data->where('month_name_short', '=', 'sep')->sum('total_amount'),
                        'qr3' => $data->where('month_name_short', '=', 'sep')->sum('total_amount'),
                        'oct' => $data->where('month_name_short', '=', 'oct')->sum('total_amount'),
                        'nov' => $data->where('month_name_short', '=', 'nov')->sum('total_amount'),
                        'dec' => $data->where('month_name_short', '=', 'dec')->sum('total_amount'),
                        'qr4' => $data->where('month_name_short', '=', 'dec')->sum('total_amount'),
                        'yar' => $data->where('month_name_short', '=', 'dec')->sum('total_amount'),
                    ];
                    $key++;
            }

                // Payload
                $payload['jan'] += $data->where('month_name_short', '=', 'jan')->sum('total_amount');
                $payload['feb'] += $data->where('month_name_short', '=', 'feb')->sum('total_amount');
                $payload['mar'] += $data->where('month_name_short', '=', 'mar')->sum('total_amount');
                $payload['qr1'] += $data->where('month_name_short', '=', 'mar')->sum('total_amount');
                $payload['apr'] += $data->where('month_name_short', '=', 'apr')->sum('total_amount');
                $payload['may'] += $data->where('month_name_short', '=', 'may')->sum('total_amount');
                $payload['jun'] += $data->where('month_name_short', '=', 'jun')->sum('total_amount');
                $payload['qr2'] += $data->where('month_name_short', '=', 'jun')->sum('total_amount');
                $payload['jul'] += $data->where('month_name_short', '=', 'jul')->sum('total_amount');
                $payload['aug'] += $data->where('month_name_short', '=', 'aug')->sum('total_amount');
                $payload['sep'] += $data->where('month_name_short', '=', 'sep')->sum('total_amount');
                $payload['qr3'] += $data->where('month_name_short', '=', 'sep')->sum('total_amount');
                $payload['oct'] += $data->where('month_name_short', '=', 'oct')->sum('total_amount');
                $payload['nov'] += $data->where('month_name_short', '=', 'nov')->sum('total_amount');
                $payload['dec'] += $data->where('month_name_short', '=', 'dec')->sum('total_amount');
                $payload['qr4'] += $data->where('month_name_short', '=', 'dec')->sum('total_amount');
                $payload['yar'] += $data->where('month_name_short', '=', 'dec')->sum('total_amount');
                // Assets Result
                if ($group->id == 5 || $group->id == 6) {
                    $payload_assets['jan'] += $data->where('month_name_short', '=', 'jan')->sum('total_amount');
                    $payload_assets['feb'] += $data->where('month_name_short', '=', 'feb')->sum('total_amount');
                    $payload_assets['mar'] += $data->where('month_name_short', '=', 'mar')->sum('total_amount');
                    $payload_assets['qr1'] += $data->where('month_name_short', '=', 'mar')->sum('total_amount');
                    $payload_assets['apr'] += $data->where('month_name_short', '=', 'apr')->sum('total_amount');
                    $payload_assets['may'] += $data->where('month_name_short', '=', 'may')->sum('total_amount');
                    $payload_assets['jun'] += $data->where('month_name_short', '=', 'jun')->sum('total_amount');
                    $payload_assets['qr2'] += $data->where('month_name_short', '=', 'jun')->sum('total_amount');
                    $payload_assets['jul'] += $data->where('month_name_short', '=', 'jul')->sum('total_amount');
                    $payload_assets['aug'] += $data->where('month_name_short', '=', 'aug')->sum('total_amount');
                    $payload_assets['sep'] += $data->where('month_name_short', '=', 'sep')->sum('total_amount');
                    $payload_assets['qr3'] += $data->where('month_name_short', '=', 'sep')->sum('total_amount');
                    $payload_assets['oct'] += $data->where('month_name_short', '=', 'oct')->sum('total_amount');
                    $payload_assets['nov'] += $data->where('month_name_short', '=', 'nov')->sum('total_amount');
                    $payload_assets['dec'] += $data->where('month_name_short', '=', 'dec')->sum('total_amount');
                    $payload_assets['qr4'] += $data->where('month_name_short', '=', 'dec')->sum('total_amount');
                    $payload_assets['yar'] += $data->where('month_name_short', '=', 'dec')->sum('total_amount');
                }
                // Liabilities Result
                if ($group->id == 7 || $group->id == 8) {
                    $payload_liabilities['jan'] += $data->where('month_name_short', '=', 'jan')->sum('total_amount');
                    $payload_liabilities['feb'] += $data->where('month_name_short', '=', 'feb')->sum('total_amount');
                    $payload_liabilities['mar'] += $data->where('month_name_short', '=', 'mar')->sum('total_amount');
                    $payload_liabilities['qr1'] += $data->where('month_name_short', '=', 'mar')->sum('total_amount');
                    $payload_liabilities['apr'] += $data->where('month_name_short', '=', 'apr')->sum('total_amount');
                    $payload_liabilities['may'] += $data->where('month_name_short', '=', 'may')->sum('total_amount');
                    $payload_liabilities['jun'] += $data->where('month_name_short', '=', 'jun')->sum('total_amount');
                    $payload_liabilities['qr2'] += $data->where('month_name_short', '=', 'jun')->sum('total_amount');
                    $payload_liabilities['jul'] += $data->where('month_name_short', '=', 'jul')->sum('total_amount');
                    $payload_liabilities['aug'] += $data->where('month_name_short', '=', 'aug')->sum('total_amount');
                    $payload_liabilities['sep'] += $data->where('month_name_short', '=', 'sep')->sum('total_amount');
                    $payload_liabilities['qr3'] += $data->where('month_name_short', '=', 'sep')->sum('total_amount');
                    $payload_liabilities['oct'] += $data->where('month_name_short', '=', 'oct')->sum('total_amount');
                    $payload_liabilities['nov'] += $data->where('month_name_short', '=', 'nov')->sum('total_amount');
                    $payload_liabilities['dec'] += $data->where('month_name_short', '=', 'dec')->sum('total_amount');
                    $payload_liabilities['qr4'] += $data->where('month_name_short', '=', 'dec')->sum('total_amount');
                    $payload_liabilities['yar'] += $data->where('month_name_short', '=', 'dec')->sum('total_amount');
                }
                // Equity Result
                if ($group->id == 9) {
                    $payload_equity['jan'] += $data->where('month_name_short', '=', 'jan')->sum('total_amount');
                    $payload_equity['feb'] += $data->where('month_name_short', '=', 'feb')->sum('total_amount');
                    $payload_equity['mar'] += $data->where('month_name_short', '=', 'mar')->sum('total_amount');
                    $payload_equity['qr1'] += $data->where('month_name_short', '=', 'mar')->sum('total_amount');
                    $payload_equity['apr'] += $data->where('month_name_short', '=', 'apr')->sum('total_amount');
                    $payload_equity['may'] += $data->where('month_name_short', '=', 'may')->sum('total_amount');
                    $payload_equity['jun'] += $data->where('month_name_short', '=', 'jun')->sum('total_amount');
                    $payload_equity['qr2'] += $data->where('month_name_short', '=', 'jun')->sum('total_amount');
                    $payload_equity['jul'] += $data->where('month_name_short', '=', 'jul')->sum('total_amount');
                    $payload_equity['aug'] += $data->where('month_name_short', '=', 'aug')->sum('total_amount');
                    $payload_equity['sep'] += $data->where('month_name_short', '=', 'sep')->sum('total_amount');
                    $payload_equity['qr3'] += $data->where('month_name_short', '=', 'sep')->sum('total_amount');
                    $payload_equity['oct'] += $data->where('month_name_short', '=', 'oct')->sum('total_amount');
                    $payload_equity['nov'] += $data->where('month_name_short', '=', 'nov')->sum('total_amount');
                    $payload_equity['dec'] += $data->where('month_name_short', '=', 'dec')->sum('total_amount');
                    $payload_equity['qr4'] += $data->where('month_name_short', '=', 'dec')->sum('total_amount');
                    $payload_equity['yar'] += $data->where('month_name_short', '=', 'dec')->sum('total_amount');
                }

                if ($group->id == 6) {
                        $result[$key] = [
                            'row'  => $key,
                            'year' => $request->year,
                            'company_id' => $request->company,
                            'lvl' => $lvl,
                            'report_id' => $request->report,
                            'category_id'  => null,
                            'branch'  => null,
                            'row_class'  => 'result-row',
                            'name' => 'Total Assets',
                            'jan' => $payload_assets['jan'],
                            'feb' => $payload_assets['feb'],
                            'mar' => $payload_assets['mar'],
                            'qr1' => $payload_assets['qr1'],
                            'apr' => $payload_assets['apr'],
                            'may' => $payload_assets['may'],
                            'jun' => $payload_assets['jun'],
                            'qr2' => $payload_assets['qr2'],
                            'jul' => $payload_assets['jul'],
                            'aug' => $payload_assets['aug'],
                            'sep' => $payload_assets['sep'],
                            'qr3' => $payload_assets['qr3'],
                            'oct' => $payload_assets['oct'],
                            'nov' => $payload_assets['nov'],
                            'dec' => $payload_assets['dec'],
                            'qr4' => $payload_assets['qr4'],
                            'yar' => $payload_assets['yar'],
                        ];
                        $key++;
                }

                if ($group->id == 8) {
                        $result[$key] = [
                            'row'  => $key,
                            'year' => $request->year,
                            'company_id' => $request->company,
                            'lvl' => $lvl,
                            'report_id' => $request->report,
                            'category_id'  => null,
                            'branch'  => null,
                            'row_class'  => 'result-row',
                            'name' => 'Total Liabilities',
                            'jan' => $payload_liabilities['jan'],
                            'feb' => $payload_liabilities['feb'],
                            'mar' => $payload_liabilities['mar'],
                            'qr1' => $payload_liabilities['qr1'],
                            'apr' => $payload_liabilities['apr'],
                            'may' => $payload_liabilities['may'],
                            'jun' => $payload_liabilities['jun'],
                            'qr2' => $payload_liabilities['qr2'],
                            'jul' => $payload_liabilities['jul'],
                            'aug' => $payload_liabilities['aug'],
                            'sep' => $payload_liabilities['sep'],
                            'qr3' => $payload_liabilities['qr3'],
                            'oct' => $payload_liabilities['oct'],
                            'nov' => $payload_liabilities['nov'],
                            'dec' => $payload_liabilities['dec'],
                            'qr4' => $payload_liabilities['qr4'],
                            'yar' => $payload_liabilities['yar'],
                        ];
                        $key++;
                }
                if ($group->id == 9) {
                        // $result[$key] = [
                        //     'row'  => $key,
                        //     'year' => $request->year,
                        //     'company_id' => $request->company,
                        //     'lvl' => $lvl,
                        //     'report_id' => $request->report,
                        //     'category_id'  => null,
                        //     'branch'  => null,
                        //     'row_class'  => 'result-row',
                        //     'name' => 'Total Equity',
                        //     'jan' => $payload_equity['jan'],
                        //     'feb' => $payload_equity['feb'],
                        //     'mar' => $payload_equity['mar'],
                        //     'qr1' => $payload_equity['qr1'],
                        //     'apr' => $payload_equity['apr'],
                        //     'may' => $payload_equity['may'],
                        //     'jun' => $payload_equity['jun'],
                        //     'qr2' => $payload_equity['qr2'],
                        //     'jul' => $payload_equity['jul'],
                        //     'aug' => $payload_equity['aug'],
                        //     'sep' => $payload_equity['sep'],
                        //     'qr3' => $payload_equity['qr3'],
                        //     'oct' => $payload_equity['oct'],
                        //     'nov' => $payload_equity['nov'],
                        //     'dec' => $payload_equity['dec'],
                        //     'qr4' => $payload_equity['qr4'],
                        //     'yar' => $payload_equity['yar'],
                        // ];
                        // $key++;
                        $result[$key] = [
                            'row'  => $key,
                            'year' => $request->year,
                            'company_id' => $request->company,
                            'lvl' => $lvl,
                            'report_id' => $request->report,
                            'category_id'  => null,
                            'branch'  => null,
                            'row_class'  => 'result-row',
                            'name' => 'Total Liabilities + Equity',
                            'jan' => $payload_liabilities['jan'] + $payload_equity['jan'],
                            'feb' => $payload_liabilities['feb'] + $payload_equity['feb'],
                            'mar' => $payload_liabilities['mar'] + $payload_equity['mar'],
                            'qr1' => $payload_liabilities['qr1'] + $payload_equity['qr1'],
                            'apr' => $payload_liabilities['apr'] + $payload_equity['apr'],
                            'may' => $payload_liabilities['may'] + $payload_equity['may'],
                            'jun' => $payload_liabilities['jun'] + $payload_equity['jun'],
                            'qr2' => $payload_liabilities['qr2'] + $payload_equity['qr2'],
                            'jul' => $payload_liabilities['jul'] + $payload_equity['jul'],
                            'aug' => $payload_liabilities['aug'] + $payload_equity['aug'],
                            'sep' => $payload_liabilities['sep'] + $payload_equity['sep'],
                            'qr3' => $payload_liabilities['qr3'] + $payload_equity['qr3'],
                            'oct' => $payload_liabilities['oct'] + $payload_equity['oct'],
                            'nov' => $payload_liabilities['nov'] + $payload_equity['nov'],
                            'dec' => $payload_liabilities['dec'] + $payload_equity['dec'],
                            'qr4' => $payload_liabilities['qr4'] + $payload_equity['qr4'],
                            'yar' => $payload_liabilities['yar'] + $payload_equity['yar'],
                        ];
                        $key++;
                }

            }

            // $key++;

            return $result;

        }

        public function extract(Request $request)
        {

            // Levels
            // $levels = ['lvl1','lvl2','lvl3','lvl4'];
            $levels = ['lvl1','lvl2','lvl3'];

            // return $this->process_balance($request,'lvl2');




            foreach ($levels as $level) {
                $result[] = $this->process_balance($request,$level);
            }
            $upsert = array_merge($result[0],$result[1],$result[2]);

            // Columns to Update
            $colUpdate = [
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
            ];

            $compare = [
                'year',
                'company_id',
                'lvl',
                'report_id',
            ];

            return DB::table('data_warehouse')->upsert($upsert, $compare, $colUpdate);
        }
}
