<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyData;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class TargetController extends Controller
{

    public function index()
    {
        abort(404);
    }

    public function list($id)
    {
        $data_select = [
            'companies.id',
            'companies.name',
            'company_data.city',
            'res_countries.name as country',
        ];

        $target = Company::query();
        $target->where('companies.company_id',$id);
        $target->where('type', 'target');
        $target->join('company_data', 'companies.id', '=', 'company_data.company_id');
        $target->join('res_countries', 'company_data.country', '=', 'res_countries.iso2');

        $target->select($data_select);

        return $target->get();
    }

    public function store(Request $request)
    {
        $company = array(
            'name' => $request->name,
            'type' => 'target'
        );

        $newCompany = $request->user()->company()->create($company);
        return $newCompany;
    }

    public function show(Request $request)
    {

        $data_select = [
            // --------------- Company
            'companies.id',
            'companies.user_id',
            'companies.name',
            'companies.type',
            // --------------- Company Data
            'company_data.address',
            'company_data.city',
            'company_data.sector',
            'company_data.phone',
            'company_data.email',
            'company_data.website',
            'company_data.info',
            'company_data.logo',
            'company_data.company_ov',
            'company_data.financial_ov',
            'company_data.milestones',
            'company_data.competitors',
            'company_data.goals',
            'company_data.channels',
            'company_data.challenges',
            // --------------- Countries
            'company_data.country',
            'res_countries.name as country_name',
            'res_countries.iso2 as country',
            'res_countries.region',
            'res_countries.subregion',
            'res_countries.latitude',
            'res_countries.longitude',
            'res_countries.currency as country_currency',
            'res_countries.currency_symbol as country_currency_symbol',
            // --------------- Currency
            'companies.currency_id',
            'res_currencies.name as currency_name',
            'res_currencies.code as currency_code',
            'res_currencies.symbol as currency_symbol',
        ];

        $target = Company::query();
        $target->where('companies.id', $request->id);
        $target->where('type', 'target');
        $target->join('company_data', 'companies.id', '=', 'company_data.company_id');
        $target->join('res_countries', 'company_data.country', '=', 'res_countries.iso2');
        $target->join('res_currencies', 'companies.currency_id', '=', 'res_currencies.id');
        $target->select($data_select);
        $return = $target->first();

        if ($return) {
            return $return;
        }
        return new JsonResponse(['error' => 'Not Found'], 404);
    }

    public function update(Request $request)
    {


        $updateCompany = array(
            'name' => $request->name,
            'currency_id' => $request->currency_id,
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
            'company_ov' => $request->company_ov,
            'financial_ov' => $request->financial_ov,
            'milestones' => $request->milestones,
            'competitors' => $request->competitors,
            'goals' => $request->goals,
            'channels' => $request->channels,
            'challenges' => $request->challenges,
        );

        $update = Company::where('id', $request->id)->update($updateCompany);

        if($update){


            $dataupdate = CompanyData::where('company_id', $request->id)->update($updateData);


            if ($dataupdate) {
                return $this->show($request);
            }
        }

        return new JsonResponse(['error' => 'Failed'], 422);
    }

    public function acquire(Request $request)
    {
        return Company::where('id', $request->id)->update(['type' => 'active']);
    }

    public function destroy(Company $company)
    {
        if($company->delete()){
            return response()->json(['message' => 'Company Deleted'], 200);
        } else {
            return response()->json(['error' =>'error'], 403);
        }
    }
}
