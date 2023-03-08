@extends('admin.layouts.app')
@section('content')
<header >
    <h3>item setting</h3>
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
<form method='post' action="{{route('item.create')}}" enctype="multipart/form-data" name='create'>
        @csrf
        <div class="form-group">
            <label for="name">item name </label>
            <input type="text"  id="name" name='itemName' placeholder="item name" >
            @error('itemName')
                <span style='color:brown' >{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <div class='image'>
                <div class='file'>
                    <label for="image">image </label>
                    <input type="file"  id="image" name='image' placeholder="image">
                    @error('image')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
            </div>
        </div>
        <div class="form-group">
            <label for="details">details </label>
            <textarea  id="details" name='details' placeholder="item descreption"></textarea>
            @error('details')
                <span style='color:brown' >{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="price">price EGP</label>
            <input type="number"  id="price" name='price' placeholder="item price">
            @error('price')
                <span style='color:brown' >{{$message}}</span>
            @enderror
        </div>
        <div class='form-group'>
            <select name='subcategory'>
            @foreach($categoriesAndSubcategories as $category)
                @foreach($category->supCategories as $subcategory)
                <option value="{{$category->id.' '.$subcategory->id}}">{{$category->name.'/'.$subcategory->name}}</option>
                @endforeach
            @endforeach
            </select>
        </div>
        <div class="form-group">
            <div class='shipping'>
                <input id='free-shipping' type='radio' name='shipping' value='1'>
                <label for="free-shipping">free shipping </label>
            </div>
            <div class='shipping'>
                <input id='paid-shipping' type='radio' name='shipping' value='0' checked>
                <label for="paid-shipping">paid shipping </label>
            </div>
           
            @error('shipping')
                <span style='color:brown' >{{$message}}</span>
            @enderror
        </div>
        <div class='group' id='shipping_cost' style="display:none">
            <label for="shipping-cost">shipping cost by EGP</label>
            <input type='number' name='shipping_cost' id='shipping-cost-input' min='1' value='1'>
        </div>

        <div class='group'>
            <label for="sellerID">seller ID</label>
            <input type='text' name='sellerID' id='sellerID' placeholder="seller personal ID">
            @error('sellerID')
                <span style='color:brown' >{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="discount">discount %</label>
            <input type="number"  id="discount" name='discount' placeholder="item discount" value=''>
            @error('discount')
                <span style='color:brown' >{{$message}}</span>
            @enderror
        </div>
        <div id='time'>
            <div class="form-group">
                <label for="start-time">discount start time</label>
                <input type="datetime-local"  id="start-time" name='start_time' placeholder="discount start time">
                @error('start_time')
                    <span style='color:brown' >{{$message}}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="end-time">discount start time</label>
                <input type="datetime-local"  id="end-time" name='end_time' placeholder="discount end time">
                @error('end_time')
                    <span style='color:brown' >{{$message}}</span>
                @enderror
            </div>
        </div>
        <button type="submit" class="submite">Submit</button>
    </form>
</div>
<script>
    document.getElementById('item').classList.add('active');
    setTimeout(function(){
        document.getElementById('message').style.display = 'none';
    },5000)
    var discount = document.forms['create']['discount']    

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