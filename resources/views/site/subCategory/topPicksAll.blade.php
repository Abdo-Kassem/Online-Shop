@extends('site.layout.app')
@section('style')
<link rel='stylesheet' href="{{URL::asset('site/css/category_page.css')}}">
@endsection
@section('content')

    <section class="sub-category-hot-deals">
        <div class="header" style="display:block">
            <h3 style='text-align:center'>{{$subCategoryName}} top-picks!</h3>
        </div>
        <div class="content">
        @if(count($topPicksItems)>0)
            @foreach($topPicksItems as $item)
            <a href="{{route('item.details',$item->id)}}">
                <img src="{{URL::asset('site/images/categories/'.$namespace.'/'.$item->image)}}" >
                <div class="description">
                    <div class="name">
                        {{$item->name}}
                    </div>
                    @if(isset($item->discount))
                        <div class="price">
                            <span class="new-price">
                                price : {{$item->newPrice}}$
                            </span>
                            <del class="old-price">
                                {{$item->price}}$
                            </del>
                        </div>
                        <div class="discount">
                            -{{$item->discount->discount_value}}%
                        </div>
                    @else
                        <span class="price">
                                price : {{$item->price}}$
                        </span>
                    @endif
                </div>
            </a>
            @endforeach
        @else
            <p class='message'> no item in this department</p>
        @endif
        </div>
    </section>
@endsection