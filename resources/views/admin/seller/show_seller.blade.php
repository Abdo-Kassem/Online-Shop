@extends('admin.layouts.app')
@section('content')
    <div class='body' style="padding:0 !important;background-color:transparent">
        <header class='top-seller-header'>
            <h1>show sellers</h1>
            @if(!is_null($sellers))
            <div class='show-seller-option'>
                <div class="dropdown-arrow">
                    <span class='arrow'></span>
                    <div class='dropdown-list'>
                        <ul class='links'>
                            <li>
                                <a href="{{route('get.admin.seller')}}">show all seller</a>
                            </li>
                            <li>
                                <a href="{{route('get.admin.seller',1)}}">show active seller</a>
                            </li>
                            <li>
                                <a href="{{route('get.admin.seller',2)}}">all disabled seller</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            @endif
        </header>
        <div class='operation-message'>
            @if(session()->has('fail'))
            <div id='message'class='fail-message'>
                <i class="fas fa-times-circle"></i>
                {{session()->get('fail')}}
            </div>
            @elseif(session()->has('success'))
            <div id='message'class='success-message'>
                <i class="fas fa-check-circle"></i>
                {{session()->get('success')}}
            </div>
            @endif
        </div>
        @if(!is_null($sellers))
        @foreach($sellers as $seller)
        <section class='body-group'>
            <header class='header'>
                <h3 class='seller-name'>seller name : {{$seller->name}}</h3>
                <div class="operation">
                    <a href="{{route('admin.delete.seller',$seller->id)}}" class='delete'>
                        <i class="fas fa-times-circle"></i> delete
                    </a>
                    @if($seller->status === 0) 
                    <a href="{{route('admin.active.seller',$seller->id)}}" class='agree'>
                        <i class="fas fa-check-circle"></i> active
                    </a>
                    @endif
                    
                </div>
            </header>
            
            <div class="seller-data">
                <div class='seller-inf'>
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
                
                    </table>
                </div>
                <div class="seller-phones">
                    <table class='table'>
                        <tr>
                            <th>phone number</th>
                            <th>is_wallet</th>
                            <th>wallet_approach</th>
                        </tr>
                        @foreach($seller->phones as $phone)
                        <tr>
                            <td>{{$phone->phone_number}}</td>
                            <td>{{$phone->is_wallet}}</td>
                            <td>
                                @if($phone->wallet_approach != null)
                                    {{$phone->wallet_approach}}
                                @else
                                    not exist
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="seller-shops">
                    <table class='table'>
                        <tr>
                            <th>shop name</th>
                            <th>address</th>
                            <th>post number</th>
                            <th>category name</th>
                            <th>city</th>
                            <th>sender</th>
                            <th>created at</th>
                        </tr>
                        @foreach($seller->shops as $shop)
                        <tr>
                            <td>{{$shop->name}}</td>
                            <td>{{$shop->address}}</td>
                            <td>{{$shop->post_number}}</td>
                            <td>{{$shop->category_name}}</td>
                            <td>{{$shop->city}}</td>
                            <td>{{$shop->sended_person_email}}</td>
                            <td>{{$shop->created_at}}</td>
                            
                        </tr>
                        @endforeach
                    </table>
                </div>
            </div>
        </section>
        @endforeach

        <section class='pagination'>
            <p>{{$sellers->currentPage()}} of {{$sellers->lastPage()}} pages</p>
            <nav class='pagination-links'>
                <ul>
                    <li>
                        @if($sellers->currentPage()>1)
                            <a href="{{$sellers->url($sellers->currentPage()-1)}}">prev</a>
                        @else
                            <a class='disabled' href="">prev</a>
                        @endif
                    </li>
                    <li>
                        @if($sellers->currentPage() < $sellers->lastPage())
                            <a href="{{$sellers->url($sellers->currentPage()+1)}}">next</a>
                        @else
                            <a cl6ass='disabled' href="">next</a>
                        @endif
                    </li>
                </ul>
            </nav>
        </section>
        @else
            <div class='message'> no sellers exist</div>
        @endif
       
    </div>
    <script>
        document.getElementById('seller').classList.add('active');
        setInterval(function(){
           document.getElementById('message').style.display = 'none';
        },5000);
    </script>
@endsection