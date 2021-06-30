<?php

namespace App\Http\Controllers;

use App\Models\FinancialFields;
use Illuminate\Http\Request;

class FinancialFieldsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FinancialFields::all();
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
     * @param  \App\Models\FinancialFields  $financialFields
     * @return \Illuminate\Http\Response
     */
    public function show(FinancialFields $financialFields)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\FinancialFields  $financialFields
     * @return \Illuminate\Http\Response
     */
    public function edit(FinancialFields $financialFields)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\FinancialFields  $financialFields
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, FinancialFields $financialFields)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\FinancialFields  $financialFields
     * @return \Illuminate\Http\Response
     */
    public function destroy(FinancialFields $financialFields)
    {
        //
    }
}
