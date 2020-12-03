@extends('layouts.app')

@section('content')
<!DOCTYPE html>

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="stylesheet" href="https://getbootstrap.com/2.3.2/assets/css/bootstrap.css">
        <style type="text/css">

          .df{
               width:500px;

               display:flex;
               justify-content:space-between;
               margin-left:9px;
               margin-top:9px;
               border:1px solid;
               border-radius:90px;
          }
.alert-border{
border-radius:90px;
margin:10px;
padding:10px;


}
.alert-border:hover{
    opacity: 0.4;


}


        </style>
    </head>
    <body>
        <div id="apgp">
          <div id="wrgap">
            <div class="container">
              <div class="page-header">

              </div>




    <div id="DashBoard"></div>
        <div class="df   alert alert-light">
             @foreach ($counts as $key=>$count)
             <div class="alert alert-success alert-border " role="alert">
                 <p>This is {{ $count }}</p>
                 <a href="/{{ $key }}" class="alert-link">{{ $key }}</a>
            </div>
             @endforeach
        </div>
    </div>
          </div>
        </div>
        <!-- importar component vue -->
        <script src="{{ asset('js/app.js') }}" ></script>
    </body>
</html>
@endsection
