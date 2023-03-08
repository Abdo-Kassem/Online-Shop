@extends('admin.layouts.app')
@section('content')
<header >
    <h3>order setting</h3>
</header>
<div class='body'>
    <form method='post' action="{{route('order.update')}}">
        @csrf
        <div class="form-group">
            <label for="send_time">send time</label>
            <input type="date"  id="send_time" name='send_time' placeholder="send time" value="{{$order->send_time}}">
            @error('send_time')
                <span >{{$message}}</span>
            @enderror
            <input type='hidden' value="{{$order->id}}" name='orderID'>
        </div>
        <div class="form-group">
            @if($order->state == 0)
                <label for='state'>order state</label>
                <div class="form-group">
                    <input type='radio' name='state' id='state' value='1'>
                    <span class='radio-text'>make send</span>
                </div>
                @error('state')
                    <span >{{$message}}</span>
                @enderror
            @endif
            
        </div>
        <input type='hidden' value="{{$order->id}}" name='orderID'>
        <button type="submit" class="submite">Submit</button>
    </form>
    @if(session()->has('fail'))
        <div id='message'class='fail-message'>
            <i class="fas fa-times-circle"></i>
            {{session()->get('fail')}}
        </div>
    @endif
</div>
@endsection