<?php

namespace App\Http\Controllers;

use App\Models\CompanyData;
use App\Models\Contact;
use App\Models\UserData;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class UploadController extends Controller
{
    public function avatar(Request $request)
    {

        // Validation
        $request->validate([
            'avatar' => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        // Delete Old Avatar
        $oldpath = UserData::select('profile_pic')->where('user_id', $request->user()->id)->first();
        $deletepath = str_replace('/storage/', '/public/', $oldpath->profile_pic);

        $factory = strstr($deletepath, 'factory/');

        if(!$factory){
            Storage::delete($deletepath);
        };

        // Upload New Avatar
        $newpath = Storage::putFile('public/avatars/'.$request->user()->id, new File($request->file('avatar')));
        $dbpath = Storage::url($newpath);
        $update = array('profile_pic' => $dbpath);

        // Update User Data @ (profile_pic)
        if ($newpath) {
            UserData::where('user_id', $request->user()->id)->update($update);
        }

        // Response
        return new JsonResponse(['message' => 'Success', 'path' => $dbpath], 200);

    }

    public function companylogo(Request $request)
    {

        // Validation
        $request->validate([
            'logo' => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        // Delete Old Logo
        $oldpath = CompanyData::select('logo')->where('company_id', $request->company)->first();
        $deletepath = str_replace('/storage/', '/public/', $oldpath->logo);

        $factory = strstr($deletepath, 'factory/');

        if(!$factory){
            Storage::delete($deletepath);
        };

        // Upload New Logo
        $newpath = Storage::putFile('public/company/'.$request->company.'/logo', new File($request->file('logo')));
        $dbpath = Storage::url($newpath);
        $update = array('logo' => $dbpath);

        // Update Company Data @ (logo)
        if ($newpath) {
            CompanyData::where('company_id', $request->company)->update($update);
        }

        // Response
        return new JsonResponse(['message' => 'Success', 'path' => $dbpath], 200);

    }

    public function contact(Request $request)
    {

        // Validation
        $request->validate([
            'avatar' => 'required|mimes:png,jpg,jpeg|max:2048'
        ]);

        // Delete Old Avatar
        $oldpath = Contact::select('profile_pic')->where('id', $request->id)->first();
        $deletepath = str_replace('/storage/', '/public/', $oldpath->profile_pic);

        $factory = strstr($deletepath, 'factory/');

        if(!$factory){
            Storage::delete($deletepath);
        };

        // Upload New Avatar
        $newpath = Storage::putFile('public/contacts/'.$request->id, new File($request->file('avatar')));
        $dbpath = Storage::url($newpath);
        $update = array('profile_pic' => $dbpath);

        // Update User Data @ (profile_pic)
        if ($newpath) {
            Contact::where('id', $request->id)->update($update);
        }

        // Response
        return new JsonResponse(['message' => 'Success', 'path' => $dbpath], 200);

    }

}
