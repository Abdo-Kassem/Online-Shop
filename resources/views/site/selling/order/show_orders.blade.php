@extends('site.selling.home_common_links')

@section('page-right-side')
<div class='right-side right-side-order'>
    <header class='header'>
        <h2>
            orders show
        </h2>
    </header>
    <table class='table'>
        <tr>
            <th>order number</th>
            <th>price</th>
            <th>custommer</th>
            <th>created at</th>
            <th>send time</th>
            <th>status</th>
            <th >operation</th>
        </tr>
        @foreach($orders as $order)
        <tr>
            <td>{{$order->id}}</td>
            <td>{{$order->price}} EGP</td>
            <td>{{$order->userName}}</td>
            <td>{{$order->created_at}}</td>
            <td>{{$order->send_time}}</td>
            @if($order->state==1)
                <td>send</td>
            @else
                <td>not send</td>
            @endif
            <td class='operation'>
                <a class='show' href="{{route('seller.order.show',$order->id)}}" title='show orders'><i class="fas fa-eye"></i></a> 
            </td>
        </tr>
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
</div>
</section>
<script>
    var elemWillActive = document.getElementById('show-orders');
    elemWillActive.classList.add('active');
    elemWillActive.setAttribute('style','color:rgba(0,0,0,0.6) !important;font-weight:bold');
    elemWillActive.style.pointerEvents = 'none';
    elemWillActive.style.cursor = 'default';
</script>
@endsection