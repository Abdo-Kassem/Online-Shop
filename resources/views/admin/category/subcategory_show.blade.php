@extends('admin.layouts.app')
@section('content')
    <header >
        <h3>category setting</h3>
    </header>
    <div class='body'>
        <table class='table'>
            <tr>
                <th>#</th>
                <th>name</th>
                <th>items num</th>
                <th class='operation'>operation</th>
            </tr>
            <?php $count=1;?>
            @foreach($subCategories as $subcate)
            <tr>
                <td>{{$count}}</td>
                <td>{{$subcate->name}}</a></td>
                <td>{{$subcate->itemNum}}</td>
                <td >
                    <a class='show' href="{{route('subcategory.show',$subcate->id)}}" title='show category'><i class="fas fa-eye"></i></a> 
                    <a class='update' href="{{route('subcategory.get.update',$subcate->id)}}" title='update category'><i class="far fa-edit"></i></a>
                </td>
            </tr>
           <?php $count++;?>
            @endforeach
        </table>
        <section class='pagination'>
            <p>{{$subCategories->currentPage()}} of {{$subCategories->lastPage()}} pages</p>
            <nav class='pagination-links'>
                <ul>
                    <li>
                        @if($subCategories->currentPage()>1)
                            <a href="{{$subCategories->url($subCategories->currentPage()-1)}}">prev</a>
                        @else
                            <a class='disabled' href="">prev</a>
                        @endif
                    </li>
                    <li>
                        @if($subCategories->currentPage() < $subCategories->lastPage())
                            <a href="{{$subCategories->url($subCategories->currentPage()+1)}}">next</a>
                        @else
                            <a class='disabled' href="">next</a>
                        @endif
                    </li>
                </ul>
            </nav>
        </section>
        <div class='add-category'>
            <a href="{{route('subcategory.create')}}">
                <i class="fas fa-plus"> add subcategory</i>
            </a>
        </div>
    </div>
    <script>
        document.getElementById('category').classList.add('active');
    </script>
@endsection