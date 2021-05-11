<?php

namespace App\Http\Controllers;

use App\Models\Chart;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\ChartCollection;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class ChartCollectionController extends Controller
{
    public function index()
    {
        abort(404);
    }

    public function collections(Company $company)
    {
        return ChartCollection::where('company_id', $company->id)->get();
    }

    public function collection($id)
    {
        $collection = ChartCollection::query();
        $collection->where('id', $id);
        $collection->with('charts');
        $collection->first();

        return $collection->first();
    }

    public function store(Request $request)
    {
        $data = array(
                "name" => $request->name,
                "company_id" => $request->company
        );

        $newCollection = $request->user()->collection()->create($data);
        return $newCollection;
    }
}
