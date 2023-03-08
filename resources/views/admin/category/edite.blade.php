@extends('admin.layouts.app')
@section('content')
<header >
    <h3>category setting</h3>
</header>
<div class='body'>
    <form method='post' action="{{route('category.update')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">name</label>
            <input type="text"  id="name" name='categoryName' placeholder="category name" value="{{$category->name}}">
            @error('categoryName')
                <span style='color:brown' >{{$message}}</span>
            @enderror
            <input type='hidden' value="{{$category->id}}" name='categoryID'>
        </div>

        <div class="form-group">
            <label for="seller">service cost in every month </label>
            <input type="number"  id="seller" name='categorySellingCost' 
                placeholder="service cost in every month by EGP" value="{{$category->selling_cost}}">
            @error('categorySellingCost')
                <span style='color:brown' >{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="image">category image </label>
            <input type='file' name="image" id="image" >
            <img src='{{URL::asset("site/images/categories_images/{$category->image}")}}' height='100px'>
            @error('image')
                <span style='color:brown' >{{$message}}</span>
            @enderror
        </div>

        <button type="submit" class="submite">Submit</button>
    </form>
    @if(session()->has('fail'))
        <div id='message'class='fail-message'>
            <i class="fas fa-times-circle"></i>
            {{session()->get('fail')}}
        </div>
    @endif
</div>
<script>
    setInterval(function(){
        document.getElementById('message').style.display = 'none';
    },4000)
</script>
@endsection