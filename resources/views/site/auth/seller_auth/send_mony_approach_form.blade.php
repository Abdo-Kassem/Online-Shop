@extends('site.selling.app')
@section('style')
<link rel='stylesheet' href="{{URL::asset('site\css\formStyle.css')}}">
@endsection
@section('content')
    <div class='container container-wallet-type'>
        <header >
            <h3>specify wallet type</h3>
        </header>
        <div class='body'>
        @if(session()->has('fail'))
            <div id='message'class='fail-message'>
                <i class="fas fa-times-circle"></i>
                {{session()->get('fail')}}
            </div>
        @endif
        <form method='post' action="{{route('seller.create.wallet')}}" enctype="multipart/form-data" name='create'>
                @csrf
                <div class="form-group">
                    <label for="wallet_type"> wallet type </label>
                    <select id='wallet_type' name='wallet_approach'>
                        <option></option>
                        <option value='we'>we</option>
                        <option value='vodafone'>vodafone</option>
                        <option value='fawry'>fawry</option>
                    </select>
                    @error('wallet_approach')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="phone">wallet phone number</label>
                    <input type="tel"  id="phone" name='phone_number' placeholder="phone number" required>
                    <span id='error_message'style='display:none;color:brown'></span>
                    @error('phone_number')
                        <span style='color:brown' >{{$message}}</span>
                    @enderror
                </div>
                
                <button type="submit" class="submite">create</button>
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