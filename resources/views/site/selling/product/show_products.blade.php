@extends('site.selling.home_common_links')

@section('page-right-side')
<div class='right-side right-side-order'>
    <header class='header'>
        <h2>show products</h3>
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
                <th class='details-width'>details</th>
                <th>image</th>
                <th>price</th>
                <th>discount</th>
                <th>item number</th>
                <th >supbcategory</th>
                <th class='operation'>operation</th>
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
                <td>
                    {{$item->item_number}}
                    
                </td>
                <td>{{$item->subcategoryName}}</td>
                <td>
                    <a href="{{route('ptoduct.edit',$item->id)}}" title='edit' class='update-icon'>
                        <i class='fa fa-edit'></i>
                    </a>
                    <a href="{{route('ptoduct.destroy',$item->id)}}" title='delete' class='delete-icon'>
                        <i class="fas fa-times-circle"></i>
                    </a>
                    <a href="{{route('ptoduct.plus',$item->id)}}" title='add one' class='plus-icon'>
                        <i class="fas fa-plus-circle"></i>
                    </a>
                    <a href="{{route('ptoduct.minus',$item->id)}}" title='minus one' class='minus-icon'>
                        <i class="fas fa-minus-circle"></i>
                    </a>
                </td>
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
    setTimeout(function(){
        document.getElementById('message').style.display = 'none';
    },5000)
    var elemWillActive = document.getElementById('show-products');
    elemWillActive.classList.add('active');
    elemWillActive.setAttribute('style','color:rgba(0,0,0,0.6) !important;font-weight:bold');
    elemWillActive.style.pointerEvents = 'none';
    elemWillActive.style.cursor = 'default';
</script>
@endsection