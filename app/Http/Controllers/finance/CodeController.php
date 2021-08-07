<?php

namespace App\Http\Controllers\finance;

use App\Http\Controllers\Controller;
use App\Models\finance\Code;
use Illuminate\Http\Request;

class CodeController extends Controller
{

    public function index(Request $request)
    {
        $codes = Code::query();
        // Where
        $codes->where('group.type', $request->type);
        // Select
        $codes->select(
            'codes.id as id',
            'parents.name as branch',
            'group.type as type',
            'codes.code as code',
            'codes.name as name',
            'codes.oby as oby',
        );
        // Joins
        $codes->join('code_categories', 'codes.code_category_id', '=', 'code_categories.id');
        $codes->join('code_categories as parents', 'parents.id', '=', 'code_categories.parent');
        $codes->join('code_groups as group', 'codes.group', '=', 'group.id');
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
