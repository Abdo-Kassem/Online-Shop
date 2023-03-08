@extends('site.layout.app')
@section('style')
    <link rel="stylesheet" href="{{URL::asset('site/css/order_page.css')}}">
@endsection
@section('content')
    <section class="items-details">
    @if($orders->count()>0)
        @foreach($orders as $order)
            <div class='header' id='order'>
                order{{$order->id}} status(<?php if($order->state) echo'done';else echo'not send'; ?>)
                <div class="total_price">{{$order->price}} EGP</div>
                @if($order->state !== 0)
                <a class='cancel'href="{{route('order.cancel',$order->id)}}">cancel</a>
                @endif
            </div>
            @foreach($order->items as $item)
                <section class="item">
                    @if(session()->has('successOrFail'))
                    <div class='message' id='successOrFail' >
                        {{session('successOrFail')}}
                    </div>    
                    @endif
                    <div class="content">
                        <img src="{{URL::asset('site/images/categories/'.$item->namespace.'/'.$item->image)}}" >
                        <div class="description">
                            <div class='details name'>
                                name : {{$item->name}}
                            </div>
                            <div class="price">
                                @if(isset($item->discount))
                                <div class='new-price'>
                                    price : 
                                    <span>{{$item->newPrice}} EGP</span>
                                </div>
                                
                                <div class='old-price'>
                                    old price : 
                                    <span>{{$item->price}} EGP</span>
                                </div>
                                @else

                                    <div class='old-price'>
                                        price : 
                                        <span>{{$item->price}} EGP</span>
                                    </div>

                                @endif
                            </div>
                            @if(isset($item->discount))
                            <div class="discount">
                                discount :  {{$item->discount->discount_value}}%
                            </div>
                            @endif
                            <div class="details">
                                <span>details : </span>
                                {{$item->details}}
                            </div>
                            <div class="details">
                                item count : {{$item->pivot->item_count}}
                            </div>
                            @if($order->state === 1)
                            <div class="details">
                                <form name='feedback' class='form' >
                                    @csrf
                                    <label for='check'>item feedback </label>
                                    <input value="<?php if($item->feedbacks !== null) echo $item->feedback->feedback;?>" 
                                        type="number" name='feedbackNumber' min='1' max='5' id='check'>
                                    <input type='hidden' value="{{$item->id}}" name='itemID'>
                                    <input class='submite'type='submit' value='send' id="submit{{$item->id}}"
                                        onclick="runAjax(this.form)">
                                    <i class="far fa-star star"></i>
                                </form>
                            </div>
                            @endif
                        </div>
                    </div>
                </section>
            @endforeach
            
        @endforeach
    @else
        <div class='no-order'>
            no order exist
            <a href="{{route('create.order')}}" class='create-order'> create order</a>
        </div>
    @endif
    </section>
@endsection
@section('showitem')
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
            integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous">
        </script>
    <script>
        var item = document.getElementById('successOrFail');
        if(item){
            setTimeout(function(){
                item.style.setProperty('display','none');
            },3000);
        }
        ''

        
        function runAjax(form){
            event.preventDefault();
            
            event.preventDefault();
            var formData = new FormData(form);
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type : 'POST',
                url : "{{route('customer.addfeedback')}}",
                data : formData,
                enctype : "multipart/form-data",
                cache: false,
                processData:false,
                contentType:false,
                success : function(res){
                   window.alert(res.message);
                },error :function(reject){
                
                    var response = JSON.parse(reject.responseText); //return object of message object and errors object
                    var errors = response.errors;  /*return errors object and this object contain objects of array 
                                                     like email:{[]}*/
                    $.each(errors,function(key,value){
                        var element = key+' '+value;
                        console.log(element);
                    
                    });
                }
            });
        }
    </script>
@endsection