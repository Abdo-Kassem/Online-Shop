@extends('site.layout.app')

@section('content')
<div class="category-content">
    <div class="categories">
        @if(! is_null($cats))
            <?php $categoryCount = count($cats);?>
            @for($count=0 ; $count < $categoryCount; $count++)
            <a href="{{route('get.category',$cats[$count]->id)}}" class="superMarket">
                <i class="fas fa-apple-alt"></i>
                <span>{{$cats[$count]->name}}</span>
            </a>
            @endfor
        @endif
    </div>
    <div class="center-ads">
        <div class="slider">
            <div id="images" class="slider-images">
                @if($itemsSlider)
                     @foreach($itemsSlider as $item)
                        <a href="{{route('item.details',$item->id)}}" class="">
                            @if(! is_null($item->discount))
                            <span class='discount'>-{{$item->discount->discount_value}}%</span>
                            @endif
                            <img src="{{URL::asset('site/images/categories/'.$item->namespace.'/'.$item->image)}}" alt="">
                        </a>
                    @endforeach
                @endif
                
            </div>
            <div class="slider-controller">
                <div class="buttons">
                    <button class="next" onclick="next()" >
                        &gt
                    </button>
                    <button class="prev" onclick="prev()">
                        &lt
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="right-content">
        @if(! is_null($cats) && ! is_null($cats[0]->supCategories))
            <?php $subCount = $cats[0]->supCategories->count();?> 
            @for($count=0;$count<$subCount&&$count<=1;$count++)
            <a href="{{route('category.subCategory',$cats[0]->supCategories[$count]->id)}}" class="top-image">
                <img src="{{URL::asset('site/images/subcategories_image/'.$cats[0]->supCategories[$count]->image)}}">
            </a>
            @endfor
        @endif
    </div >
</div>
@if(!is_null($cats))
<div class="offers">
    @foreach($cats as $cat)
    <a href="{{route('get.category',$cat->id)}}">
        <img src="{{URL::asset('site/images/categories_images/'.$cat->image)}}">
    </a>
    @endforeach
</div>
@endif
<section style="border-radius: 10px;"class="top-selling">
    <div class="header">
        <h4 style="display:inline-block">brand festival</h4>
        <h7 style="display:inline-block">| top deals</h7>
        <a href="{{route('item.top.deals')}}">all</a>
    </div>
    <div class="content">
       @foreach($topDiscountItems as $topDiscountItem)
        <a href="{{route('item.details',$topDiscountItem->item->id)}}">
            <img src="{{URL::asset('site/images/categories/'.$topDiscountItem->item->categoryName.'/'.$topDiscountItem->item->image)}}" >
            <div class="description">
                <div class="name">
                  {{$topDiscountItem->item->name}} 
                </div>
                <div class="price">
                    <span class="new-price">
                        {{$topDiscountItem->item->newPrice}}$
                    </span>
                    <span class="old-price">
                        {{$topDiscountItem->item->price}}$
                    </span>
                </div>
                <div class="discount">
                    -{{$topDiscountItem->discount_value}}%
                </div>
            </div>
        </a>
       @endforeach
    </div>
</section>
<!--
<section class="flash-sales">
    <div class="header">
        <h4 style="display:inline-block">
            <i  class="fa fa-bolt" aria-hidden="true"></i>
            flash sales every day
        </h4>
        <a href="{{route('category.subCategory',$cats[0]->supCategories[0]->name)}}">SEE ALL &gt;</a>
    </div>
    <div class="content">
            <a href="#">
                <img src="{{URL::asset('site/images/deal/1.jpg')}}" >
                <div class="description">
                    <div class="name">
                        
                    </div>
                    <div class="price">
                        <span class="new-price">
                            
                        </span>
                        <span class="old-price">
                           
                        </span>
                    </div>
                    <div class="discount">

                    </div>
                    <div class="time">

                    </div>
                    <div class="item-number">
                        <span id="number" > items left</span>
                        <div id="visualization">
                            <span id='sub-visualization'></span>
                        </div>
                    </div>
                </div>
            </a>
        
    </div>
