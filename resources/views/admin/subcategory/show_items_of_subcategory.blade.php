@extends('admin.layouts.app')
@section('content')
    <header >
        <h3>{{$subcategory['name']}} item show</h3>
    </header>
    <div class='body'>
        <table class='table'>
            <tr>
                <th>#</th>
                <th>name</th>
                <th>details</th>
                <th>image</th>
                <th>price</th>
                <th>discount</th>
                <th>newPrice</th>
            </tr>
            <?php $count=1;?>
            @foreach($items as $item)
            <tr>
                <td>{{$count}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->details}}</td>
                <td >
                    <a href="{{route('item.details',$item->id)}}">
                        <img class='image'src="{{URL::asset('site/images/categories/'.$subcategory['namespace'].'/'.$item->image)}}">
                    </a>
                </td>
                <td><del>{{$item->price}} EGP<del></td>
                @if($item->discount !== null)
                <td>{{$item->discount->discount_value}}%</td>
                <td>{{$item->newPrice}} EGP</td>
                @else
                <td></td>
                <td></td>
                @endif
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
            <a href="">
                <i class="fas fa-plus"> add item</i>
            </a>
        </div>
    </div>
    <script>
        document.getElementById('subcategory').classList.add('active');
    </script>
@endsection