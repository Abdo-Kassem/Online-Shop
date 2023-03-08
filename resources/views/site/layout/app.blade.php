<!doctype html>
<html>

    <head>
        <title>onlineMarketing</title>
        <meta charset="utf-8">
        <meat name="viewport" content="width=device-width,initial-scale=0.1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <link rel="stylesheet" href="{{URL::asset('site/css/header.css')}}">
        <link rel="stylesheet" href="{{URL::asset('site/css/common.css')}}">
        <link rel="stylesheet" href="{{URL::asset('site/css/all.min.css')}}">
        <link rel="stylesheet" href="{{URL::asset('site/css/index.css')}}">
        @yield('style')

    </head>

    <body>
        <div class="banner">
            <a class="logo-link" href="{{route('home')}}" >
                <img src="{{URL::asset('site/images/icons/header-logo.png')}}">
            </a>
        </div>
        <div class="language-details">
            <div class="container">
                <div class="sell-jumia-container">
                    <a href="{{route('selling')}}" class="sell-jumia">
                        <i class="far fa-star"></i>
                        <span>sell in online shop</span>
                    </a>
                </div>
                <div class="language">
                    <a href="#" class="active english">
                        <span>english</span>
                    </a>
                    <span>|</span>
                    <a href="#" class="arabic">
                        <span>عربي</span>
                    </a>
                </div>
            </div>
        </div>
        <div class="header-container">
            <header class="website-header">
                <div class="logo">
                    <a href="{{route('home')}}">
                        <img src="{{URL::asset('site/images/icons/jumia-logo.png')}}">
                    </a>
                </div>
                <div class="search">
                    <form method="post" action="{{route('search')}}">
                        @csrf
                        <input autofocus type="search" name='data' class="search-input-icon" placeholder="type product need">
                        <button type="submit" class="search-button"> serach </button>
                    </form>
                </div>
                <nav class="links">
                    <div class="acount">
                        <i class="far fa-user"></i>
                        @if(Auth::user()!=null)
                         <span class="text">Hi {{Auth::user()->name}}</span>
                        @else
                         <span class="text">acount</span>
                        @endif
                        <span class="arrow"></span>
                        <div class="dropdown">
                            @if(Auth::user()!=null)
                                <div class="sign-in">
                                    <a href="{{url('logout')}}">
                                        logout
                                    </a>
                                </div>
                            @else
                                <div class="sign-in">
                                    <a href="{{url('login')}}">
                                        sign in
                                    </a>
                                </div>
                            @endif
                            <div class="my-acount">
                                <a href="{{route('user.acount')}}">
                                    <i class="far fa-user"></i>
                                    <span>my acount</span>
                                </a>
                            </div>
                            <div class="orders">
                                <a href="{{route('user.orders')}}">
                                    <i class="fab fa-jedi-order"></i>
                                    <span>orders</span>
                                </a>
                            </div>
                            <div title='contain item you love' class="saved-items">
                                <a href="{{route('saved-items')}}">
                                    <i class="far fa-heart"></i>
                                    <span >saved items</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="help">
                        <i class="far fa-question-circle"></i>
                        <span>help</span>
                        <span class="arrow"></span>
                        <div class="dropdown">
                            <div class="common help-center">
                                <a href="">
                                    help-center
                                </a>
                            </div>
                            <div class="common place-track-order">
                                <a href="#">
                                    place and track order
                                </a>
                            </div>
                            <div class="common order-cancelation">
                                <a href="#">
                                    order cancelation
                                </a>
                            </div>
                            <div class="common returns-refunds">
                                <a href="#">
                                    returns & refunds
                                </a>
                            </div>
                        </div>
                    </div>
                    <a href="{{route('user.cart')}}" class="cart">
                        <i class="fas fa-cart-plus"></i>
                        @if(isset($userItemsCount) &&  $userItemsCount > 0)
                            <span class='cart-notification'>{{$userItemsCount}}</span>
                        @endif
                        <span>cart</span>
                    </a>
                </nav>
            </header>
        </div>
        <main class="main-content">
          @yield('content')
        </main>
        <footer class='footer'>
            <div class='logo'>
                <a href="">online shop</a>
            </div>
            <div class="links">
                <ul>
                    <li>
                        <a href="{{route('home')}}">home</a>
                    </li>
                    <li>
                        <a href="{{route('user.acount')}}">my acount</a>
                    </li>
                    <li>
                        <a href="{{route('saved-items')}}">saved products</a>
                    </li>
                    <li>
                        <a href="{{route('user.orders')}}">orders</a>
                    </li>
                    <li>
                        <a href="{{route('login')}}">login</a>
                    </li>
                    <li>
                        <a href="{{route('register')}}">register</a>
                    </li>
                </ul>
            </div>
            <div class="pages">
                <ul>
                    <li>
                        <a href="">
                            <i class="fab fa-facebook"></i>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="fab fa-youtube"></i>
                        </a>
                    </li>
                    <li>
                        <a href="">
                            <i class="fab fa-twitter-square"></i>
                        </a>
                    </li>
                </ul>
            </div>
        </footer>
        <script src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous">
        </script>
        @yield('showitem')<!! use to write showItem javacript here!!>
        <script>
            var images=Array.from(document.querySelectorAll('#images a'));
            var imagesNumber=images.length-1;
            var prev_button=document.getElementsByClassName('prev')[0];
            var next_button=document.getElementsByClassName('next')[0];
            images[0].classList.add('active-images');
            var count_slid=0;
            setInterval(function() {
                if(count_slid!=imagesNumber){
                    next();
                    return;    
                }
                count_slid=-1;
            }, 8000);
            function prev(){
                if(count_slid==0){
                    return;
                }
               
                count_slid--;
                changeImage();
            }
            function next(){
                if(count_slid==imagesNumber){
                    return;
                }
                count_slid++;
                changeImage();
            }
            function changeImage(){
                activeDelete();
                images[count_slid].classList.add("active-images");
            }   
            function activeDelete(){
                images.forEach(element => {
                    element.classList.remove('active-images');
                });
            }  
        </script>
        
    </body>
</html>