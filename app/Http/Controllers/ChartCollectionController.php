<?php

namespace App\Http\Controllers;

use App\Models\Chart;
use App\Models\Company;
use Illuminate\Http\Request;
use App\Models\ChartCollection;
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
}
