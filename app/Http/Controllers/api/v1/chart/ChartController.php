<?php

namespace App\Http\Controllers\api\v1\chart;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Chart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;

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
    public function show(Chart $chart)
    {

        $ret['id'] = $chart->id;
        $ret['user_id'] = $chart->user_id;
        $ret['user_name'] = User::where('id', $chart->user_id)->value('name');
        $ret['type'] = $chart->type;
        $ret['title'] = $chart->title;
        $ret['info'] = $chart->info;
        $ret['chartdata'] = json_decode($chart->chartdata);
        $ret['chartoptions'] = json_decode($chart->chartoptions);
        $ret['created'] = $chart->created_at->format('M d Y h:i:s a');
        $ret['updated'] = $chart->updated_at->format('M d Y h:i:s a');

        return json_encode($ret);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Chart $chart)
    {


        $res = Gate::inspect('update', $chart);

        if ($res->allowed()) {

            $data = array(
                'title' => $request->title,
                'info' => $request->info,
                'chartdata' => json_encode($request->chartdata),
                'chartoptions' => json_encode($request->chartoptions),
                'type' => $request->type,
            );

            $update = Chart::where('id', $chart->id)->update($data);
            return response()->json($update);

        } else {
            return response()->json(['error' =>$res->message()], 403);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Chart $chart)
    {

        $res = Gate::inspect('delete', $chart);

        if ($res->allowed()) {
            $chart->delete();
            return response()->json(['message' => 'Chart Deleted Successfully'], 200);
        } else {
            return response()->json(['error' =>$res->message()], 403);
        }

    }
}
