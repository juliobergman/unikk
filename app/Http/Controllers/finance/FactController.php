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
}
