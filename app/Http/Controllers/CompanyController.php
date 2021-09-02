<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Membership;
use App\Models\CompanyData;
use Illuminate\Http\Request;
use App\Events\companyCreated;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
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

        $data_select = [
            // --------------- Company
            'companies.id',
            'companies.user_id',
            'companies.name',
            'companies.currency_id',
            'companies.type as type',
            // --------------- Company Data
            'company_data.address',
            'company_data.city',
            'company_data.sector',
            'company_data.country',
            'company_data.phone',
            'company_data.email',
            'company_data.website',
            'company_data.info',
            'company_data.logo',
            // 'company_data.company_ov',
            // 'company_data.financial_ov',
            // 'company_data.milestones',
            // 'company_data.competitors',
            // 'company_data.goals',
            // 'company_data.channels',
            // 'company_data.challenges',
            // --------------- Countries
            'res_countries.name as country_name',
            'res_countries.iso2 as country',
            'res_countries.region',
            'res_countries.subregion',
            'res_countries.latitude',
            'res_countries.longitude',
            'res_countries.currency as country_currency',
            'res_countries.currency_symbol as country_currency_symbol',
            // --------------- Currency
            'res_currencies.name as currency_name',
            'res_currencies.code as currency_code',
            'res_currencies.symbol as currency_symbol',
        ];

        $company = Company::query();
        $company->where('companies.id', $id);
        $company->with('user:id,name,email');

        $company->join('company_data', 'companies.id', '=', 'company_data.company_id');
        $company->join('res_countries', 'company_data.country', '=', 'res_countries.iso2');
        $company->join('res_currencies', 'companies.currency_id', '=', 'res_currencies.id');


        $company->select($data_select);

        $ret = $company->first();
        if(!$ret){
            return 'NotFound';
        }

        return $ret;
    }


    public function current()
    {
        $membership = Membership::where('user_id', Auth::user()->id)->where('default',!null)->first();
        // return $membership->company_id;
        return $this->show($membership->company_id);
    }


    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:2'],
            'currency_id' => ['required', 'int', 'max:255'],
        ]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        $newCompany = $request->user()->company()->create($request->only(['name','currency_id','type','company_id']));
        event(new companyCreated($newCompany, $request->country));
        $membership = Membership::where('company_id', $newCompany->id)->where('user_id', $newCompany->user_id)->first();
        return new JsonResponse(['company' => $newCompany, 'membership' => $membership], 201);
    }

    public function update(Request $request, Company $company)
    {

        $res = Gate::inspect('update', $company);

        if ($res->allowed()) {

            $updateCompany = array(
                'name' => $request->name,
                'currency_id' => $request->currency_id
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
