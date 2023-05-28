<!doctype html>
<html>
<head>
    <meta charset='utf-8'>
    <title>register</title>
    <link rel="icon" href="../images/icons/favicon.jpg">
    <meta name='viewport' content='width=device-width,intial-scale=0.1'>
    <link rel="icon"  href="{{URL::asset('images/icons/favicon.jpg')}}">
    <link rel='stylesheet' href="{{URL::asset('site/css/sign_in_up.css')}}">
</head>
<body>
    <div class="container">
        <div class='form-header'>
            register
            @if(session()->has('creation_failed'))
                <small>{{session()->get('creation_failed')}}</small>
            @endif
        </div>
        <form method="POST" action="{{route('register')}}" class='form'>
             @csrf
            <div class='input-center'>
                <input type="text" name="email" placeholder="Email" autofocus id='email' >
                @error('email')
                    <small>{{$message}}</small>
                @enderror
                <input type="text" name="userName" placeholder="UserName" autofocus id='userName' >
                @error('userName')
                    <small>{{$message}}</small>
                @enderror
                <input type="text" name="address" placeholder="like assiut,manfalut 25 naser street"
                       > 
                @error('address')
                    <small>{{$message}}</small>
                @enderror
                <input type="password" name="password" minlength="8" maxlength="20"
                    title="min=>8 max=>20 characters" placeholder="type password here" id='password' >
                @error('password')
                     <small>{{$message}}</small>
                @enderror
                <input type="password" name="password_confirmation" minlength="8" maxlength="20"
                     title="min=>8 max=>20 characters" placeholder="type confirm password here" id='confirm_password' > 
                
             </div>
            <button type="submit">register</button>
        </form>
        <a href="{{route('login')}}"> have acount? : login</a>
    </div>
    <script>
        var user = document.getElementsByClassName("user")[0];
        var password = document.getElementsByClassName('password')[0];
        var input_email = document.getElementById('user_name');
        var input_password = document.getElementById("password");
        input_email.addEventListener('focus',function(){
            user.style.opacity='1';
            password.style.opacity='0.5';
        });
        input_password.addEventListener('focus',function(){
            password.style.opacity='1';
            user.style.opacity='0.5';
        });
    </script>
</body>
</html>
