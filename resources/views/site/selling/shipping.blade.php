@extends('site.selling.app_links')

@section('sub-content')
<div class='shipping-container'>
    <div class='shipping-sub-container'>
        <header class='header'>
            <h2>
                welcome dear <span>{{$sellerName}}</span> in online markting
            </h2>
        </header>
        
        <div class='shipping-content'>
            delivery will will done on one to two day from request and this done by 
            our employee .
            <br>
            our employee will arrive to you and take order to arrive it to customer
            and take price and charging cost from customer and will send your 
            mony after take selling cost
        </div>
    </div>
    
</div>
<script>
     var elemWillActive = document.getElementById('shipping');
    elemWillActive.classList.add('active');
</script>
@endsection
