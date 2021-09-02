<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class MembershipController extends Controller
{
    public function index()
    {
        abort(404);
    }

    public function current(Request $request)
    {
        $company = Membership::where('user_id', Auth::user()->id)->where('default',!null)->first();

        if(!$company){
            // Get Info
            $user = Auth::user();
            $ms = Membership::query();
            $ms->where('user_id', $user->id);
            $ms->orderBy('default', 'desc');
            $membership = $ms->first();

            if(!$membership){
                return response()->json(['error' => 'Your Access has been revoked'], 403);
            }

            // Set Default
            $this->set_default($membership);

            // Return
            return $membership;
        } else {
            return $company;
        }
    }

    public function companies(Request $request)
    {

        $user = Auth::user();

        $memberships = Membership::query();
        $memberships->where('user_id', $user->id);

        $memberships->whereHas('company', function($query){
            $query->where('type', 'active');
        });

        $memberships->withCount('company');
        $memberships->with('company');

        return $memberships->get();
    }

    public function users(Company $company)
    {
        $users = User::query();
        $users->whereHas('memberships', function($query) use ($company){
            $cUser = Auth::user();
            $query->where('company_id', $company->id);
            $query->where('user_id', '!=', $cUser->id);
            $query->where('user_id', '!=', 1);
        });
        $users->with('userdata');
        // $users->with('currentMembership');

        $users->with('membership', function($query) use ($company){
            $query->where('company_id', $company->id);
        });

        return $users->get();
    }

    public function notusers(Company $company)
    {
        $companyUsers = $this->users($company);
        $avoidUsers = array();
        foreach ($companyUsers as $key => $user) {
            $avoidUsers[$key] = $user->id;
        }
        $avoidUsers[] = Auth::user()->id;
        $users = User::whereNotIn('id', $avoidUsers);
        $users->with('userdata:user_id,profile_pic');
        return $users->get()->makeHidden(['role', 'email_verified_at', 'created_at', 'updated_at', 'email'])->toArray();
    }

    public function set_default(Membership $membership)
    {
        $res = Gate::inspect('setDefault', $membership);
        // if ($res->denied()){
        //     return response()->json(['error' =>$res->message()], 403);
        // }

        $user = Auth::user();
        Membership::where('user_id', $user->id)
                    ->update(['default' => null]);

        Membership::where('user_id', $user->id)
                    ->where('company_id', $membership->company_id)
                    ->update(['default' => true]);

        return Membership::where('user_id', $user->id)
        ->where('company_id', $membership->company_id)
        ->first();
    }


    public function store(Request $request)
    {
        $membership = new Membership;
        $membership->user_id = $request->id;
        $membership->company_id = $request->company;
        $membership->save();

        return $membership;
    }

    public function update(Request $request)
    {
        $updateData = $request->only('role','job_title');
        if(Membership::where('id', $request->membership)->update($updateData)){
            $userMembership = Membership::where('id', $request->membership)->first();
            return new JsonResponse($userMembership, 200);
        }
        return new JsonResponse([], 422);
    }

    public function destroy($id)
    {
        if(Membership::destroy($id)){
            return response()->json(['message' => 'Membership Revoqued'], 200);
        } else {
            return response()->json(['error' =>'error'], 403);
        }
    }

}
