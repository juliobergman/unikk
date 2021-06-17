<?php

namespace App\Http\Controllers\User;


use App\Models\User;

use App\Events\userCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\UserData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index()
    {

        return User::with('userdata:user_id,profile_pic')->get()->makeHidden(['role', 'email_verified_at', 'created_at', 'updated_at', 'email'])->toArray();
    }

    public function currentUser()
    {
        $user = collect(Auth::user());
        $userdata = UserData::where('user_id', Auth::user()->id)->first();
        $merged = $user->merge($userdata);
        return $merged;
    }

    public function show(Request $request)
    {
        $user = User::query();
        $user->where('id', $request->id);
        $user->with('userdata');
        $user->with('membership', function($query) use ($request){
            $query->where('user_id', $request->id);
            $query->where('company_id', $request->company);
        });
        return $user->first();
    }

    public function profile(Request $request)
    {
        $user = User::query();
        $user->where('id', $request->id);
        $user->with('userdata');
        return $user->first();
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'role' => ['required', 'string', 'max:255'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'temptoken' => urlencode(Hash::make($data['temptoken'])),
        ]);
    }

    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new userCreated($user = $this->create($request->all()), $data = $request));
        return new JsonResponse([], 201);
    }

    public function update(Request $request)
    {
        $updateUser = $request->only(
            'name',
            'email',
        );
        $updateData = $request->only(
            'phone',
            'address',
            'gender',
        );

        $update = User::where('id', $request->id)->update($updateUser);

        if($update){
            $dataupdate = UserData::where('user_id', $request->id)->update($updateData);
            if ($dataupdate) {
                return $this->currentUser();
            }
        }

    }

    public function newpassword(Request $request)
    {
        $user = Auth::user();

        $this->validate($request, [
            'old_password'          => 'required',
            'password'              => 'required|min:8',
            'password_confirmation' => 'required|same:password'
        ]);

        if(Hash::check($request->old_password, $user->password)){
            // Password Validated
            $new_password = Hash::make($request->password);

            $userUpdate = User::find($user->id);
            $userUpdate->password = $new_password;
            $userUpdate->save();

            if($userUpdate){
                return new JsonResponse(['message' => 'Password Updated'], 200);
            }

        } else {

            return new JsonResponse(['message' => 'The password you provided does not match our records'], 403);

        }

        return new JsonResponse(['message' => 'The given data was invalid.', 'errors' => array('password' => array('Failed to update password'))], 422);

    }

    public function create_password($token, $email)
    {
        $data = array('token' => $token,'email' => $email);
        return view('auth.newaccount', $data);
    }

    public function create_password_new(Request $request)
    {
        //Validate Data
        $this->validate($request,[
            'email' => 'required|email',
            'password' => 'required|confirmed',
            'temptoken' => 'required'
        ]);
        // Define User
        $user = User::where('temptoken', $request->temptoken)->where('email', $request->email)->first();
        // Return Errors
        if(!$user){ return new JsonResponse(['message' => 'The given data was invalid.', 'errors' => array('password' => array('This credentials do not match our records'))], 422); }

        // Update
        $update = array(
            'password'  => Hash::make($request->password),
            'temptoken' => null,
            'email_verified_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        );

        if ($user->update($update)) {
            // Login User
            Auth::attempt(['email' => $user->email,'password' => $request->password]);
            if (!Auth::check()) { return new JsonResponse(['message' => 'Hmmmm'], 418); }
            return new JsonResponse([], 200);
        }
    }


    public function destroy($id)
    {
        if(User::destroy($id)){
            return response()->json(['message' => 'User Deleted'], 200);
        } else {
            return response()->json(['error' =>'error'], 403);
        }

    }

}
