<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>user regester</title>
    <style>

    </style>
</head>
<body>
    <div>
        <h2> welcome {{$user->name}} in online shop</h2>

        <div>
            <img width='200px' height='100px' src="{{$message->embed('C:\xampp\htdocs\onlinShop\public\site\images\icons\jumia-logo.png')}}">
            <p>please verify email to complete regesteration operation</p>
            <p>your email : {{$user['email']}}</p>
            
            <a href="{{route($routeName,$token)}}">verify email</a>
        </div>
    </div>
</body>
</html>