@extends('site.selling.app')
@section('content')
<div class='profile-containner'>
    <header class='header'>
        <div class='header-containner'>
            <h1>profile setting</h1>
            <div class="seller-data">
                <span class='name'>{{$seller->name}}</span>
                <div class='image-arrow'>
                    <img src="{{URL::asset('site/images/profile').'/'.$seller->image}}">
                    <span class='arrow'></span>
                    <div class="dropdown-list">
                        <a href="{{route('seller.edit')}}">edite profile</a>
                        <a href="{{route('seller.profile')}}">main profile page</a>
                        <a href="{{route('seller.home')}}">home</a>
                    </div>
                </div>
            </div>
        </div>
    </header>
    @yield('sub-content')
</div>
@endsection