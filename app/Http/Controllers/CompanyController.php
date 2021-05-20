<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyData;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index(Request $request)
    {

        dd($request);

        $companies = Company::query();
        $companies->with('data');
        return $companies->get();
    }

    public function show($id)
    {

        $company = Company::where('id', $id)->with('user:id,name,email')->first();

        $companydata = CompanyData::where('company_id', $company->id)->first();
        $collection = collect($company);
        $merged = $collection->merge($companydata);
        return $merged;
    }

}
