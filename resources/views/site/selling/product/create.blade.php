@extends('site.selling.home_common_links')
@section('style')
    <link rel='stylesheet' href="{{URL::asset('site/css/formStyle.css')}}">
@endsection
@section('page-right-side')
<div class='right-side right-side-order'>
    <header >
        <h3>create product</h3>
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
    <form method='post' action="{{route('product.save')}}" enctype="multipart/form-data" name='create'>
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
                <label for='category'>chooce category</label>
                <select name='subcategory' id='category'>
                @foreach($shopAndcategoryAndSubcategories as $shopName=>$category)
                    @foreach($category->supCategories as $subcategory)
                    <option value="{{$category->id.' '.$subcategory->id}}">{{'shop name('.$shopName.') / '.$category->name.' / '.$subcategory->name}}</option>
                    @endforeach
                @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="discount">discount % (optional)</label>
                <input type="number"  id="discount" name='discount' placeholder="item discount" value=''>
                @error('discount')
                    <span style='color:brown' >{{$message}}</span>
                @enderror
            </div>
            <div id='time' >
                <div class="form-group">
                    <label for="start-time">(if set)discount start time</label>
                    <input type="date"  id="start-time" name='start_time' placeholder="discount start time">
                    @error('start_time')
                        <span id='start-time' style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="end-time">(if set)discount end time</label>
                    <input type="date"  id="end-time" name='end_time' placeholder="discount end time">
                    @error('end_time')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
            </div>
            <button type="submit" class="submite">Submit</button>
        </form>
    </div>
</div>
<script>
    
    setTimeout(function(){
        document.getElementById('message').style.display = 'none';
    },5000)
    var elemWillActive = document.getElementById('create-product');
    elemWillActive.classList.add('active');
    elemWillActive.style'.pointerEvents = 'none';
    elemWillActive.style.cursor = 'default';
</script>
@endsection