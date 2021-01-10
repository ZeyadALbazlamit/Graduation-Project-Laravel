<?php

namespace App\Http\Controllers;

use App\Interests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InterestsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Interests::all());
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
        $int=DB::select('select id from interests where user_id=? and category_id=?',[$request->user_id,$request->category_id]);
if (count($int)>0) {
    $int=Interests::find($int[0]->id);
    $int->count=$int->count+1;
$int->save();
return response()->json("old");
}else{
    $int =new Interests();
    $int->category_id=$request->category_id;
    $int->user_id= $request->user_id;
    $int->count=1;
    $int->save();
    return response()->json("new");
}

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Interests  $interests
     * @return \Illuminate\Http\Response
     */
    public function show(Interests $interests)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Interests  $interests
     * @return \Illuminate\Http\Response
     */
    public function edit(Interests $interests)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Interests  $interests
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Interests $interests)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Interests  $interests
     * @return \Illuminate\Http\Response
     */
    public function destroy(Interests $interests)
    {
        //
    }
}
