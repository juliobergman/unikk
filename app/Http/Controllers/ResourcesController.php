<?php

namespace App\Http\Controllers;

use App\Models\ResCountry;
use App\Models\ResCurrency;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    public function countries()
    {
        return ResCountry::all()->toArray();
    }
    public function currencies()
    {
        return ResCurrency::all()->toArray();
    }
}
