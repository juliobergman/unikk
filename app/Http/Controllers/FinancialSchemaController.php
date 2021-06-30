<?php

namespace App\Http\Controllers;

use App\Models\FinancialSchema;
use Illuminate\Http\Request;

class FinancialSchemaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FinancialSchema  $financialSchema
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        $schema = FinancialSchema::query();
        $schema->where('id', $id);
        $schema->with(['data' => function ($query) {
            $query->where('parent', '=', null);
        }]);
        return $schema->first();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FinancialSchema  $financialSchema
     * @return \Illuminate\Http\Response
     */
    public function edit(FinancialSchema $financialSchema)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FinancialSchema  $financialSchema
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FinancialSchema $financialSchema)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FinancialSchema  $financialSchema
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinancialSchema $financialSchema)
    {
        //
    }
}