</section>
-->
@if(isset($freeShipping) && count($freeShipping)>0)
<section class="free-shiping-national">
    <div class="header">
        <h4 style="display:inline-block">
            free shipping
        </h4> 
    </div>
    <div class="content">
        @foreach($freeShipping as $item)
        <a href="{{route('item.details',$item->id)}}">
            <img src="{{URL::asset('site/images/categories/'.$item->namespace.'/'.$item->image)}}" >
            <div class="description">
                <div class="name">
                    {{$item->name}}
                </div>
                @if($item->discount != null)
                <div class="price">
                    <span class="new-price">
                        {{$item->newPrice}}$
                    </span>
                    <span class="old-price">
                        {{$item->price}}$
                    </span>
                </div>
                
                <div class="discount">
                    -{{$item->discount->discount_value}}%
                </div>
                @else
                <div class="price">
                    <span class="new-price">
                        {{$item->price}}$
                    </span>
                </div>
                @endif
            </div>
        </a>
        @endforeach
    </div>
</section>
@endif
@if($categoryTopSelling !== null && count($categoryTopSelling)>0)
<section class="free-shiping-national">
    <div class="header">
        <h4 style="display:inline-block">
            top selling
        </h4> 
    </div>
    <div class="content">
        @foreach($categoryTopSelling as $subcateTopSelling)
        @foreach($subcateTopSelling as $item)
        <a href="{{route('item.details',$item->id)}}">
            <img src="{{URL::asset('site/images/categories/'.$item->namespace.'/'.$item->image)}}" >
            <div class="description">
                <div class="name">
                    {{$item->name}}
                </div>
                @if($item->discount != null)
                <div class="price">
                    <span class="new-price">
                        {{$item->newPrice}}$
                    </span>
                    <span class="old-price">
                        {{$item->price}}$
                    </span>
                </div>
                
                <div class="discount">
                    -{{$item->discount->discount_value}}%
                </div>
                @else
                <div class="price">
                    <span class="new-price">
                        {{$item->price}}$
                    </span>
                </div>
                @endif
            </div>
        </a>
        @endforeach
        @endforeach
    </div>
</section>
@endif
<!--
<section class="more-deals">
    <div class="header">
        <h4>baby products</h4>
    </div>
    <div class="content">
        <a href="">
            <img src="" >
        </a>
        <a href="{{route('category.subCategory','Bath & skin care')}}">
            <img src="" >
        </a>
    </div>
</section>
-->
@if(count($topSelling)>0)
@foreach( $topSelling as $subcategoryName=>$topSelling)
<section style="border-radius: 10px;"class="top-selling">
    <div class="header">
        <h4 style="display:inline-block">{{$subcategoryName}} top selling</h4>
    </div>
    <div class="content">
        @if(count($topSelling)>0)
        @foreach($topSelling as $item)
            <a href="{{route('item.details',$item->id)}}">
                <img src="{{URL::asset('site/images/categories/'.$item->namespace.'/'.$item->image)}}" >
                <div class="description">
                    <div class="name">
                        {{$item->name}}
                    </div>
                    @if($item->discount!=null)
                        <div class="price">
                            <span class="new-price">
                                {{$item->newPrice}}$
                            </span>
                            <span class="old-price">
                                {{$item->price}}$
                            </span>
                        </div>
                        <div class="discount">
                            -{{$item->discount->discount_value}}%
                        </div>
                    @else
                        <div class="price">
                            <span class="new-price">
                                {{$item->price}}$
                            </span>
                        </div>
                    @endif
                </div>
            </a>
        @endforeach
        @else
            <div class='message'>no item selling in this category</div>
        @endif
    </div>
</section>
@endforeach
@endif
<script>
    function makeItemNumberVisualization(){
        var itemNumber = document.getElementById('number').getAttribute('itemNumber');
        var itemsExistVisual = document.getElementById('sub-visualization');
        if(itemNumber<=100){
            itemsExistVisual.style.setProperty('width',itemNumber+'%');
        }else{
            itemsExistVisual.style.setProperty('width','100%');
        }
    }
    
    function dividSubCategoryWidth(){
        var links = document.getElementsByClassName('content-subCategory');
        var content = document.getElementsByClassName('sub-content')[0].clientWidth;
        var countOfLinks = (links.length>4)?4:links.length;
        for(count=0;count<countOfLinks;count++){
            links[count].style.setProperty('flex-basis',(content/countOfLinks-10)+'px');
        }
    }
    makeItemNumberVisualization();
    dividSubCategoryWidth();
</script>
@endsection