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

    public function show(Request $request)
    {
        $company = CompanyData::query();
        $company->where(['id' => $request->id]);
        $company->with('company');
        return $company->get();
    }

}
