@extends('site.layout.app')
@section('style')
    <link rel="stylesheet" href="{{URL::asset('site/css/cartShow.css')}}">
@endsection
@section('content')
    @if($items->count()>0)
         @if(session()->has('saved_success') )
         <div class='message saved-message' id='saved_state'>
            <i class="fas fa-check-circle"></i>
            <span>{{session('saved_success')}}</span>
         </div>
         @elseif(session('saved_fail'))
         <div class='message saved-message' id='saved_state'>
            <i class="fas fa-times-circle"></i>
            <span>{{session('saved_fail')}}</span>
         </div>
        @endif
        <div class='sub-container'>
            <section class="items-details">
                <div class='header' id='cart'>
                    carts<span>({{$items->count()}})</span>
                </div>
                @if(session()->has('plus-message'))
                <div id='plus-message' class='message'>
                    {{session('plus-message')}}
                </div>
                @endif
                @foreach($items as $item)
                    <section class="item">
                        <div class="content">
                            <div class='image'>
                                <img src="{{URL::asset('site/images/categories/'.$item->namespace.'/'.$item->image)}}" >
                                <div class="details">
                                    {{$item->details}}
                                </div>
                            </div>
                            <div class="description"> 
                                @if($item->discount!=null)
                                    <div class="price">
                                        <div class='new-price'>
                                            price : 
                                            <span>{{$item->newPrice}} $ </span>
                                        </div>
                                        <div class='old-price'>
                                            old price : 
                                            <del>{{$item->price}} $</del>
                                        </div>
                                    </div>
                                    <div class="discount">
                                        discount :  -{{$item->discount->discount_value}}%
                                    </div>
                                @else
                                     <div class="price">
                                        <div class='old-price'>
                                             price : 
                                            <del>{{$item->price}} $</del>
                                        </div>
                                    </div>
                                @endif
                                <div class='item-count' style='text-align:center'>
                                    number of item : 
                                    <span>{{$item->item_count}}</span>
                                </div>
                                @if(Auth::user())
                                <div class='item-operations'>
                                    <?php
                                        $userID = Illuminate\Support\Facades\Auth::user()->id;
                                        $itemsCount = $item->users()->where('user_id',$userID)->select('item_count')
                                            ->first();
                                        $itemNumber = $item->item_number;
                                    ?>
                                    @if($itemsCount !== null && $itemsCount->item_count === 1 && $itemNumber > $itemsCount->item_count)
                                        <div class='button' style="width:100%">
                                            <a id='plus' class='plus' href="{{route('item.increase-cart',$item->id)}}">
                                                <i class="fas fa-plus-circle"></i> plus
                                            </a>
                                        </div>
                                    @elseif($itemsCount === null && $itemNumber > 0)
                                        <div class='button'>
                                            <a href="{{route('item.add-to-cart',$item->id)}}">add to cart</a>
                                        </div>
                                    @elseif($itemsCount !== null && $itemsCount->item_count > 1)
                                        <div class='button'>
                                            <a id='minus' class='minus' href="{{route('item.decrease-cart',$item->id)}}">
                                                <i class="fas fa-minus-circle"></i> minus
                                            </a>
                                        </div>
                                        @if($itemNumber > $itemsCount->item_count)
                                        <div class='button'>
                                            <a id='plus'class='plus' href="{{route('item.increase-cart',$item->id)}}">
                                                <i class="fas fa-plus-circle"></i> plus
                                            </a>
                                        </div>
                                        @endif
                                    @endif
                                </div>
                                @endif
                                <div class='item-operations'>
                                    <div class='button delete' title='remove from cart list' id='delete'>
                                        <a href="{{route('item.delete-from-cart',$item->id)}}">remove</a>
                                    </div>
                                    <div class='save-item button' title='add to saved item list' id='save'>
                                        <a href="{{route('item.save.toList',$item->id)}}" >
                                            save
                                        </a>
                                    </div>
                                </div>  
                            </div>
                        </div>
                    </section>
                @endforeach
            </section>
            <div class='total-paied'>
                <h3 class='summary'>summary</h3>
                <div class='price'>
                    <span>totalPrice : </span>
                    <span>{{$totalPrice}}$</span>
                </div>
                @if(session()->has('success'))
                    <div class='message' id='message'>
                        <i class="fas fa-check-circle"></i>
                        <span>{{session('success')}}</span>
                    </div>
                @elseif(session('fail'))
                    <div class='message' id='message'>
                        <i class="fas fa-times-circle"></i>
                        <span>{{session('fail')}}</span>
                    </div>
                @endif
                    <a href='{{route("create.order")}}' class='create-order' id='createOrder'
                    style='display:none' title="order will divid into collection of orders depend on seller">
                        create orders</a>
                
            </div>
        </div>
    @else
        <div class='message'>
            no items exist
        </div>
    @endif
@endsection
@section('showitem')
    <script>
        //create order
        function createOrderMessage(){
            var item = document.getElementById('message');
            var plus_message = document.getElementById('plus-message');
            var link = document.getElementById('createOrder');

            if(item){
                setTimeout(function(){
                    item.style.setProperty('display','none');
                    link.style.setProperty('display','block');
                },3000);    
            }else
                link.style.setProperty('display','block');

            setInterval(function(){
                plus_message.style.display = 'none';
            },4000);
        }
        
        //end create order

        //save to save items and delete from cart
        function saveItemMessage(){
            var saveState = document.getElementById('saved_state');
            if(saveState){
                setTimeout(function(){
                    saveState.style.setProperty('display','none');
                },3000);
            }
        }
        
        createOrderMessage();
        saveItemMessage();
    </script>
@endsection