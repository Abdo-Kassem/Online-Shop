@extends('site.selling.seller_profile.profile_app')
@section('sub-content')
    <div class="profile-body">
        <div class="body">
            <div class="image">
                <label>your image</label>
                <img src="{{URL::asset('site/images/profile').'/'.$seller->image}}" alt="image not exist">
            </div>

            @if(session()->has('fail'))
            <div class='message' id='message'>{{session('fail')}}</div>
            @elseif(session()->has('success'))
            <div class="message" id='message'>{{session('success')}}</div>
            @endif

            <div class="info">
                <div class="id group">
                    <span>id</span> : {{$seller->id}}
                </div>
                <div class="name group">
                    <span>name</span> :  {{$seller->name}}
                </div>
                <div class="email group">
                    <span>e-mail</span> : {{$seller->email}}
                </div>
                <div class="phone group">
                    <table class='table'>
                        <tr>
                            <th>phone number</th>
                            <th>is_wallet</th>
                            <th>wallet_approach</th>
                            <th class='operation'>operation</th>
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
                            <td>
                                <a class='update' href="{{route('phone.edit',$phone->id)}}" title='edit phone'>
                                    <i class="far fa-edit"></i>
                                </a>
                                <a class='update' href="{{route('phone.delete',$phone->id)}}" title='delete phone'>
                                <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
                </div>
                <div class="acount-type group">
                    <span>acount type</span> : <?php if($seller->acount_type==0) echo'individual'; else  echo 'company';?>
                </div>
                <div class="add-at group">
                    <span>add at</span> : {{$seller->created_at}}
                </div>
                <div class="shops group">
                    <table class='table'>
                        <tr>
                            <th>#</th>
                            <th>shop name</th>
                            <th>address</th>
                            <th>post number</th>
                            <th>category name</th>
                            <th>city</th>
                            <th>sender</th>
                            <th>created at</th>
                            <th style="min-width:120px">operation</th>
                        </tr>
                        @foreach($seller->shops as $shop)
                        <tr>
                            <td>{{$shop->id}}</td>
                            <td>{{$shop->name}}</td>
                            <td>{{$shop->address}}</td>
                            <td>{{$shop->post_number}}</td>
                            <td>{{$shop->category_name}}</td>
                            <td>{{$shop->city}}</td>
                            <td>{{$shop->sended_person_email}}</td>
                            <td>{{$shop->created_at}}</td>
                            <td>
                                <a class='show' href="{{route('shop.delete',$shop->id)}}" title='delete shop'>
                                    <i class="fas fa-times-circle"></i>
                                </a> 
                                <a class='update' href="{{route('shop.edit',$shop->id)}}" title='edit shop'>
                                    <i class="far fa-edit"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </table>
            </div>
           
        </div>
    </div>
    <script>
        var message = document.getElementById('message');
        setInterval(function(){
            message.style.display = 'none';
        },3000)
    </script>
@endsection