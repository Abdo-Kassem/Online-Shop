@extends('site.layout.app')
@section('style')
<link rel='stylesheet' href="{{URL::asset('site/css/sign_in_up.css')}}">
@endsection
@section('content')
    <div class="container">
        <div class='form-header'>
            user-update
            @if(session()->has('fail'))
                <small>{{session()->get('fail')}}</small>
            @endif
        </div>
        <form method="POST" action="{{route('user.update')}}" class='form'>
             @csrf
            <div class='input-center'>
                <input type="text" name="email" placeholder="Email" autofocus value="{{$user->email}}" >
                @error('email')
                    <small>{{$message}}</small>
                @enderror
                <input type="text" name="userName" placeholder="UserName" value="{{$user->name}}" >
                @error('userName')
                    <small>{{$message}}</small>
                @enderror

                <input type="text" name="address" placeholder="like assiut,manfalut 25 naser street" 
                        value="{{$user->address}}"> 
                @error('address')
                    <small>{{$message}}</small>
                @enderror
                <input type='hidden' value="{{$user->id}}" name='id'>
             </div>
            <button type="submit">save</button>
        </form>
        <a href="{{route('user.acount')}}"> back </a>
    </div>
@endsection
