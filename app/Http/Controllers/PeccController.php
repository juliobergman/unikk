<?php

namespace App\Http\Controllers;

use App\Models\Pecc;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class PeccController extends Controller
{

    public function index()
    {
        abort(404);
    }

    public function list()
    {
        $peccs = Pecc::where('user_id', Auth::user()->id);
        return $peccs->get();
    }

    public function store(Request $request)
    {
        $pecc = array(
            'fund' => $request->fund,
            'type' => $request->type,
            'region' => $request->region,
            'based' => $request->based,
            'main_countries' => $request->main_countries,
            'main_cities' => $request->main_cities,
            'sector' => $request->sector,
            'geo_focus' => $request->geo_focus,
            'notes' => $request->notes,
            'logo' => 'factory/stock/company-logo.jpg',
        );

        $newPecc = $request->user()->peccs()->create($pecc);
        return $newPecc;
    }

    public function show(Request $request)
    {
        $pecc = Pecc::where('id', $request->id)->first();

        if ($pecc) {
            return $pecc;
        }

        return new JsonResponse(['error' => 'Not Found'], 404);
    }

    public function update(Request $request)
    {

        $updatePecc = $request->only(
            'fund',
            'type',
            'region',
            'based',
            'main_countries',
            'main_cities',
            'sector',
            'geo_focus',
            'notes'
        );

        $update = Pecc::where('id', $request->id)->update($updatePecc);

        if($update){
            return new JsonResponse(['message' => 'Success'], 200);
        }

        return new JsonResponse(['error' => 'Failed'], 422);

    }

    public function destroy(Pecc $pecc)
    {
        if($pecc->delete()){
            return response()->json(['message' => 'Pecc Deleted'], 200);
        } else {
            return response()->json(['error' =>'error'], 403);
        }
    }
}
