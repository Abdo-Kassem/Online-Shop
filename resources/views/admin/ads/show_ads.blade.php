@extends('admin.layouts.app')
@section('content')
    <header >
        <h3>ads items</h3>
    </header>
    <div class='body'>
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
        <table class='table'>
            <tr>
                <th>#</th>
                <th>name</th>
                <th>image</th>
                <th>price</th>
                <th>shipping</th>
                <th>shipping cost</th>
                <th>discount</th>
                <th class='operation'>operation</th>
            </tr>
            <?php $count=1;?>
            @foreach($ads as $ad)
            <tr>
                <td>{{$count}}</td>
                <td>{{$ad->name}}</td>
                <td >
                    <a href="{{route('item.details',$ad->id)}}">
                        <img class='image'src="{{URL::asset('site/images/categories/'.$ad->namespace.'/'.$ad->image)}}">
                    </a>
                </td>
                <td>{{$ad->price}} EGP</td>
                <td>
                    @if($ad->free_shipping == 1)
                        free
                    @else
                        paid
                    @endif
                </td>
                <td>
                    @if($ad->free_shipping == 1)
                        
                    @else
                        {{$item->shipping_cost}} EGP
                    @endif
                </td>
                <td><?php if($ad->discount !== null) echo $ad->discount->discount_value;?></td>
                <td>
                    <a class='show' href="{{route('delete.ads',$ad->id)}}" title='disable ads'>
                        <i class="fas fa-times-circle"></i>
                    </a> 
                    
                </td>
            </tr>
            <?php $count++;?>
            @endforeach
        </table>
        <section class='pagination'>
            <p>{{$ads->currentPage()}} of {{$ads->lastPage()}} pages</p>
            <nav class='pagination-links'>
                <ul>
                    <li>
                        @if($ads->currentPage()>1)
                            <a href="{{$ads->url($ads->currentPage()-1)}}">prev</a>
                        @else
                            <a class='disabled' href="">prev</a>
                        @endif
                    </li>
                    <li>
                        @if($ads->currentPage() < $ads->lastPage())
                            <a href="{{$ads->url($ads->currentPage()+1)}}">next</a>
                        @else
                            <a cl6ass='disabled' href="">next</a>
                        @endif
                    </li>
                </ul>
            </nav>
        </section>
    </div>
    <script>
        document.getElementById('show-ads').classList.add('active');
        setInterval(function(){
           console.log(document.getElementById('message'));
        },5000);
    </script>
@endsection