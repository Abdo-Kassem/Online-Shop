@extends('site.selling.app_links')
@section('sub-content')
<div class='containner'>
    <div class='sub-containner'>
        <div class='left-side'>
            <img src="{{URL::asset('site/images/site-images/selling.jpg')}}">
        </div>
        <div class='right-side'>
            <header>
                <h1>
                    Sell on online marketing and grow your business all over Egypt
                </h1>
            </header>
            <div class='registration'>
                <div class='register'>
                    <span>new seller?</span>
                    <a href="{{route('seller.register.form')}}">register here</a>
                </div>
                <div class='login'>
                    <span>already have an account</span>
                    <a href="{{route('seller.login.form')}}">login</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection