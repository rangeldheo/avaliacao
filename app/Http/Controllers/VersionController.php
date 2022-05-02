<?php

namespace App\Http\Controllers;

use App\Http\Resources\ApiResponse;
use Illuminate\Http\Request;

class VersionController extends Controller
{
    public function index()
    {
        return ApiResponse::return([
            'version' => 'v1'
        ]);
    }
}
