@extends('site.layout.app')
@section('style')
<link rel='stylesheet' href="{{URL::asset('site/css/category_page.css')}}">
@endsection
@section('content')

<section class="sub-category-hot-deals">
    <div class="header" style="text-align:center;display:block;color:#383737">
        <h3>sell your {{$subCategoryData->name}} prefer</h3>
    </div>
    <div class="content">
    @if(count($subCategoryData->items)>0)
        @foreach($subCategoryData->items as $item)
        <a href="{{route('item.details',$item->id)}}">
            <img src="{{URL::asset('site/images/categories/'.$categoryName.'/'.$item->image)}}" >
            <div class="description">
                <div class="name">
                    {{$item->name}}
                </div>
                @if(isset($item->discount_value))
                    <div class="price">
                        <span class="new-price">
                            price : {{$item->newPrice}}$
                        </span>
                        <del class="old-price">
                            {{$item->price}}$
                        </del>
                    </div>
                    <div class="discount">
                        {{$item->discount_value}}
                    </div>
                @else
                    <span class="price">
                            price : {{$item->price}}$
                    </span>
                @endif
            </div>
        </a>
    @endforeach
    @else
        <p class='message'> no item in this category</p>
    @endif
    </div>

    <section class='pagination'>
        <p>{{$subCategoryData->items->currentPage()}} of {{$subCategoryData->items->lastPage()}} pages</p>
        <nav class='pagination-links'>
            <ul>
                <li>
                    @if($subCategoryData->items->currentPage()>1)
                        <a href="{{$subCategoryData->items->url($subCategoryData->items->currentPage()-1)}}">prev</a>
                    @else
                        <a class='disabled' href="">prev</a>
                    @endif
                </li>
                <li>
                    @if($subCategoryData->items->currentPage() < $subCategoryData->items->lastPage())
                        <a href="{{$subCategoryData->items->url($subCategoryData->items->currentPage()+1)}}">next</a>
                    @else
                        <a class='disabled' href="">next</a>
                    @endif
                </li>
            </ul>
        </nav>
    </section>

@endsection