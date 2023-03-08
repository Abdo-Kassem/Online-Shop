@extends('admin.layouts.app')
@section('style')
<link rel='stylesheet' href="{{URL::asset('site\css\formStyle.css')}}">
@endsection
@section('content')
    <header >
        <h3>order setting</h3>
    </header>
    <div class='body'>
        @if(session()->has('fail'))
            <div id='message'class='fail-message'>
                <i class="fas fa-times-circle"> </i>
                {{session()->get('fail')}}
            </div>
        @endif
        <form method='post' action="{{route('admin.update')}}" enctype="multipart/form-data"  name='edit-seller'>
                @csrf
                <div class="form-group">
                    <label for="name"> admin name </label>
                    <input type="text"  id="name" name='name' placeholder="admin name" 
                        value="{{$admin->name}}">
                    @error('name')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">e-mail</label>
                    <input type="email"  id="email" name='email' placeholder="admin email"
                        value="{{$admin->email}}">
                    @error('email')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                
                <div class="form-group">
                    <label for="old-password">type old password</label>
                    <input type="password"  id="old-password" name='old_password' placeholder="type old password">
                    @error('old_password')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">type new password</label>
                    <input type="password"  id="password" name='new_password' placeholder="type new password">
                    @error('new_password')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <button type="submit" class="submite">update</button>
            </form>
        </div>
    </div>
    <script>
        setTimeout(function(){
            document.getElementById('message').style.display = 'none';
        },5000)
       
    </script>
@endsection