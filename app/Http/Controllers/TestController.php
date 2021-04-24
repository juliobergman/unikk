<?php

namespace App\Http\Controllers;

use App\Models\Pecc;
use App\Models\User;
use App\Models\Chart;
use App\Models\UserData;
use App\Models\ReportsSchema;

use Illuminate\Http\Request;


class TestController extends Controller
{
    public function indexrrrr()
    {
        $result = Chart::query();

        $result->with('user');

        return $result->get();
    }
    public function index()
    {
        $result = ReportsSchema::query();
        $result->where('parent', null);

        // if($result->withCount('children')){
        //     $result->with('children');
        // }
        $result->with('children');

        return $result->get();
    }
}
