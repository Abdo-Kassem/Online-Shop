@extends('site.layout.app')
@section('style')
    <link rel="stylesheet" href="{{URL::asset('site/css/savedItems.css')}}">
@endsection
@section('content')
    @if($savedItems->count()>0)
        <div class='sub-container'>
            <section class="items-details">
                <div class='header' id='cart'>
                    items<span>({{$savedItems->count()}})</span>
                </div>
                @foreach($savedItems as $item)
                    <section class="item">
                        <div class="content">
                            <div class='image'>
                                <img src="{{URL::asset('site/images/categories/'.$item->namespace.'/'.$item->image)}}" >
                                <div class="details">
                                    {{$item->details}}
                                </div>
                            </div>
                            <div class="description"> 
                                <div class="price">
                                    <div class='new-price'>
                                        price : 
                                        <span>{{$item->newPrice}} EGP </span>
                                    </div>
                                    <div class='old-price'>
                                        old price : 
                                        <del>{{$item->price}} EGP</del>
                                    </div>
                                </div>
                                @if($item->discount !== null)
                                <div class="discount">
                                    discount :  {{$item->discount->discount_value}}%
                                </div>
                                @endif
                                <div class='delete'>
                                    <a href="{{route('item.delete-from-savedItems',$item->id)}}">remove</a>
                                </div>
                            </div>
                        </div>
                    </section>
                @endforeach
            </section>
            
        </div>
    @else
        <div class='message'>
            no items exist
        </div>
    @endif
@endsection
@section('showitem')
    <script>
        var item = document.getElementById('message');
        var link = document.getElementById('createOrder');
        if(item){
            setTimeout(function(){
                item.style.setProperty('display','none');
                link.style.setProperty('display','block');
            },3000);    
        }else
            link.style.setProperty('display','block');
    
    </script>
@endsection