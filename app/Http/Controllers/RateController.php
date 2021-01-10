<?php

namespace App\Http\Controllers;

use App\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $rate=Rate::all();
        return response()->json(["rate"=>$rate]);

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
        $rate= Rate::where('user_id', $request->user_id)->where("rater", $request->rater)->first();
        if ($rate) {
            $rate->rate=$request->rate;
            $rate->save();
            return response()->json(["rate"=>$rate]);
        } else {
            $rate=new Rate();
            $rate->user_id=$request->user_id;
            $rate->rater=$request->rater;
            $rate->rate= $request->rate;
            $rate->save();
            return response()->json(["rate"=>$rate]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        $query=DB::select("select  count(*) count from rates where user_id=?", [$user]);
        $count=$query[0]->count ;
        if ($count==0) {
            $count++;
        }
        $query=DB::select("select sum(rate) sum from rates where user_id=?", [$user]);
        $sum=$query[0]->sum;
        return response()->json([ "rate"=>$sum/$count ,'sum'=>$sum,"count"=>$count]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function edit(Rate $rate)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rate $rate)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rate  $rate
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rate $rate)
    {
        //
    }
}
