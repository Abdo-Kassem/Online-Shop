@extends('admin.layouts.app')
@section('content')
<header >
    <h3>subcategory setting</h3>
</header>
<div class='body'>
<form method='post' action="{{route('subcategory.update')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">sub-category name </label>
            <input type="text"  id="name" name='subcategoryName' placeholder="sub-category name" value="{{$subcategory->name}}">
            <input type='hidden' value="{{$subcategory->id}}" name='subcategoryID'>
            @error('subcategoryName')
                <span style='color:brown' >{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="categoryName">category name </label>
            <select name="categoryID" id="categoryName" >
                @foreach($categories as $category)
                    <option value="{{$category->id}}" <?php if($subcategory->categoryName==$category->name) echo('selected')?>> {{$category->name}}</option>
                @endforeach
            </select>
            @error('categoryName')
                <span style='color:brown' >{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="image">sub-category image </label>
            <input type='file' name="image" id="image" >
            <img src='{{URL::asset("site/images/subcategories_image/{$subcategory->image}")}}' width='100px'height='100px'>
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
    @elseif(session()->has('success'))
    <div id='message'class='success-message'>
        <i class="fas fa-check-circle"></i>
        {{session()->get('success')}}
    </div>
    @endif
</div>
<script>
    document.getElementById('subcategory').classList.add('active');
    setTimeout(function(){
        document.getElementById('message').style.display = 'none';
    },5000)
</script>
@endsection