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

        // Select
        $codes->select(
            'codes.id as id',
            'parents.name as branch',
            'codes.code as code',
            'codes.name as name',
            'codes.oby as oby',
        );
        // Joins
        $codes->join('code_categories', 'codes.code_category_id', '=', 'code_categories.id');
        $codes->join('code_categories as parents', 'parents.id', '=', 'code_categories.parent');
        // Order By
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
