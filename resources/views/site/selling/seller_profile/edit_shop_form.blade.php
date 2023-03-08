@extends('site.selling.seller_profile.profile_app')
@section('style')
<link rel='stylesheet' href="{{URL::asset('site\css\formStyle.css')}}">
@endsection
@section('sub-content')
<div class='container'>
        <header class='header'>
            <h3>edit shop</h3>
        </header>
        <div class='body'>
        @if(session()->has('fail'))
            <div id='message'class='fail-message'>
                <i class="fas fa-times-circle"></i>
                {{session()->get('fail')}}
            </div>
        @endif
        <form method='post' action="{{route('shop.update',$shop->id)}}" enctype="multipart/form-data" name='create'>
                @csrf
                <div class="form-group">
                    <label for="name"> shop name </label>
                    <input type="text"  id="name" name='shopName' placeholder="shop name" value="{{$shop->name}}">
                    @error('shopName')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="address"> shop\company address </label>
                    <input type="text"  id="address" name='shopAddress' placeholder="like this assiut,manflout 25 mohamed street"
                        value="{{$shop->address}}"> 
                    @error('shopAddress')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="post-number"> post number </label>
                    <input type="text"  id="post-number" name='postNumber' placeholder="post number" 
                        value="{{$shop->post_number}}" >
                    @error('postNumber')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="city"> city </label>
                    <select id='city' name='city'>
                    @foreach($city as $cit)
                        <option value="{{$cit}}" <?php if($shop->city===$cit) echo('selected');?>>{{$cit}}</option>
                    @endforeach
                    </select>
                    @error('city')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="product_type"> product type </label>
                    <select id='product_type' name='productType'>
                    @foreach($catgories as $category)
                        <option value="{{$category->id}}" <?php if($shop->category_name===$category->name) echo('selected');?>>
                            {{$category->name}}
                        </option>
                    @endforeach
                    </select>
                    @error('productType')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">The email of the sender</label>
                    <input type="email"  id="email" name='email' placeholder="seder email" 
                        value="{{$shop->sended_person_email}}">
                    @error('email')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <button type="submit" class="submite">save</button>
            </form>
        </div>
</div>
<script>
    
    setTimeout(function(){
        document.getElementById('message').style.display = 'none';
    },5000)
    var elemWillActive = document.getElementById('create-new-shop');
    elemWillActive.classList.add('active');
    elemWillActive.style.pointerEvents = 'none';
</script>
@endsection