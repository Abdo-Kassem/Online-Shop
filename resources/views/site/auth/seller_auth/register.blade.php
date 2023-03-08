@extends('site.selling.app')
@section('style')
<link rel='stylesheet' href="{{URL::asset('site\css\formStyle.css')}}">
@endsection
@section('content')
    <div class='container'>
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
        <form method='post' action="{{route('seller.register')}}" enctype="multipart/form-data" name='create'>
                @csrf
                <div class="form-group">
                    <label for="name"> your name </label>
                    <input type="text"  id="name" name='name' placeholder="seller name first & lastName" >
                    @error('name')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="ID">national ID </label>
                    <input type="text"  id="ID" name='id' placeholder="national ID" >
                    @error('id')
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
                    <label for="phone1">phone</label>
                    <input type="tel"  id="phone1" name='phone1' placeholder="seller phone1">
                    @error('phone1')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone2">phone</label>
                    <input type="tel"  id="phon2" name='phone2' placeholder="seller phone2">
                    @error('phone2')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email1">email</label>
                    <input type="email"  id="email1" name='email' placeholder="seller email">
                    @error('email')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email2">reset email</label>
                    <input type="email"  id="email2" name='reset_email' placeholder="seller reset email">
                    @error('reset_email')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <div >
                        <input id='individual' type='radio' name='acount_type' value='0'>
                        <label for="individual">individual </label>
                    </div>
                    <div>
                        <input id='company' type='radio' name='acount_type' value='1' checked>
                        <label for="company">company </label>
                    </div>
                
                    @error('acount_type')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">password</label>
                    <input type="password"  id="password" name='password' 
                    title="must start cabital leter and end by cabitale leter and contain at least 6 digits ">
                    @error('password')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">reset password</label>
                    <input type="password"  id="password" name='reset_password'
                    title="must start cabital leter and end by cabitale leter and contain at least 6 digits ">
                    @error('reset_password')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                
                <button type="submit" class="submite">continue</button>
            </form>
        </div>
    </div>
@endsection