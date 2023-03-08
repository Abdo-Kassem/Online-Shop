@extends('admin.layouts.app')
@section('content')
    <header >
        <h3>items show</h3>
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
                <th class='operation'>operation</th>
            </tr>
            <?php $count=1;?>
            @foreach($items as $item)
            <tr>
                <td>{{$count}}</td>
                <td>{{$item->name}}</td>
                <td >
                    <a href="{{route('item.details',$item->id)}}">
                        <img class='image'src="{{URL::asset('site/images/categories/'.$item->namespace.'/'.$item->image)}}">
                    </a>
                </td>
                <td>{{$item->price}} EGP</td>
                <td>
                    @if($item->free_shipping == 1)
                        free
                    @else
                        paid
                    @endif
                </td>
                <td>
                    @if($item->free_shipping == 1)
                        
                    @else
                        {{$item->shipping_cost}} EGP
                    @endif
                </td>
                <td>
                    <a class='show' href="{{route('item.delete',$item->id)}}" title='delete product'>
                        <i class="fas fa-times-circle"></i>
                    </a> 
                    <a class='update' href="{{route('item.update',$item->id)}}" title='update product'>
                        <i class="far fa-edit"></i>
                    </a>
                </td>
            </tr>
            <?php $count++;?>
            @endforeach
        </table>
        <section class='pagination'>
            <p>{{$items->currentPage()}} of {{$items->lastPage()}} pages</p>
            <nav class='pagination-links'>
                <ul>
                    <li>
                        @if($items->currentPage()>1)
                            <a href="{{$items->url($items->currentPage()-1)}}">prev</a>
                        @else
                            <a class='disabled' href="">prev</a>
                        @endif
                    </li>
                    <li>
                        @if($items->currentPage() < $items->lastPage())
                            <a href="{{$items->url($items->currentPage()+1)}}">next</a>
                        @else
                            <a cl6ass='disabled' href="">next</a>
                        @endif
                    </li>
                </ul>
            </nav>
        </section>
        <div class='add-category'>
            <a href="{{route('item.create.form')}}">
                <i class="fas fa-plus"> add item</i>
            </a>
        </div>
    </div>
    <script>
        document.getElementById('item').classList.add('active');
        setInterval(function(){
           console.log(document.getElementById('message'));
        },5000);
    </script>
@endsection