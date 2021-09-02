<?php

namespace App\Http\Controllers;

use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function get(Request $request)
    {
        return Settings::where('company_id', $request->company_id)->get();
    }
    public function update(Request $request)
    {
        return $request;
    }
}
