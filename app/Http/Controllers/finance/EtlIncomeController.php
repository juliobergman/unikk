<?php

namespace App\Http\Controllers\finance;

use App\Models\finance\Code;
use App\Models\finance\Fact;
use Illuminate\Http\Request;
use App\Models\finance\CodeGroup;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EtlIncomeController extends Controller
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

        protected function process_income(Request $request, $lvl)
        {
            $groups = CodeGroup::where('type','income')->orderBy('oby', 'asc')->get();

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
                        'jan'  => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'jan')->sum('total_amount'),
                        'feb'  => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'feb')->sum('total_amount'),
                        'mar'  => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'mar')->sum('total_amount'),
                        'qr1'  => $data->where('name', '=', $value->name)->where('quarter', '=', 1)->sum('total_amount'),
                        'apr'  => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'apr')->sum('total_amount'),
                        'may'  => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'may')->sum('total_amount'),
                        'jun'  => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'jun')->sum('total_amount'),
                        'qr2'  => $data->where('name', '=', $value->name)->where('quarter', '=', 2)->sum('total_amount'),
                        'jul'  => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'jul')->sum('total_amount'),
                        'aug'  => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'aug')->sum('total_amount'),
                        'sep'  => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'sep')->sum('total_amount'),
                        'qr3'  => $data->where('name', '=', $value->name)->where('quarter', '=', 3)->sum('total_amount'),
                        'oct'  => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'oct')->sum('total_amount'),
                        'nov'  => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'nov')->sum('total_amount'),
                        'dec'  => $data->where('name', '=', $value->name)->where('month_name_short', '=', 'dec')->sum('total_amount'),
                        'qr4'  => $data->where('name', '=', $value->name)->where('quarter', '=', 4)->sum('total_amount'),
                        'yar' => $data->where('name', '=', $value->name)->sum('total_amount'),
                    ];
                    $key++;
                }

                // Payload
                $payload['jan'] += $data->where('month_name_short', '=', 'jan')->sum('total_amount');
                $payload['feb'] += $data->where('month_name_short', '=', 'feb')->sum('total_amount');
                $payload['mar'] += $data->where('month_name_short', '=', 'mar')->sum('total_amount');
                $payload['qr1'] += $data->where('quarter', '=', 1)->sum('total_amount');
                $payload['apr'] += $data->where('month_name_short', '=', 'apr')->sum('total_amount');
                $payload['may'] += $data->where('month_name_short', '=', 'may')->sum('total_amount');
                $payload['jun'] += $data->where('month_name_short', '=', 'jun')->sum('total_amount');
                $payload['qr2'] += $data->where('quarter', '=', 2)->sum('total_amount');
                $payload['jul'] += $data->where('month_name_short', '=', 'jul')->sum('total_amount');
                $payload['aug'] += $data->where('month_name_short', '=', 'aug')->sum('total_amount');
                $payload['sep'] += $data->where('month_name_short', '=', 'sep')->sum('total_amount');
                $payload['qr3'] += $data->where('quarter', '=', 3)->sum('total_amount');
                $payload['oct'] += $data->where('month_name_short', '=', 'oct')->sum('total_amount');
                $payload['nov'] += $data->where('month_name_short', '=', 'nov')->sum('total_amount');
                $payload['dec'] += $data->where('month_name_short', '=', 'dec')->sum('total_amount');
                $payload['qr4'] += $data->where('quarter', '=', 4)->sum('total_amount');
                $payload['yar'] += $data->sum('total_amount');



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
                    'jan'  => $payload['jan'],
                    'feb'  => $payload['feb'],
                    'mar'  => $payload['mar'],
                    'qr1'  => $payload['qr1'],
                    'apr'  => $payload['apr'],
                    'may'  => $payload['may'],
                    'jun'  => $payload['jun'],
                    'qr2'  => $payload['qr2'],
                    'jul'  => $payload['jul'],
                    'aug'  => $payload['aug'],
                    'sep'  => $payload['sep'],
                    'qr3'  => $payload['qr3'],
                    'oct'  => $payload['oct'],
                    'nov'  => $payload['nov'],
                    'dec'  => $payload['dec'],
                    'qr4'  => $payload['qr4'],
                    'yar' => $payload['yar'],
                ];

                $key++;
            }


            // Second Part of Report
            $result[$key] = [
                'row' => $key,
                'year' => $request->year,
                'company_id' => $request->company,
                'lvl' => $lvl,
                'report_id' => $request->report,
                'category_id'  => null,
                'branch'  => null,
                'row_class' => 'divider',
                'name' => null,
                'jan' => null,
                'feb' => null,
                'mar' => null,
                'qr1' => null,
                'apr' => null,
                'may' => null,
                'jun' => null,
                'qr2' => null,
                'jul' => null,
                'aug' => null,
                'sep' => null,
                'qr3' => null,
                'oct' => null,
                'nov' => null,
                'dec' => null,
                'qr4' => null,
                'yar' => null,
            ];
            $key++;

            $extra_rows = ['EBIT' => 6,'EBITDA' => 5];

            foreach ($extra_rows as $name => $row) {

                    $er_data = collect($result)->where('category_id', '=', $row);

                    foreach ($er_data as $value) {
                        $result[$key] = [
                        'row'  => $key,
                        'year' => $request->year,
                        'company_id' => $request->company,
                        'lvl' => $lvl,
                        'report_id' => $request->report,
                        'category_id'  => $value['category_id'],
                        'branch'  => $value['branch'],
                        'row_class'  => 'data-row',
                        'name' => $value['name'],
                        'jan'  => $value['jan'] * -1,
                        'feb'  => $value['feb'] * -1,
                        'mar'  => $value['mar'] * -1,
                        'qr1'  => $value['qr1'] * -1,
                        'apr'  => $value['apr'] * -1,
                        'may'  => $value['may'] * -1,
                        'jun'  => $value['jun'] * -1,
                        'qr2'  => $value['qr2'] * -1,
                        'jul'  => $value['jul'] * -1,
                        'aug'  => $value['aug'] * -1,
                        'sep'  => $value['sep'] * -1,
                        'qr3'  => $value['qr3'] * -1,
                        'oct'  => $value['oct'] * -1,
                        'nov'  => $value['nov'] * -1,
                        'dec'  => $value['dec'] * -1,
                        'qr4'  => $value['qr4'] * -1,
                        'yar' => $value['yar'] * -1,
                    ];

                        // Payload
                        $payload['jan']  += $value['jan'] * -1;
                        $payload['feb']  += $value['feb'] * -1;
                        $payload['mar']  += $value['mar'] * -1;
                        $payload['qr1']  += $value['qr1'] * -1;
                        $payload['apr']  += $value['apr'] * -1;
                        $payload['may']  += $value['may'] * -1;
                        $payload['jun']  += $value['jun'] * -1;
                        $payload['qr2']  += $value['qr2'] * -1;
                        $payload['jul']  += $value['jul'] * -1;
                        $payload['aug']  += $value['aug'] * -1;
                        $payload['sep']  += $value['sep'] * -1;
                        $payload['qr3']  += $value['qr3'] * -1;
                        $payload['oct']  += $value['oct'] * -1;
                        $payload['nov']  += $value['nov'] * -1;
                        $payload['dec']  += $value['dec'] * -1;
                        $payload['qr4']  += $value['qr4'] * -1;
                        $payload['yar'] += $value['yar'] * -1;

                        $key++;
                    }

                    $result[$key] = [
                    'row'  => $key,
                    'year' => $request->year,
                    'company_id' => $request->company,
                    'lvl' => $lvl,
                    'report_id' => $request->report,
                    'category_id'  => null,
                    'branch'  => null,
                    'row_class'  => 'result-row',
                    'name' => $name,
                    'jan' => $payload['jan'],
                    'feb' => $payload['feb'],
                    'mar' => $payload['mar'],
                    'qr1' => $payload['qr1'],
                    'apr' => $payload['apr'],
                    'may' => $payload['may'],
                    'jun' => $payload['jun'],
                    'qr2' => $payload['qr2'],
                    'jul' => $payload['jul'],
                    'aug' => $payload['aug'],
                    'sep' => $payload['sep'],
                    'qr3' => $payload['qr3'],
                    'oct' => $payload['oct'],
                    'nov' => $payload['nov'],
                    'dec' => $payload['dec'],
                    'qr4' => $payload['qr4'],
                    'yar' => $payload['yar'],
                ];

                $key++;
            }

            return $result;

        }

        public function extract(Request $request)
        {
            // Levels
            $levels = ['lvl1','lvl2','lvl3'];
            foreach ($levels as $level) {
                $result[] = $this->process_income($request,$level);
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
