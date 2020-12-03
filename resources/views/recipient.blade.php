<!DOCTYPE html>
<html >
    <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://js.pusher.com/5.0/pusher.min.js"></script>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="stylesheet" href="https://getbootstrap.com/2.3.2/assets/css/bootstrap.css">

    </head>
    <body>
        <div id="app">
          <div id="wrap">
            <div class="container">
              <div class="page-header">

              </div>

              <!-- component react -->
<script>
if(localStorage.getItem('uid') == null)
{
    localStorage.setItem('uid' ,{{ auth()->user()->id}} );
}


</script>
              <div id="//recipient//"></div>

            </div>
          </div>
        </div>
        <!-- importar component vue -->
        <script src="{{ asset('js/app.js') }}" ></script>
    </body>
</html>
