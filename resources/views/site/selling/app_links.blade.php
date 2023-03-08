@extends('site.selling.app')

@section('content')
<nav class='navigation-link' id='nave'>
    <ul class='links'>
        @if(!Auth::guard('seller')->user())
        <li class='swap register'>
            <a class='active' href="{{route('seller.register.form')}}">register</a>
        </li>
        @endif
        <li class='home'>
            <a href="{{route('seller.home')}}" id='home'>home</a>
        </li>
        <li class='shipping' >
            <a href="{{route('seller.shipping')}}" id='shipping'>shipping and delivery</a>
        </li>
        <li class='selling-expenses'>
            <a href="{{route('seller.selling-expenses')}}" id='selling_expenses'>selling expenses</a>
        </li>
        <li class='language'>
            <i></i>
            <a href='#' >english</a>
        </li>
        @if(Auth::guard('seller')->user())
        <li class='swap swap-profile'>
            <div class='seller-profile'>
                <span' class='name'>{{Auth::guard('seller')->user()->name}}</span>
                <img src="{{URL::asset('site/images/profile').'/'. Auth::guard('seller')->user()->image}}">
                <div class='dropdown-container'>
                    <span class='arrow'></span>
                    <div class='dropdown-list'>
                        <a href="" onclick="logoutHandle()">
                            logout
                        </a>
                        <form id='logout-form' method='post' action="{{route('seller.logout')}}" style='display:none'>
                            @csrf
                        </form>
                        <a href="{{route('seller.profile')}}">profile setting</a>
                    </div>
                </div>
            </div>
        </li>
        @endif
    </ul>
</nav>
@yield('sub-content')
<script>
    function logoutHandle(){
        event.preventDefault();
        document.getElementById('logout-form').submit();
    }
</script>
@endsection