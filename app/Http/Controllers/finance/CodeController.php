<?php

namespace App\Http\Controllers\finance;

use App\Http\Controllers\Controller;
use App\Models\finance\Code;
use Illuminate\Http\Request;

class CodeController extends Controller
{

    public function index()
    {
        $codes = Code::query();
        $codes->orderBy('oby');
        return $codes->get();
    }

    public function store(Request $request)
    {
        //
    }

    public function show(Code $code)
    {
        //
    }

    public function update(Request $request, Code $code)
    {
        //
    }

    public function destroy(Code $code)
    {
        //
    }
}
