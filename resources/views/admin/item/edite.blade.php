@extends('admin.layouts.app')
@section('content')
<header >
    <h3>subcategory setting</h3>
</header>
<div class='body'>
@if(session()->has('fail'))
    <div id='message'class='fail-message'>
        <i class="fas fa-times-circle"></i>
        {{session()->get('fail')}}
    </div>
@elseif(session()->has('success'))
<div id='message'class='success-message'>
    <i class="fas fa-check-circle"></i>
    {{session()->get('success')}}
</div>
@endif
<form method='post' action="{{route('item.save')}}" enctype="multipart/form-data" name='show-item'>
        @csrf
        <div class="form-group">
            <label for="name">item name </label>
            <input type="text"  id="name" name='itemName' placeholder="item name" value="{{$item->name}}">
            <input type='hidden' value="{{$item->id}}" name='itemID'>
            <input type='hidden' value="{{$item->namespace}}" name='categoryName'>
            @error('itemName')
                <span style='color:brown' >{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <div class='image'>
                <div class='file'>
                    <label for="image">image </label>
                    <input type="file"  id="image" name='image' placeholder="image" required>
                </div>
                <img id='image-show' src="{{URL::asset('site/images/categories/'.$item->namespace.'/'.$item->image)}}">
                @error('image')
                    <span style='color:brown' >{{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="details">details </label>
            <textarea  id="details" name='details' placeholder="item descreption">{{$item->details}}</textarea>
            @error('details')
                <span style='color:brown' >{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="price">price EGP</label>
            <input type="number"  id="price" name='price' placeholder="item price" value='{{$item->price}}'>
            @error('price')
                <span style='color:brown' >{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="discount">discount %</label>
            <input type="text"  id="discount" name='discount' placeholder="item discount" 
                value="<?php if($item->discount != null) echo $item->discount->discount_value?>">
            @error('discount')
                <span style='color:brown' >{{$message}}</span>
            @enderror
        </div>
        <div id='time' >
            <div class="form-group">
                <label for="start-time">(if set)discount start time</label>
                <input type="date"  id="start-time" name='time_start' placeholder="discount start time" 
                    value="<?php if(isset($item->discount)) echo $item->discount->time_start;?>">
                @error('start_time')
                    <span id='start-time' style='color:brown' >{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="end-time">(if set)discount end time</label>
                <input type="date"  id="end-time" name='time_end' placeholder="discount end time"
                    value="<?php if($item->discount !== null) echo $item->discount->time_end;?>">
                @error('end_time')
                    <span style='color:brown' >{{$message}}</span>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <div class='shipping'>
                <input id='free-shipping' type='radio' name='shipping' value='1'  <?php if($item->free_shipping == 1)echo 'checked'?>>
                <label for="free-shipping">free shipping </label>
            </div>
            <div class='shipping'>
                <input id='paid-shipping' type='radio' name='shipping' value='0'  <?php if($item->free_shipping == 0)echo 'checked'?>>
                <label for="paid-shipping">paid shipping </label>
            </div>
            @error('shipping')
                <span style='color:brown' >{{$message}}</span>
            @enderror
        </div>
        <div class='group' id='shipping_cost' style="display:none">
            <label for="shipping-cost">shipping cost by EGP</label>
            <input type='number' name='shipping_cost' id='shipping-cost-input' min='1' 
                value="{{$item->shipping_cost}}">
        </div>
        <button type="submit" class="submite">Submit</button>
    </form>
</div>
<script>
    document.getElementById('item').classList.add('active');
    setTimeout(function(){
        document.getElementById('message').style.display = 'none';
    },5000)

    function displayShippingCost(){
        var paidShipping = document.getElementById('paid-shipping');
        var freeShipping = document.getElementById('free-shipping');
        var shippingCost = document.getElementById('shipping_cost');
        if(paidShipping.checked){
            shippingCost.style.display = 'block';
        }
        paidShipping.addEventListener('change',function(){
            shippingCost.style.display = 'block';
        });
        freeShipping.addEventListener('change',function(){
            shippingCost.style.display = 'none';
        });
    }
    displayShippingCost();
</script>
@endsection