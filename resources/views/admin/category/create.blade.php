@extends('admin.layouts.app')
@section('content')
<header >
    <h3>create category</h3>
</header>
<div class='body'>
    <form method='post' action="{{route('category.save')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">name </label>
            <input type="text"  id="name" name='categoryName' placeholder="category name">
            @error('categoryName')
                <span style='color:brown' >{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="seller">service cost in every month </label>
            <input type="number"  id="seller" name='categorySellingCost' placeholder="service cost in every month by EGP">
            @error('categorySellingCost')
                <span style='color:brown' >{{$message}}</span>
            @enderror
        </div>
        <div class='form-group'>
            <label for='image'>catgory image</label>
            <input type='file' name='image' id='image' required>
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
    setInterval(function(){
        document.getElementById('message').style.display = 'none';
    },4000)
</script>
@endsection