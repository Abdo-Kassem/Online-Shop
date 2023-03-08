@extends('site.selling.home_common_links')

@section('page-right-side')
<div class='right-side right-side-order'>
    <header class='header'>
        <h2>show customers feedback</h3>
    </header>
    @if($customers->count() > 0)
        @foreach($customers as $customer)
        <div class='body'>
            <table class='table'>
                <tr>
                    <th>customer name</th>
                    <th>feedback</th>
                    <th>product</th>
                </tr>
                @foreach($customer->feedbacks as $feedback)
                <tr>
                    <td>{{$customer->userName}}</td>
                    <td>{{$feedback->feedback}}</td>
                    <td>{{$feedback->itemName}}</td>
                </tr>
                @endforeach
            </table>
        </div>
        @endforeach
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
    @else
        <div class="message"> no feedback exist</div>
    @endif
</div>
<script>
    var elemWillActive = document.getElementById('customer-feedback');
    elemWillActive.classList.add('active');
    elemWillActive.setAttribute('style','color:rgba(0,0,0,0.6) !important;font-weight:bold');
    elemWillActive.style.pointerEvents = 'none';
    elemWillActive.style.cursor = 'default';
</script>
@endsection