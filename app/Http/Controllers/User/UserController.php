<?php

namespace App\Http\Controllers\User;


use App\Models\User;

use App\Events\userCreated;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Models\UserData;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{

    public function index()
    {
        return User::all();
    }

    public function currentUser()
    {
        $user = collect(Auth::user());
        $userdata = UserData::where('user_id', Auth::user()->id)->first();
        $merged = $user->merge($userdata);
        return $merged;
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
            'role' => $data['role'],
            'password' => Hash::make($data['password']),
            'temptoken' => urlencode(Hash::make($data['temptoken'])),
        ]);
    }

    public function store(Request $request)
    {

        $this->validator($request->all())->validate();
        event(new userCreated($user = $this->create($request->all())));
        return new JsonResponse([], 201);
    }

    public function update(Request $request)
    {
        $update = User::where('id', $request->id)->update($request->only('name','email','role'));

        if($update){
            return new JsonResponse([], 200);
        }
        return new JsonResponse([], 422);

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
