@extends('site.selling.app_links')

@section('sub-content')
<?php use Illuminate\Support\Facades\Auth; ?>
<div class='home-container'>
    <div class='home-sub-container'>
        <div class='left-side'>
            <nav>
                <ul class='links'>
                    <li>
                        <a id='show-orders' href="{{route('seller.show.orders')}}">
                            show orders
                        </a>
                    </li>
                    <li>
                        <a id='show-products' href="{{route('seller.show.product')}}">
                            show products
                        </a>
                    </li>
                    <li>
                        <a id='create-product'href="{{route('product.create')}}">create product</a>
                    </li>
                    <li>
                        <a id='analyze-week' href="{{route('seller.analyze')}}">analyze your week</a>
                    </li>
                    <li>
                        <a  id='create-new-shop' href="{{route('seller.create_shop')}}">create new shop</a>
                    </li>
                    <li>
                        <a id='customer-feedback' href="{{route('seller.customer.feedback')}}">customer feedback</a>
                    </li>
                    <li>
                        <a id='your-customer' href="{{route('seller.customer')}}">your customer</a>
                    </li>
                </ul>
            </nav>
        </div>
        @yield('page-right-side')
        
    </div>
</div>
<script>
    var elemWillActive = document.getElementById('home');
    elemWillActive.classList.add('active');
</script>
@endsection
