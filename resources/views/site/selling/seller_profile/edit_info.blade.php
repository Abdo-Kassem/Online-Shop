@extends('site.selling.seller_profile.profile_app')
@section('style')
<link rel='stylesheet' href="{{URL::asset('site\css\formStyle.css')}}">
@endsection
@section('sub-content')
    <div class='container' >
        <header >
            <h3>seller register</h3>
        </header>
        <div class='body'>
        @if(session()->has('fail'))
            <div id='message'class='fail-message'>
                <i class="fas fa-times-circle"></i>
                {{session()->get('fail')}}
            </div>
        @endif
        <form method='post' action="{{route('seller.update')}}" enctype="multipart/form-data"  name='edit-seller'>
                @csrf
                <div class="form-group">
                    <label for="name"> your name </label>
                    <input type="text"  id="name" name='sellerName' placeholder="seller name first & lastName" 
                        value="{{$seller->name}}">
                    @error('sellerName')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="ID">national ID </label>
                    <input type="text"  id="ID" name='id' placeholder="national ID" value="{{$seller->id}}">
                    @error('id')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <div class='image-form'>
                        <div class='file'>
                            <label for="image">image </label>
                            <input type="file"  id="image" name='image' placeholder="image" 
                                imageName = "{{$seller->image}}" onchange="previewFile()">
                            @error('image')
                                <span style='color:brown' >{{$message}}</span>
                            @enderror
                        </div>
                        <div class='display-input-image' >
                            <img src="" alt="seller profile" id='seller-img-show'>
                        </div>
                    </div>
                    
                </div>
        
                <div class="form-group">
                    <label for="email">e-mail</label>
                    <input type="email"  id="email" name='email' placeholder="seller email"
                        value="{{$seller->email}}">
                    @error('email')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <div >
                        <input id='individual' type='radio' name='acountType' 
                             value="0" <?php if($seller->acount_type==0) echo 'checked'; ?>>
                        <label for="individual">individual </label>
                    </div>
                    <div>
                        <input id='company' type='radio' name='acountType' value='1' 
                            <?php if($seller->acount_type==1) echo 'checked'; ?>>
                        <label for="company">company </label>
                    </div>
                
                    @error('acountType')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">type your password</label>
                    <input type="password"  id="password" name='password' placeholder="type password to allow change your data">
                    @error('password')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <button type="submit" class="submite">update</button>
            </form>
        </div>
    </div>
    <script>
        var sellerImage = document.forms['edit-seller'].elements[3].getAttribute('imageName');//start by 1
        console.log(sellerImage)
        var sellerImageShow = document.getElementById('seller-img-show').
            setAttribute('src',"{{URL::asset('site/images/seller')}}"+'/'+sellerImage);
            function previewFile() {
                var sellerImageShow = document.getElementById('seller-img-show');
                var file    = document.querySelector('input[type=file]').files[0];
                var reader  = new FileReader();

                reader.onloadend = function () {
                    sellerImageShow.src = reader.result;//reader.result return details of image
                }

                if (file) {
                    reader.readAsDataURL(file); //read image content when read operation end the onloadend will trigger
                } else {
                    sellerImageShow.src = "";
                }
            }
    </script>
@endsection