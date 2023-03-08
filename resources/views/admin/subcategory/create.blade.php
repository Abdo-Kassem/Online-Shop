@extends('admin.layouts.app')
@section('content')
<header >
    <h3>create subcategory</h3>
</header>
<div class='body'>
    
    <form method='post' action="{{route('subcategory.save')}}" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="name">sub-category name </label>
            <input type="text"  id="name" name='subcategoryName' placeholder="sub-category name">
            @error('subcategoryName')
                <span style='color:brown' >{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
            <label for="categoryName">category name </label>
            <select name="categoryID" id="categoryName">
                @foreach($categories as $category)
                    <option value="{{$category->id}}" >{{$category->name}}</option>
                @endforeach
            </select>
            @error('categoryName')
                <span style='color:brown' >{{$message}}</span>
            @enderror
        </div>

        <div class='form-group'>
            <label for='image'>sub-catgory image</label>
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
    document.getElementById('subcategory').classList.add('active');
</script>
@endsection