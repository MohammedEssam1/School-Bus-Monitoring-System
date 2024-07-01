<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class LocationController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $location = DB::table('bus_coordinates')->where('id', 1)->get();
        return $this->respondSuccess($location);
    }
}
