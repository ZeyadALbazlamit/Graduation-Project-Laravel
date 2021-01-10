<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reports= Report::all()->get();
        return response()->json(['reports'=>$reports]);
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
        $report=new Report();
        $report->user_id=$request->user_id;
        $report->post_id=$request->post_id;
        $report->report=$request->report ;
        $report->save();
        return  response()->json(['report'=>$report]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function show($report)
    {
        $report =Report::find($report)->first();
        if ($report) {
            return respone()->json(['post'=>$report->post,'report'=>$report]);
        }
        return respone()->json(['message'=>'not found report ']);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return \Illuminate\Http\Response
     */
    public function destroy($report)
    {
        $report =Report::find($report)->first();
        if ($report) {
            $report->delete();
            return respone()->json(['message'=>`the ${report} was deleted successfully `]);
        }
        return respone()->json(['message'=>`not found  `]);
    }

    
}
