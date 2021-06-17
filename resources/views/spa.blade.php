<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta author="Bernardo Alves Roballo">
  <title>{{ config('app.name', 'MarcaSite') }}</title>
  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
</head>

<body>
  <div id="app">
    @if(Auth::check())
    <app :usuario="{{Auth::user()}}"></app>
    @else
    <app :usuario="false"></app>
    @endif
  </div>
  <script src="{{mix('js/app.js')}}"></script>
</body>

</html>