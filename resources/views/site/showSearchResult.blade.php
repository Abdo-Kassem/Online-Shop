
@extends('site.layout.app')
@section('style')
<link rel='stylesheet' href="{{URL::asset('site/css/search_item.css')}}">
@endsection
@section('content')

<section class="sub-category-hot-deals">
    <div class="header" >
        <h7>{{$items->count()}} product found</h7>
    </div>
    <div class="content">
    @if(!$items->isEmpty())
        @foreach($items as $item)
    <div class='item'>
        <a href="{{route('item.details',$item->id)}}">
            <img src="{{URL::asset('site/images/categories/'.$item->supCategory->category->name.'/'.$item->image)}}" >
            <div class="description">
                <div class="name">
                    {{$item->name}}
                </div>
                @if(isset($item->discount_value))
                    <div class="price">
                        <span class="new-price">
                            price : {{$item->newPrice}}$
                        </span>
                        <del class="old-price">
                            {{$item->price}}$
                        </del>
                    </div>
                    <div class="discount">
                        {{$item->discount->discount_value}}
                    </div>
                @else
                    <span class="price">
                            price : {{$item->price}}$
                    </span>
                @endif
                <div class="details">
                    <span>details : </span>
                    {{$item->details}}
                </div>
                
            </div>
        </a>
        @if(Auth::user())
            <div class='ad-to-carts'>
                @if(Auth::user()->items()->where('item_id',$item->id)->first())
                    <a href="{{route('item.delete-from-cart',$item->id)}}">delete from cart</a>
                @else
                    <a href="{{route('item.add-to-cart',$item->id)}}">add to cart</a>
                @endif
            </div>
        @endif
    </div>
    @endforeach
    @else
        <p class='message'> no item found</p>
    @endif

@endsection