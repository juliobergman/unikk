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
        // $target = Company::where('user_id', Auth::user()->id);
        $target = Company::where('company_id', $id);
        $target->where('type', 'target');
        $target->with('CompanyData');
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
        $target = Company::where('id', $request->id)->with('CompanyData')->first();
        if ($target) {
            return $target;
        }
        return new JsonResponse(['error' => 'Not Found'], 404);
    }

    public function update(Request $request)
    {

        $updateCompany = Company::where('id', $request->id)->update($request->only('name'));
        if($updateCompany){

            $updateData = $request->company_data;
            $uwData = ['id', 'logo', 'deleted_at', 'created_at', 'updated_at']; // Unwanted Data
            $updateData = array_diff_key($updateData, array_flip($uwData));
            $updateCompanyData = CompanyData::where('company_id', $request->id)->update($updateData);
            if ($updateCompanyData) {
                return new JsonResponse(['message' => 'Success'], 200);
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
