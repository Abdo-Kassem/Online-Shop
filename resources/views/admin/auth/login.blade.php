@extends('site.selling.app')
@section('style')
<link rel='stylesheet' href="{{URL::asset('site\css\formStyle.css')}}">
@endsection
@section('content')
<div class='container' style="margin-top:120px">
        <header >
            <h3>admin login</h3>
        </header>
        <div class='body' style="padding-bottom:30px">
        @if(session()->has('fail'))
            <div id='message'class='fail-message'>
                <i class="fas fa-times-circle"></i>
                {{session()->get('fail')}}
            </div>
        @endif
        <form method='post' action="{{route('admin.login')}}">
            @csrf
            <div class="form-group">
                <label for="email">admin e-mail</label>
                <input type="email"  id="email" name='email' placeholder="admin email">
                @error('email')
                    <span style='color:brown' >{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="password">admin password</label>
                <input type="password"  id="password" name='password' placeholder="admin passsword">
                @error('password')
                    <span style='color:brown' >{{$message}}</span>
                @enderror
            </div>
            <div class='form-group'>
                <a href="{{route('admin.password.reset','admin')}}">forget password</a>
            </div>
            <button type="submit" class="submite">login</button>
        </form>
    </div>
</div>
<script src="/js/app.js"></script>
<script>
    setTimeout(function(){
        document.getElementById('message').style.display = 'none';
    },5000)
</script>
@endsection