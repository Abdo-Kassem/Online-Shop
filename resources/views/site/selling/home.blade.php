@extends('site.selling.home_common_links')

@section('page-right-side')
<div class='right-side'>
        <div class='top-content'>
            <div class='selles-summation'>
                <span>selles summation</span>
                <span>{{$totalPrice}}$</span>
            </div>
            <div class='orders-summation'>
                <span>orders summation</span>
                <span>{{$orderCount}}</span>
            </div>
            <div class='products-number'>
                <span>products number</span>
                <span>{{$productsCount}}</span>
            </div>
            <div class='customer-number'>
                <span>customer number</span>
                <span>{{$customerCount}}</span>
            </div>
        </div>
        <div class='bottom-content'>
            <section class='latest-orders'>
                <h3 class='header'>latest <span style="color:black;font-size:22px">2</span> orders</h3>
                <div class='content'>
                    <table>
                        <tr>
                            <th>order number</th>
                            <th>customer</th>
                            <th>order status</th>
                            <th>total price</th>
                            <th>operation</th>
                        </tr>
                        @foreach($lastTwoOrder as $order)
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->userName}}</td>
                            <td>{{$order->state}}</td>
                            <td>{{$order->price}}</td>
                            <td>
                                <a href="{{route('seller.order.show',['orderID'=>$order->id,'sellerID'=>$sellerID])}}">
                                    details
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                    
                </div>
            </section>
            <section class='last-feedback latest-orders'>
                <h3 class='header'>last feedback</h3>
                <div class='content'>
                    <table>
                        <tr>
                            <th>Evaluation</th>
                            <th>product</th>
                            <th>customer</th>
                        </tr>
                        @if(isset($lastFeedback))
                        <tr>
                            <td>{{$lastFeedback->feedback}}</td>
                            <td>{{$lastFeedback->item->name}}</td>
                            <td>{{$lastFeedback->customer}}</td>
                        </tr>
                        @endif
                    </table>
                    
                </div>
            </section>
        </div>
    </div>

@endsection
