@extends('site.selling.app')
@section('style')
<link rel='stylesheet' href="{{URL::asset('site\css\formStyle.css')}}">
@endsection
@section('content')

<div class='container' style="margin-top:120px">
    <header >
        <h3>seller login</h3>
    </header>
    <div class='body' style="padding-bottom:30px">

        @if(session()->has('fail'))
            <div id='message'class='fail-message'>
                <i class="fas fa-times-circle"></i>
                {{session()->get('fail')}}
            </div>
        @endif

        <form method='post' action="{{route('seller.login')}}">
            @csrf

            <div class="form-group">
                <label for="sellerID">seller personal ID</label>
                <input type="text"  id="sellerID" name='id' placeholder="seller ID" >
                @error('id')
                    <span style='color:brown' >{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">seller e-mail</label>
                <input type="email"  id="email" name='email' placeholder="seller email">
                @error('email')
                    <span style='color:brown' >{{$message}}</span>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">seller password</label>
                <input type="password"  id="password" name='password' placeholder="seller passsword">
                @error('password')
                    <span style='color:brown' >{{$message}}</span>
                @enderror
            </div>

            <button type="submit" class="submite">login</button>

        </form>

    </div>
</div>

<script>
    setTimeout(function(){
        document.getElementById('message').style.display = 'none';
    },5000)
</script>
@endsection