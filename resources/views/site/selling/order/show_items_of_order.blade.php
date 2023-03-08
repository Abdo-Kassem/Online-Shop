@extends('site.selling.home_common_links')

@section('page-right-side')
<div class='right-side right-side-order'>
    <header class='header'>
        <h2>order {{$items->orderID}} show</h3>
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
                <th >supbcategory</th>
            </tr>
            @foreach($items as $item)
            <tr>
                <td>{{$item->id}}</td>
                <td>{{$item->name}}</td>
                <td>{{$item->details}}</td>
                <td >
                    <a href="{{route('item.details',$item->id)}}">
                        <img class='image'src="{{URL::asset('site/images/categories/'.$item->namespace.'/'.$item->image)}}">
                    </a>
                </td>
                <td>{{$item->price}} EGP</td>
                @if($item->discount != null)
                    <td>-{{$item->discount->discount_value}}%</td>
                @else
                    <td></td>
                @endif
                <td>{{$item->subcategoryName}}</td>
            </tr>
            
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
                            <a class='disabled' href="">next</a>
                        @endif
                    </li>
                </ul>
            </nav>
        </section>
    </div>
</div>
<script>
    var elemWillActive = document.getElementById('show-orders');
    elemWillActive.classList.add('active');
    elemWillActive.setAttribute('style','color:rgba(0,0,0,0.6) !important;font-weight:bold');
    
</script>
@endsection