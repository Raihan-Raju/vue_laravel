<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\File;

class FlightController extends Controller
{
    public function index()
    {
        $jsonData = File::get(storage_path('app/flight/data.txt'));
        $data = json_decode($jsonData, true);
        return response()->json($data);
    }
}
