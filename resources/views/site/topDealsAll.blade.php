@extends('site.layout.app')
@section('style')
<link rel='stylesheet' href="{{URL::asset('site/css/category_page.css')}}">
@endsection
@section('content')
@foreach($topDeals as $topDealKey => $topDealValue) {{--note that $topDeals array of associative array --}}
    @if(count($topDealValue)>0)
    <section class="sub-category-hot-deals">
        <div class="header" style="display:block">
            <h3 style='text-align:center'>{{$topDealKey}} top-deals!</h3>
        </div>
        <div class="content">
            @foreach($topDealValue as $ItemAndDiscount)
            <a href="{{route('item.details',$ItemAndDiscount->id)}}">
                <img src="{{URL::asset('site/images/categories/'.$topDealKey.'/'.$ItemAndDiscount->image)}}" >
                <div class="description">
                    <div class="name">
                        {{$ItemAndDiscount->name}}
                    </div>
                    <div class="price">
                        <span class="new-price">
                            price : {{$ItemAndDiscount->newPrice}}$
                        </span>
                        <del class="old-price">
                            {{$ItemAndDiscount->price}}$
                        </del>
                    </div>
                    <div class="discount">
                        -{{$ItemAndDiscount->discount->discount_value}}%
                    </div>
                   
                </div>
            </a>
            @endforeach
        </div>
    </section>
    @endif
@endforeach
@endsection