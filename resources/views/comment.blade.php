<!DOCTYPE html>
<html >
    <head>
    <script src="https://js.pusher.com/5.0/pusher.min.js"></script>
    <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Laravel</title>
        <link rel="stylesheet" href="https://getbootstrap.com/2.3.2/assets/css/bootstrap.css">
        <style type="text/css">

        </style>
    </head>
    <body>
        <div id="app">
          <div id="wrap">
            <div class="container">
              <div class="page-header">
                <h1>Laravel + Websockets + React.js</h1>
              </div>
              <h3> Message </h3>
              <!-- component react -->

              <div id="example"></div>
              <div id="comment"></div>
<div class="addComment">
</div>
            </div>
          </div>
        </div>
        <!-- importar component vue -->
        <script src="{{ asset('js/app.js') }}" ></script>
    </body>
</html>
