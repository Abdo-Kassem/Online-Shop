@extends('site.selling.seller_profile.profile_app')
@section('style')
<link rel='stylesheet' href="{{URL::asset('site\css\formStyle.css')}}">
@endsection
@section('sub-content')
    <div class='container container-wallet-type'>
        <header class='header'>
            <h3>specify wallet type</h3>
        </header>
        <div class='body'>
        @if(session()->has('fail'))
            <div id='message'class='fail-message'>
                <i class="fas fa-times-circle"></i>
                {{session()->get('fail')}}
            </div>
        @endif
        <form method='post' action="{{route('phone.update')}}" enctype="multipart/form-data" name='create'>
                @csrf
                <div class="form-group">
                    <label for="wallet_type"> wallet type </label>
                    <select id='wallet_type' name='walletType'>
                        <option></option>
                        <option <?php if($phone->wallet_approach == 'we') echo('selected');?> value='we'>we</option>
                        <option <?php if($phone->wallet_approach == 'vodafone') echo('selected');?> value='vodafone'>vodafone</option>
                        <option <?php if($phone->wallet_approach == 'fawry') echo('selected');?> value='fawry'>fawry</option>
                    </select>
                    @error('walletType')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">wallet phone number</label>
                    <input type="tel"  id="phone" name='phone' placeholder="phone number" 
                        value="{{$phone->phone_number}}" required>
                    <span id='error_message'style='display:none;color:brown'></span>
                    @error('phone')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <input type='hidden' name='phoneID' value="{{$phone->id}}">

                
                <button type="submit" class="submite">save</button>
            </form>
        </div>
    </div>
    <script>

        var walletType = document.getElementById('wallet_type');
        var phone = document.getElementById('phone');
        var form = document.forms['create'];
        var phoneInput = form.elements[2];
        var walletTypeInput = form.elements[1];
        phone.addEventListener('change',function(){

            let errorSpan = document.getElementById('error_message');
            if(phone.value.length >= 3){
                if(phone.value.substr(0,3) == '015'){
                    walletType.value = 'we';
                }else if(phone.value.substr(0,3) == '011'){
                    walletType.value = 'fawry';
                }else if(phone.value.substr(0,3) == '010'){
                    walletType.value = 'vodafone';
                }else{
                    walletType.value = '';
                    phone.value = '';
                }
            }else{
                phone.value = '';
                walletType.value = '';
            }
            
        });
        
    </script>
@endsection