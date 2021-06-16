<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name', 'MarcaSite') }}</title>

</head>

<body>
    <div id="app">
        <app></app>
    </div>
    <footer class="fotter py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright ©️ Bernardo Alves Roballo</p>
        </div>
    </footer>
    <script src="{{mix('js/app.js')}}"></script>
</body>


</html>