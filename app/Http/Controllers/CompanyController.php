<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyData;
use Illuminate\Http\Request;
use App\Events\companyCreated;
use App\Models\Membership;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;

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

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
        ]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $newCompany = $request->user()->company()->create($request->only('name'));
        event(new companyCreated($newCompany));
        $membership = Membership::where('company_id', $newCompany->id)->where('user_id', $newCompany->user_id)->first();
        return new JsonResponse(['company' => $newCompany, 'membership' => $membership], 201);
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
