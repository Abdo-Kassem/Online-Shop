@extends('site.selling.home_common_links')
@section('style')
    <link rel='stylesheet' href="{{URL::asset('site/css/formStyle.css')}}">
@endsection
@section('page-right-side')
<div class='right-side right-side-order'>
    <header class='header'>
        <h3>product edit</h3>
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
    <form method='post' action="{{route('ptoduct.update')}}" enctype="multipart/form-data" name='create'>
            @csrf
            <div class="form-group">
                <label for="name">product name </label>
                <input type="text"  id="name" name='itemName' placeholder="product name" value="{{$product->name}}">
                @error('itemName')
                    <span style='color:brown' >{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <div class='image'>
                    <div class='file'>
                        <label for="image">image </label>
                        <input type="file"  id="image" name='image' placeholder="image" required>
                        @error('image')
                            <span style='color:brown' >{{$message}}</span>
                        @enderror
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label for="details">details </label>
                <textarea  id="details" name='details' placeholder="item descreption" >
                    {{$product->details}}
                </textarea>
                @error('details')
                    <span style='color:brown' >{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="price">price EGP</label>
                <input type="number"  id="price" name='price' placeholder="item price" value="{{$product->price}}">
                @error('price')
                    <span style='color:brown' >{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="discount">discount %</label>
                <input type="number"  id="discount" name='discount' placeholder="item discount" value='<?php
                 if(!is_null($product->discount))echo $product->discount->discount_value;?>'>
                @error('discount')
                    <span style='color:brown' >{{$message}}</span>
                @enderror
            </div>
            <div id='time' >
                <div class="form-group">
                    <label for="start-time">discount start time</label>
                    <input type="date"  id="start-time" name='time_start' placeholder="discount start time"
                    value="<?php if(!is_null($product->discount)) echo $product->discount->time_start;?>">
                    @error('time_start')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="end-time">discount end time</label>
                    <input type="date"  id="end-time" name='time_end' placeholder="discount end time"
                        value="<?php if($product->discount !==null) echo $product->discount->time_end;?>">
                    @error('time_end')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
            </div>
            <input type='hidden' name='itemID' value="{{$product->id}}">
            <input type='hidden' value="{{$product->namespace}}" name='categoryName'>
            <button type="submit" class="submite">Submit</button>
        </form>
    </div>
</div>
<script>
    
    setTimeout(function(){
        document.getElementById('message').style.display = 'none';
    },5000)
    var elemWillActive = document.getElementById('show-products');
    elemWillActive.classList.add('active');
    
</script>
@endsection