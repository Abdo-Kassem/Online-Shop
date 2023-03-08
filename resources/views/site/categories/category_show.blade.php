@extends('site.layout.app')
@section('style')
<link rel='stylesheet' href="{{URL::asset('site/css/category_page.css')}}">
@endsection
@section('content')
<section class="shop-by-category">
    <div class="header">
        <h4>shop by category</h4>
    </div>
    <div class="content">
        @if(count($subCategories)>0)
            @foreach($subCategories as $subCategory)
                <a href="{{route('category.subCategory',$subCategory->name)}}"
                 class='content-subCategory' title="{{$subCategory->name}}">
                 <img class='sup-category-image'src="{{URL::asset('site/images/subcategories_image/'.$subCategory->image)}}">
                
                </a>
            @endforeach
        @else
            <p class='message'>no category created</p>
        @endif
    </div>
    
</section>
<!--end shop by category-->

@foreach($subCategories as $subCategory)
    <section class="sub-category-hot-deals">
        <div class="header">
            <h3>{{$subCategory->name}}!</h3>
            <a href="{{route('category.subCategory',$subCategory->id)}}">see all</a>
        </div>
        <div class="content">
        @if(count($subCategory->items)>0)
            @foreach($subCategory->items as $item)
            <a href="{{route('item.details',$item->id)}}">
                <img src="{{URL::asset('site/images/categories/'.$namespace.'/'.$item->image)}}" >
                <div class="description">
                    <div class="name">
                        {{$item->name}}
                    </div>
                    @if(isset($item->discount->discount_value))
                        <div class="price">
                            <span class="new-price">
                                price : {{$item->newPrice}}$
                            </span>
                            <del class="old-price">
                                {{$item->price}}$
                            </del>
                        </div>
                        <div class="discount">
                            -{{$item->discount->discount_value}}%
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
    </section>
    <section style="border-radius: 10px;" class="top-picks">
        <div class="header">
            <h7 style="display:inline-block">top picks</h7>
            <a href="{{route('topPicks.subCategory',[$subCategory->name,$subCategory->id])}}">see all</a>
        </div>
        <div class="content">
        @if(count($subCategory->topPicks)==0)
            <p class='message'>no item in top picks </p>
        @else
            @foreach($subCategory->topPicks as $item)
                <a href="{{route('item.details',$item->id)}}">
                    <img src="{{URL::asset('site/images/categories/'.$namespace.'/'.$item->image)}}" >
                    <div class="description">
                        <div class="name">
                            {{$item->name}}
                        </div>
                        @if(isset($item->discount->discount_value))
                            <div class="price">
                                <span class="new-price">
                                    {{$item->newPrice}}
                                </span>
                                <span class="old-price">
                                    {{$item->price}}
                                </span>
                            </div>
                            <div class="discount">
                                -{{$item->discount->discount_value}}%
                            </div>
                        @else
                            <span class="price">
                                {{$item->price}}
                             </span>
                        @endif
                    </div>
                </a>
            @endforeach
        @endif
        </div>
    </section>
@endforeach
<script>
    var links = document.getElementsByClassName('content-subCategory');
    var content = document.getElementsByClassName('content')[0].clientWidth;
    var countOfLinks = links.length;
    if(countOfLinks>=2)
        for(count=0;count<countOfLinks;count++){
            links[count].style.setProperty('flex-basis',(content/countOfLinks-15)+'px');
        }

</script>
@endsection