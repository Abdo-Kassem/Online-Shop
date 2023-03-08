@extends('admin.layouts.app')

@section('content')
    
    <div class='home-containner'>
        <section class='page-top'>
            <div class='order-number'>
                order number
                <span>{{$orderNumber}}</span>
            </div>
            <div class='seller-number'>
                seller number
                <span>{{$sellerNumber}}</span>
            </div>
            <div class='disabled-seller-number'>
                disabled seller number
                <span>{{$sellerDisabledNumber}}</span>
            </div>
        </section>
        <section class='page-bottom'>
            <div class='last-order'>
                <h2>last order</h2>
                <table class='table'>
                    <tr>
                        <th>price</th>
                        <th>owner</th>
                        <th>created at</th>
                        <th>send time</th>
                        <th>seller</th>
                        <th >operation</th>
                    </tr>
                    @if(isset($order))
                    <tr>
                        <td>{{$order->price}} EGP</td>
                        <td>{{$order->userName}}</td>
                        <td>{{$order->created_at}}</td>
                        <td>{{$order->send_time}}</td>
                        <td>{{$order->sellerName}}</td>
                        <td class='operation'>
                            <a class='show' href="{{route('order.show',$order->id)}}" title='show orders'><i class="fas fa-eye"></i></a> 
                            <a class='update' href="{{route('order.get.update',$order->id)}}" title='update orders'><i class="far fa-edit"></i></a>
                        </td>
                    </tr>
                    @endif
                </table>
            </div>
            <div class='last-seller'>
                <h2>last seller</h2>
                <table class='table'>

                    <tr>
                        <th>national ID</th>
                        <th>name</th>
                        <th>e-mail</th>
                        <th>image</th>
                        <th>acount type</th>
                        <th>add at</th>
                        <th>status</th>
                    </tr>
                    @if(isset($seller))
                    <tr>
                        <td>{{$seller->id}}</td>
                        <td>{{$seller->name}}</td>
                        <td>{{$seller->email}}</td>
                        <td>
                            <img class='image'src="{{URL::asset('site/images/profile'.'/'.$seller->image)}}"> 
                        </td>
                        <td>
                            <?php if($seller->acount_type == 1) echo 'company';else echo 'individual';?>
                        </td>
                        <td>
                            {{$seller->created_at}}
                        </td>
                        <td>
                            <?php if($seller->status === 1) echo'active'; else echo'not active';?>
                        </td>
                    </tr>
                    @endif
                </table>
    
            </div>
        </section>
    </div>
@endsection
