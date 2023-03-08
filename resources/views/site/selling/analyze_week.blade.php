@extends('site.selling.home_common_links')

@section('page-right-side')
<div class='right-side right-side-order'>
    @if($orders->count() > 0)
        @foreach($orders as $order)
        <header class='header'>
            <h2>
                order <span class='mark'>{{$order->id}}</span> 
                - customer <span class='mark'>{{$order->orderOwner}}</span>
                - price <span class='mark'>{{$order->price}} EGP</span>
            </h3>
        </header>
        <div class='body'>
            <table class='table'>
                <tr>
                    <th>#</th>
                    <th>name</th>
                    <th>details</th>
                    <th>price</th>
                    <th>discount</th>
                    <th>new price</th>
                    <th>item number</th>
                    
                </tr>
                @foreach($order->items as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td>{{$item->name}}</td>
                    <td>{{$item->details}}</td>
                    <td>{{$item->price}} EGP</td>
                    @if($item->discount != null)
                        <td>-{{$item->discount->discount_value}}%</td>
                    @else
                        <td></td>
                    @endif
                    <td>
                        {{$item->newPrice}}
                    </td>
                    <td>
                        {{$item->pivot->item_count}}  
                    </td>
                    
                </tr>
                @endforeach
            </table>  
        </div>
        @endforeach
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
    @else
        <div class='message'> no order exist</div>
    @endif
</div>
<script>
    var elemWillActive = document.getElementById('analyze-week');
    elemWillActive.classList.add('active');
    elemWillActive.setAttribute('style','color:rgba(0,0,0,0.6) !important;font-weight:bold');
    elemWillActive.style.pointerEvents = 'none';
    elemWillActive.style.cursor = 'default';
</script>
@endsection