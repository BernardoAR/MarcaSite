<?php

namespace App\Http\Controllers;

use App\Http\Resources\Status as ResourcesStatus;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(ResourcesStatus::collection(Status::all()));
    }
}
