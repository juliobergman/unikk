<?php

namespace App\Http\Controllers\api\v1\chart;

use App\Models\Chart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ChartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $charts = Chart::orderBy('created_at', 'DESC')->get();



        if (!$charts->count()) {
            return response()->json(['error' => 'No Records Found'], 204);
        }

        foreach ($charts as $key => $value) {
            $ret[$key]['id'] = $value->id;
            $ret[$key]['user_id'] = $value->user_id;
            $ret[$key]['type'] = $value->type;
            $ret[$key]['title'] = $value->title;
            $ret[$key]['chartdata'] = json_decode($value->chartdata);
            $ret[$key]['chartoptions'] = json_decode($value->chartoptions);
        }

        return json_encode($ret);
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

        $data = array(
            'title' => $request->title,
            'info' => $request->info,
            'chartdata' => json_encode($request->chartdata),
            'chartoptions' => json_encode($request->chartoptions),
            'type' => $request->type,
        );

        $newChart = $request->user()->charts()->create($data);
        return $newChart;

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Chart::where('id', $id)->get();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
