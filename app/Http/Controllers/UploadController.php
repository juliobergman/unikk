<?php

namespace App\Http\Controllers;
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
        Storage::delete($deletepath);

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

}
