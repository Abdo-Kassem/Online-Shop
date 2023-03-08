@extends('site.selling.app')
@section('style')
<link rel='stylesheet' href="{{URL::asset('site\css\formStyle.css')}}">
@endsection
@section('content')
    <div class='container'>
        <header >
            <h3>create shop</h3>
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
        <form method='post' action="{{route('seller.create.shop')}}" enctype="multipart/form-data" name='create'>
                @csrf
                <div class="form-group">
                    <label for="name"> shop name </label>
                    <input type="text"  id="name" name='name' placeholder="shop name" >
                    @error('name')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address"> shop\company address </label>
                    <input type="text"  id="address" name='address' placeholder="like this assiut,manflout 25 mohamed street" >
                    @error('address')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="post-number"> post number </label>
                    <input type="text"  id="post-number" name='post_number' placeholder="post number" >
                    @error('post_number')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="city"> city </label>
                    <select id='city' name='city'>
                    @foreach($city as $cit)
                        <option value="{{$cit}}">{{$cit}}</option>
                    @endforeach
                    </select>
                    @error('city')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="product_type"> product type </label>
                    <select id='product_type' name='category_id'>
                    @foreach($catgories as $category)
                        <option value={{$category->id}}>{{$category->name}}</option>
                    @endforeach
                    </select>
                    @error('category_name')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">The email of the sender</label>
                    <input type="email"  id="email" name='sended_person_email' placeholder="sender email">
                    @error('email')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <button type="submit" class="submite">continue</button>
            </form>
        </div>
    </div>
@endsection