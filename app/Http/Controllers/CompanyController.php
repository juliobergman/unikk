<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyData;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;

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

    public function update(Request $request, Company $company)
    {

        $res = Gate::inspect('update', $company);

        if ($res->allowed()) {

            $updateCompany = array(
                'name' => $request->name,
            );

            $updateData = array(
                'address' => $request->address,
                'city' => $request->city,
                'sector' => $request->sector,
                'country' => $request->country,
                'phone' => $request->phone,
                'email' => $request->email,
                'website' => $request->website,
                'info' => $request->info,
                'logo' => $request->logo,
            );

            $update = Company::where('id', $request->id)->update($updateCompany);

            if($update){
                $dataupdate = CompanyData::where('company_id', $request->id)->update($updateData);
                if ($dataupdate) {
                    return $this->show($request->id);
                }
            }

            return new JsonResponse([], 422);

        } else {
            return response()->json(['error' =>$res->message()], 401);
        }

        return new JsonResponse([], 422);



    }

}
