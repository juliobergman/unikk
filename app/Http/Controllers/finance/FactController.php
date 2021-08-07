<?php

namespace App\Http\Controllers\finance;

use App\Models\finance\Fact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class FactController extends Controller
{

    public function index(Request $request)
    {
        abort(404);
    }

    public function records(Request $request)
    {
        $date = date_parse($request->month.'-'.$request->year);
        $records = Fact::query();
        $records->where('facts.company_id', $request->company);
        $records->where('facts.report_id', $request->report);
        $records->whereMonth('date', $date['month']);
        $records->whereYear('date', $date['year']);
        // Look for Name
        $data_where = [
            'lvl1' => 'parents.name',
            'lvl2' => 'code_categories.name',
            'lvl3' => 'codes.name'
        ];
        $records->where($data_where[$request->lvl], $request->name);
        // Selects
        $records->select([
            'codes.name AS name',
            'facts.id as id',
            'codes.code as code',
            'facts.date',
            'facts.created_at',
            'facts.amount',
        ]);
        // Joins
        $records->join('codes', 'facts.code_id', '=', 'codes.id');
        $records->join('code_categories', 'codes.code_category_id', '=', 'code_categories.id');
        $records->join('code_categories as parents', 'parents.id', '=', 'code_categories.parent');

        $records->orderBy('created_at');

        return $records->get();
    }

    public function fact_amount($data)
    {
        $facts = Fact::query();
        $facts->where('user_id', 1);
        $facts->where('company_id', 1);
        $facts->whereHas('date', function (Builder $query) use ($data) {
            $query->where($data->type, $data->data);
        });
        $facts->whereHas('code', function (Builder $query) use ($data) {
            $query->where('code', $data->code);
        });
        return $facts->sum('amount');
    }

    public function store(Request $request)
    {
        $user = Auth::user()->id;
        $data = array_filter($request->facts);
        $insert = [];

        foreach ($data as $key => $value) {
            $insert[] = [
                'date' => $request->date,
                'code_id' => $key,
                'report_id' => $request->report_id,
                'company_id' => $request->company_id,
                'user_id' => $user,
                'amount' => $value,
                'created_at' => now(),
            ];
        }

        return DB::table('facts')->insert($insert);;
    }

    public function show(Fact $fact)
    {

    }

    public function update(Request $request, Fact $fact)
    {
        //
    }

    public function destroy($id)
    {
        if(Fact::destroy($id)){
            return response()->json(['message' => 'Record Deleted'], 200);
        } else {
            return response()->json(['error' =>'error'], 403);
        }
    }

    public function destroy_bulk(Request $request)
    {
        $deletes = array_map(function($e){
            return $e['id'];
        }, $request->toArray());
        Fact::destroy($deletes);
    }
}
