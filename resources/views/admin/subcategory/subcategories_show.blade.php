@extends('admin.layouts.app')
@section('content')
    <header >
        <h3>subcategory setting</h3>
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
                <th>items num</th>
                <th>image</th>
                <th>category name</th>
                <th class='operation'>operation</th>
            </tr>
            <?php $count=1;?>
            @foreach($subcategories as $subCate)
            <tr>
                <td>{{$count}}</td>
                <td>{{$subCate->name}}</td>
                <td>{{$subCate->itemNum}}</td>
                <td class='image' >
                    <img src="{{URL::asset('site/images/subcategories_image/'.$subCate->image)}}" >
                </td>
                <td>{{$subCate->categoryName}}</td>
                <td >
                    <a class='show' href="{{route('subcategory.show',$subCate->id)}}" title='show subcategory'><i class="fas fa-eye"></i></a> 
                    <a class='update' href="{{route('subcategory.get.update',$subCate->id)}}" title='update subcategory'><i class="far fa-edit"></i></a>
                    <a class='update' href="{{route('subcategory.delete',$subCate->id)}}" title='delete subcategory'><i class="fa fa-trash" aria-hidden="true"></i></a>
                </td>
            </tr>
           <?php $count++;?>
            @endforeach
        </table>
        <section class='pagination'>
            <p>{{$subcategories->currentPage()}} of {{$subcategories->lastPage()}} pages</p>
            <nav class='pagination-links'>
                <ul>
                    <li>
                        @if($subcategories->currentPage()>1)
                            <a href="{{$subcategories->url($subcategories->currentPage()-1)}}">prev</a>
                        @else
                            <a class='disabled' href="">prev</a>
                        @endif
                    </li>
                    <li>
                        @if($subcategories->currentPage() < $subcategories->lastPage())
                            <a href="{{$subcategories->url($subcategories->currentPage()+1)}}">next</a>
                        @else
                            <a class='disabled' href="">next</a>
                        @endif
                    </li>
                </ul>
            </nav>
        </section>
        <div class='add-category'>
            <a href="{{route('subcategory.create')}}">
                <i class="fas fa-plus">  add subcategory</i>
            </a>
        </div>
    </div>
    <script>
        document.getElementById('subcategory').classList.add('active');
        var message = document.getElementById('message');
        setInterval(function(){
            message.style.display = 'none';
        },800);
    </script>
@endsection