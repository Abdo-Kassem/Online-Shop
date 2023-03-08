@extends('admin.layouts.app')
@section('content')
    <header >
        <h3>category setting</h3>
    </header>
    <div class='body'>
        @if(session()->has('success'))
            <div id='message' class='success-message'>
                <i class="fas fa-check-circle"></i>
                {{session()->get('success')}}
            </div>
        @elseif(session()->has('fail'))
            <div id='message' class='success-message'>
                <i class="fas fa-check-circle"></i>
                {{session()->get('fail')}}
            </div>
        @endif
        <table class='table'>
            <tr>
                <th>#</th>
                <th>name</th>
                <th>subcate num</th>
                <th>selling cost</th>
                <th>image</th>
                <th class='operation'>operation</th>
            </tr>
            <?php $count=1;?>
            @foreach($categories as $cate)
            <tr>
                <td>{{$count}}</td>
                <td class='category-reffrence'><a class='category-reffrence' href="{{route('get.category',['cateName'=>$cate->name,'cateID'=>$cate->id])}}">{{$cate->name}}</a></td>
                <td>{{$cate->subNum}}</td>
                <td>{{$cate->selling_cost}}</td>
                <td class='image'>
                    <img src="{{URL::asset('site/images/categories_images/'.$cate->image)}}">
                </td>
                <td >
                    <a class='show' href="{{route('category.show',$cate->id)}}" title='show category'><i class="fas fa-eye"></i></a> 
                    <a class='update' href="{{route('category.get.update',$cate->id)}}" title='update category'><i class="far fa-edit"></i></a>
                    <a class='update' href="{{route('category.delete',$cate->id)}}" title='delete category'><i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
            </tr>
           <?php $count++;?>
            @endforeach
        </table>
        <section class='pagination'>
            <p>{{$categories->currentPage()}} of {{$categories->lastPage()}} pages</p>
            <nav class='pagination-links'>
                <ul>
                    <li>
                        @if($categories->currentPage()>1)
                            <a href="{{$categories->url($categories->currentPage()-1)}}">prev</a>
                        @else
                            <a class='disabled' href="">prev</a>
                        @endif
                    </li>
                    <li>
                        @if($categories->currentPage() < $categories->lastPage())
                            <a href="{{$categories->url($categories->currentPage()+1)}}">next</a>
                        @else
                            <a class='disabled' href="">next</a>
                        @endif
                    </li>
                </ul>
            </nav>
        </section>
        <div class='add-category'>
            <a href="{{route('category.create')}}">
                <i class="fas fa-plus"></i>
                add new category
            </a>
        </div>
    </div>
    <script>
        document.getElementById('category').classList.add('active');
        setInterval(function(){
            document.getElementById('message').style.display = 'none';
        },4000)
    </script>
@endsection