<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Membership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

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

    public function users(Request $request)
    {

        $users = User::query();
        $users->whereHas('membership', function($query) use ($request){
            $query->where('company_id', $request->header('company'));
        });
        $users->with('userdata');
        $users->with('membership');
        return $users->get();
    }
}
