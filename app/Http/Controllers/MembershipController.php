<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use App\Models\Membership;
use Illuminate\Http\Request;
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

        $company = $request->header('company');

        if(!$company){
            $user = Auth::user();
            $ms = Membership::query();
            $ms->where('user_id', $user->id);
            $ms->orderBy('default', 'desc');
            $ms->withCount('company');
            $ms->with('company');
            return $ms->first()->company->id;
        } else {
            return $company;
        }
    }

    public function companies(Request $request)
    {

        $user = Auth::user();

        $companies = Membership::query();

        $companies->where('user_id', $user->id);
        $companies->withCount('company');
        $companies->with('company');

        return $companies->get();
    }

    public function users(Company $company)
    {
        $users = User::query();
        $users->whereHas('membership', function($query) use ($company){
            $query->where('company_id', $company->id);
        });
        $users->with('userdata');
        $users->with('membership');
        return $users->get();
    }

    public function set_default(Membership $membership)
    {
        $res = Gate::inspect('setDefault', $membership);
        if ($res->denied()){
            return response()->json(['error' =>$res->message()], 403);
        }

        $user = Auth::user();
        Membership::where('user_id', $user->id)
                    ->update(['default' => null]);

        Membership::where('user_id', $user->id)
                    ->where('company_id', $membership->company_id)
                    ->update(['default' => true]);

        return response()->json(['message' =>$res->message()], 200);
    }

}
