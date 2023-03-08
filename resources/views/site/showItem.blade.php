@extends('site.layout.app')
@section('style')
    <link rel="stylesheet" href="{{URL::asset('site/css/showItem.css')}}">
@endsection
@section('content')
    <section class="item">
        
        @if(session()->has('success'))
        <div class='message' id='successOrFail' >
            {{session('success')}}
        </div>  
        @elseif(session()->has('fail'))  
            <div class='message' id='successOrFail' >
                {{session('fail')}}
            </div>  
        @endif
        <div class="header">
            <h4>{{$item->name}}</h4>
        </div>
        <div class="content">
                <img src="{{URL::asset('site/images/categories/'.$item->namespace.'/'.$item->image)}}" >
                <div class="description">
                    @if($item->discount != null)
                        <div class="price">
                            <div class='new-price'>
                                price : 
                                <span>{{$item->newPrice}} $ </span>
                            </div>
                            <div class='old-price'>
                                old price : 
                                <span>{{$item->price}} $</span>
                            </div>
                        </div>
                        <div class="discount">
                            discount :  -{{$item->discount->discount_value}}%
                        </div>
                    @else
                        <div class="price">
                            <div class='old-price'>
                                 price : 
                                <span>{{$item->price}} $</span>
                            </div>
                        </div>
                    @endif
                    <div class="details">
                        <span class='head'>details : </span>
                        {{$item->details}}
                    </div>
                    <div  class='details'>
                        <span class='head'>items count : </span>
                        <span id='item-number'>{{$item->item_number}}</span>
                    </div>
                    @if(Auth::user())
                    <div class='ad-to-carts'>
                        <?php
                            $userID = Illuminate\Support\Facades\Auth::user()->id;
                            $itemsCount = $item->users()->where('user_id',$userID)->select('item_count')
                                ->first();
                        ?>
                        @if($itemsCount !== null && $itemsCount->item_count === 1)
                            <a id='delete' class='delete' href="{{route('item.delete-from-cart',$item->id)}}">delete from cart</a>
                            <a id='plus' class='plus' href="{{route('item.increase-cart',$item->id)}}">
                                <i class="fas fa-plus-circle"></i> plus
                            </a>
                        @elseif($itemsCount === null)
                            <a href="{{route('item.add-to-cart',$item->id)}}">add to cart</a>
                        @elseif($itemsCount !== null && $itemsCount->item_count > 1 )
                            <a id='minus' class='minus' href="{{route('item.decrease-cart',$item->id)}}">
                                <i class="fas fa-minus-circle"></i> minus
                            </a>
                            
                            <a id='plus'class='plus' href="{{route('item.increase-cart',$item->id)}}">
                                <i class="fas fa-plus-circle"></i> plus
                            </a>
                            
                            <a id='delete' class='delete' href="{{route('item.delete-from-cart',$item->id)}}">delete from cart</a>
                        @endif
                    </div>
                    @endif
                </div>
        </div>
    </section>
@endsection
@section('showitem')
    
    <script>
        var successOrFail = document.getElementById('successOrFail');
        if(successOrFail){
            setTimeout (function(){
                successOrFail.style.display = 'none';
            },3000);
        }    
    </script>
@endsection
