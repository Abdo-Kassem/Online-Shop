@extends('site.layout.app')
@section('style')
    <link rel="stylesheet" href="{{URL::asset('site/css/userAcount.css')}}">
    <link rel="stylesheet" href="{{URL::asset('site/css/showItem.css')}}">
@endsection
@section('content')
    <!-- display user acount information-->
    <section class='acount-details'>
        <table class='description'>
            <tr>
                <th  class='main_header'>
                    <span class='change'>acount details</span>
                </th>
                <th><a href="{{route('user.edite')}}">edite</a></th>
            </tr>
            <tr>
                <th>name</th>
                <td>{{$user->name}}</td>
                
            </tr>
            <tr>
                <th>email</th>
                <td>{{$user->email}}</td>
            </tr>
            <tr>
                <th>address</th>
                    @if($user->address == null)
                       <td> no address exist</td>
                    @else
                       <td> {{$user->address}}</td>
                    @endif
            </tr>
        </table>
    </section>
    <section class='acount-details'>
        <table class='description'>

            <tr>
                <th colspan="3" class='main_header'>
                    <span class='change'>orders details</span>
                </th>
                
            </tr>
            @foreach($orders as $order)
            <tr>
                <th>order {{$order->id}}</th>
                <td>{{$order->price}} EGP</td>
                <td><?php if($order->state) echo'send'; else echo 'not send';?></td>
            </tr>
            @endforeach
        </table>
    </section>
@endsection
@section('showitem')
    <script>
        var item = document.getElementById('successOrFail');
        if(item){
            setTimeout(function(){
                item.style.setProperty('display','none');
            },3000);
        }
    
    </script>
@endsection