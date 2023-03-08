@extends('admin.layouts.app')
@section('content')
    <header >
        <h3>order setting</h3>
    </header>
    <div class='body'>
        @if(session()->has('success'))
            <div id='message' class='success-message'>
                <i class="fas fa-check-circle"></i>
                {{session()->get('success')}}
            </div>
        @endif
        <table class='table'>
            <tr>
                <th>#</th>
                <th>price</th>
                <th>owner</th>
                <th>created at</th>
                <th>send time</th>
                <th>state</th>
                <th >operation</th>
            </tr>
            <?php $count=1;?>
            @foreach($orders as $order)
            <tr>
                <td>{{$count}}</td>
                <td>{{$order->price}} EGP</td>
                <td>{{$order->userName}}</td>
                <td>{{$order->created_at}}</td>
                <td>{{$order->send_time}}</td>
                <td><?php if($order->state==0) echo'not send';else echo'send';?></td>
                <td class='operation'>
                    <a class='show' href="{{route('order.show',$order->id)}}" title='show orders'><i class="fas fa-eye"></i></a> 
                    <a class='update' href="{{route('order.get.update',$order->id)}}" title='update orders'><i class="far fa-edit"></i></a>
                </td>
            </tr>
            <?php $count++;?>
            @endforeach
        </table>
        <section class='pagination'>
            <p>{{$orders->currentPage()}} of {{$orders->lastPage()}} pages</p>
            <nav class='pagination-links'>
                <ul>
                    <li>
                        @if($orders->currentPage()>1)
                            <a href="{{$orders->url($orders->currentPage()-1)}}">prev</a>
                        @else
                            <a class='disabled' href="">prev</a>
                        @endif
                    </li>
                    <li>
                        @if($orders->currentPage() < $orders->lastPage())
                            <a href="{{$orders->url($orders->currentPage()+1)}}">next</a>
                        @else
                            <a class='disabled' href="">next</a>
                        @endif
                    </li>
                </ul>
            </nav>
        </section>
    </div>
    <script>
        document.getElementById('order').classList.add('active');

        setInterval(function(){
            document.getElementById('message').style.display = 'none';
        },4000)
    </script>
@endsection