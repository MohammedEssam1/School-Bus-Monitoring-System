<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class AccelerometerController extends Controller
{
    use ResponseTrait;
    public function index()
    {
        $accelerometer_readings = DB::table('bus_accelerometer_readings')->get();
        return $this->respondSuccess($accelerometer_readings);
    }
}
