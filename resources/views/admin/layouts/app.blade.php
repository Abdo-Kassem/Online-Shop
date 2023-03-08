<!DOCTYPE html>
<html>
    <head>
        <title>adminstrator</title>
        <link rel="icon" type="image/x-icon" href="/images/favicon.ico">
        <meta charset="utf-8" >
        <meta name="content" description='admin panel'>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel='stylesheet' href="{{URL::asset('admin/css/app.css')}}">
        <link rel='stylesheet' href="{{URL::asset('admin/css/all.min.css')}}">
        @yield('style')
    </head>
    <body>
        <div class='page-body'>
            <header class='top-header'>
                <div class='containner'>
                    <div class='logo'>
                        <span class='text'>admin config</span>
                    </div>
                    <div class='admin-profile' >
                        <span class='admin-name'>{{Auth::guard('admin')->user()->name}}</span>
                        <i class="far fa-user"></i>
                        <div class='dropdown'>
                            <span class='sub-dropdown'></span>
                            <nav  class='data'>
                                <ul class='links'>
                                    <li>
                                        <a id='logout' href="{{route('admin.logout')}}">log out </a>
                                    </li>
                                    <li>
                                        <a href="{{route('admin.profile')}}">edit admin data</a>
                                    </li>
                                    <li>
                                        <a href="{{route('admin.home')}}">admin home</a>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                        
                    </div>
                </div>
            </header>
            <div class='main-containner'>
                <div class='left-side'>
                    <nav class=''>
                        <ul class='links'>
                            <li><a id='order' href="{{route('orders.show')}}">orders show</a></li>
                            <li><a id='seller' href="{{route('get.admin.seller')}}">sellers manage</a></li>
                            <li><a id='category' href="{{route('get.admin.categories')}}">catgoery manage</a></li>
                            <li><a id='subcategory' href="{{route('get.admin.subcategories')}}">subcatgory manage </a></li>
                            <li><a id='item' href="{{route('get.admin.items')}}">items manage</a></li>
                            <li><a id='ads' href="{{route('create.ads')}}">add ads</a></li>
                            <li><a id='show-ads' href="{{route('show.ads')}}">show ads</a></li>
                        </ul>
                    </nav>
                </div>
                <div class='right-side'>
                    <section class='data-config'>
                        @yield('content')
                    </section>
                </div>
            </div>
        </div>
    </body>
    
    <script>
        var failMessage = document.getElementById('message');
        setTimeout(function(){
            failMessage.style.display='none';
        },4000000)
        
    </script>
</html>
