<?php

namespace App\Http\Controllers;

use App\imgCollection;
use Illuminate\Http\Request;

class ImgCollectionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(imgCollection::all());
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




    }

    /**
     * Display the specified resource.
     *
     * @param  \App\imgCollection  $imgCollection
     * @return \Illuminate\Http\Response
     */
    public function show(imgCollection $imgCollection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\imgCollection  $imgCollection
     * @return \Illuminate\Http\Response
     */
    public function edit(imgCollection $imgCollection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\imgCollection  $imgCollection
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, imgCollection $imgCollection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\imgCollection  $imgCollection
     * @return \Illuminate\Http\Response
     */
    public function destroy(imgCollection $imgCollection)
    {
        //
    }
}
