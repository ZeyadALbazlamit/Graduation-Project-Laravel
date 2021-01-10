<?php

namespace App\Http\Controllers;

use App\Dashboard;
use App\User;
use App\Post;
use App\comment;
use App\Report;

use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $counts=['users'=>User::count(),'companies'=>User::where('type',"company")->count(),'posts'=>Post::count(),'comments'=>comment::count(),'reports'=>Report::count()];

    return response()->json(["counts"=>$counts]);
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
     * @param  \App\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function show($kind)
    {
      switch($kind){
            case "users":    return response()->json(['users'=>DB::select('select * from users')]);     break;
            case "comments": return response()->json(['comments'=>DB::select('select * from comments')]);       break;
            case "posts":    return response()->json(['posts'=>DB::select('select * from posts order by id desc ')]);   break;
            case "companies":  return response()->json(['users'=>User::where("type","company")->get()]);      break;
            case "reports":  return response()->json(['reports'=>Report::all()]);      break;
            }
return "0";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function edit(Dashboard $dashboard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Dashboard $dashboard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Dashboard  $dashboard
     * @return \Illuminate\Http\Response
     */
    public function destroy(Dashboard $dashboard)
    {
        //
    }
}
