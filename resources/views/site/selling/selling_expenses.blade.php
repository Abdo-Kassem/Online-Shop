@extends('site.selling.app_links')

@section('sub-content')
<div class='shipping-container'>
    <div class='shipping-sub-container'>
        <header class='header'>
            <h2>
                selling expenses on your shops 
            </h2>
        </header>
        
        <div class='shipping-content'>
            <table>
                <?php $count = 1;?>
                <tr>
                    <th>#</th>
                    <th>shipping name</th>
                    <th>cost / month</th>
                </tr>
                @foreach($categoriesDate as $categoryDate)
                <tr>
                    <td>{{$count}}</td>
                    <td>{{$categoryDate->name}}</td>
                    <td>{{$categoryDate->selling_cost}}EGP</td>
                </tr>
                <?php $count++; ?>
                @endforeach
            </table>
        </div>
    </div>
    
</div>
<script>
     var elemWillActive = document.getElementById('selling_expenses');
    elemWillActive.classList.add('active');
</script>
@endsection
