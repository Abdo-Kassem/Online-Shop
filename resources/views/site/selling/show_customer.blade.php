@extends('site.selling.home_common_links')

@section('page-right-side')
<div class='right-side right-side-order'>
    <header class='header'>
        <h2>show cutomers</h3>
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
                <th>customer name</th>
                <th class='operation'>operation</th>
            </tr>
            <?php $count = 1; ?>
            @foreach($customers as $customer)
            <tr>
                <td>{{$count}}</td>
                <td>{{$customer->customerName}}</td>
                <td>
                    <a href="{{route('seller.customer.remove',$customer->id)}}"
                         title='delete' class='delete-icon'>
                        <i class="fas fa-times-circle"> delete</i>
                    </a>
                </td>
            </tr>
            <?php $count++; ?>
            @endforeach
        </table>
        <section class='pagination'>
            <p>{{$customers->currentPage()}} of {{$customers->lastPage()}} pages</p>
            <nav class='pagination-links'>
                <ul>
                    <li>
                        @if($customers->currentPage()>1)
                            <a href="{{$customers->url($customers->currentPage()-1)}}">prev</a>
                        @else
                            <a class='disabled' href="">prev</a>
                        @endif
                    </li>
                    <li>
                        @if($customers->currentPage() < $customers->lastPage())
                            <a href="{{$customers->url($customers->currentPage()+1)}}">next</a>
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
    var elemWillActive = document.getElementById('your-customer');
    elemWillActive.classList.add('active');
    elemWillActive.setAttribute('style','color:rgba(0,0,0,0.6) !important;font-weight:bold');
    elemWillActive.style.pointerEvents = 'none';
    elemWillActive.style.cursor = 'default';
</script>
@endsection