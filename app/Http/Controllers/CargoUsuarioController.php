<?php

namespace App\Http\Controllers;

use App\Models\CargoUsuario;
use Illuminate\Http\Request;

class CargoUsuarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return CargoUsuario::orderBy('titulo', 'ASC')->get();
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
     * @param  \App\Models\CargoUsuario  $cargoUsuario
     * @return \Illuminate\Http\Response
     */
    public function show(CargoUsuario $cargoUsuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\CargoUsuario  $cargoUsuario
     * @return \Illuminate\Http\Response
     */
    public function edit(CargoUsuario $cargoUsuario)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\CargoUsuario  $cargoUsuario
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CargoUsuario $cargoUsuario)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\CargoUsuario  $cargoUsuario
     * @return \Illuminate\Http\Response
     */
    public function destroy(CargoUsuario $cargoUsuario)
    {
        //
    }
}
