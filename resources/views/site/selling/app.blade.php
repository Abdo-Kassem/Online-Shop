<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="description" content='this is seller page'>
        <meat name="viewport" content="width=device-width,initial-scale=0.1">
        <link rel="stylesheet" href="{{URL::asset('site/css/all.min.css')}}">
        <link rel='stylesheet' href="{{URL::asset('site/css/selling.css')}}">
        @yield('style')
    </head>
    <body>
        @yield('content')        
    </body>
    
    <script>
        var naveHeight = document.getElementById('nave').offsetHeight;
        var containner = document.getElementsByClassName('containner')[0];
        containner.style.paddingTop = naveHeight+'px';
    </script>
</html>