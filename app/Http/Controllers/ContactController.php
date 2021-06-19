<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        abort(404);
    }

    public function list()
    {
        $contacts = Contact::where('user_id', Auth::user()->id);
        return $contacts->get();
    }

    public function store(Request $request)
    {
        $contact = array(
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'profile_pic' => 'factory/stock/user-profile.jpg',
        );

        $newContact = $request->user()->contacts()->create($contact);
        return $newContact;
    }

    public function show(Request $request)
    {
        return Contact::where('id', $request->id)->first();
    }

    public function update(Request $request)
    {

        $updateContact = $request->only(
            'name',
            'email',
            'phone',
            'address',
            'notes'
        );

        $update = Contact::where('id', $request->id)->update($updateContact);

        if($update){
            return new JsonResponse(['message' => 'Success'], 200);
        }

        return new JsonResponse(['error' => 'Failed'], 422);

    }

    public function destroy(Contact $contact)
    {
        if($contact->delete()){
            return response()->json(['message' => 'Contact Deleted'], 200);
        } else {
            return response()->json(['error' =>'error'], 403);
        }
    }
}
