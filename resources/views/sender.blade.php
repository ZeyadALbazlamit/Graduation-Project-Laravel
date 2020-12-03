@extends('layouts.app')

@section('content')

<form class="main-div" method="post" >

  <div class="form-group">
    <label >user name</label>
    <input type="text" name='user' class="form-control">
  </div>

  <div class="form-group">
    <label >comment</label>
    <input type="text" name='comment' class="form-control">
  </div>

  <button type="submit" class="btn btn-success">Submit</button>
</form>

<style>
    .main-div{

margin-left:600px;
margin-right: 600px;


    }
</style>
@endsection
