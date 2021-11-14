@extends('layouts.app')

@section('content')
<section class="w-100 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="{{route('index_page')}}" class="font-weight-bold"><i class="fas fa-home"></i> Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Login</li>
                    </ol>
                  </nav>
            </div>
        </div>
    </div>
</section>

<style>
.inputs input {
    width: 40px;
    height: 40px
}

input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    margin: 0
}


.form-control:focus {
    box-shadow: none;
    border: 2px solid #813790
}

.countdown {
    padding: 0.375rem .75rem;
    border-radius: .25rem!important;
    color: #cf0000;
    border: 1px solid #ffbdbd;
    font-size: 1rem;
    max-width: 280px;
    text-align: center;
    margin:15px auto;
}

</style>


<section class="w-100 products-section py-6">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4">
                <div class="login-wrapper shadow-sm p-4 rounded bg-white">
                                      
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if (isset($mobile))
                      @if (isset($error))
                          <div class="alert alert-danger">{{$error}}</div>
                      @endif
                    <h4 class="mb-3 text-center">Please enter the OTP to verify your number</h4>
                      
                      <form method="POST" action="{{ route('submit.otp') }}">
                        @csrf
                          <div class="form-group">
                              <input type="hidden" name="mobile" value="{{$mobile}}">
                              
                              <input id="otp" type="hidden" class="form-control @error('otp') is-invalid @enderror" name="otp" value="{{ old('otp') }}" required autofocus>

                              <div id="otp2" class="inputs d-flex flex-row justify-content-center mt-2"> 
                                <input class="m-2 text-center form-control rounded" autofocus type="text" id="first" maxlength="1" onblur="sOtp()" /> 
                                <input class="m-2 text-center form-control rounded" type="text" id="second" maxlength="1" onblur="sOtp()" /> 
                                <input class="m-2 text-center form-control rounded" type="text" id="third" maxlength="1" onblur="sOtp()" /> 
                                <input class="m-2 text-center form-control rounded" type="text" id="fourth" maxlength="1" onblur="sOtp()" /> 
                              </div>

                              <p id="hhh"></p>

                              @error('otp')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                          <div class="form-group">
                              <button type="submit" class="btn btn-success btn-block login-btn" name="login">Login</button>
                          </div>

                          <div class="countdown"></div>
                      </form> 
                      <form method="POST" id="resend-otp" action="{{ route('otp.login') }}">
                        @csrf
                        <input  type="hidden" name="mobile" value="{{$mobile}}">
                      </form>
                      <div class="text-center">
                        Didn't get the code? <a href="javascript:void(0)" onclick="document.querySelector('#resend-otp').submit()">Resend</a> <br>
                        <a href="{{route("login")}}">Change Mobile Number</a>
                      </div>
                      
                    @else
                      <h3 class="mb-3">Mobile Number</h3>
                      @if(Session::has('error'))
                        <p class="alert alert-danger">{{ Session::get('error') }}</p>
                     @endif
                      <form method="POST" action="{{ route('otp.login') }}">
                        @csrf
                          <div class="form-group">
                              <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" required autocomplete="Email/Phone Number" autofocus placeholder="01xxxxxxxxx">
                              @error('mobile')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                          <div class="form-group">
                              <button type="submit" class="btn btn-success btn-block" name="login">Send OTP</button>
                          </div>
                      </form> 
                    @endif
                    
                    
                    {{-- <form method="POST" action="{{ route('login') }}">
                      @csrf
                        <div class="form-group">
                            <input id="email_or_phone" type="email_or_phone" class="form-control @error('email_or_phone') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="Email/Phone Number" autofocus>
                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                        </div>
                        <div class="login_footer form-group">
                            <div class="chek-form">
                                <div class="custome-checkbox">
                                    <input class="form-check-input" type="checkbox" name="checkbox" id="exampleCheckbox1" value="">
                                    <label class="form-check-label" for="exampleCheckbox1"><span>Remember me</span></label>
                                </div>
                            </div>
                            <a href="reset.html">Forgot password?</a>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block" name="login">Log in</button>
                        </div>
                    </form> --}}
                </div>
            </div>
        </div>

    </div>
</section>

@endsection

@section('scripts')

<script>
document.addEventListener("DOMContentLoaded", function(event) {
    function OTPInput() {
        const inputs = document.querySelectorAll('#otp2 > *[id]');
        for (let i = 0; i < inputs.length; i++) { 
            inputs[i].addEventListener('keydown', function(event) { 
                if (event.key==="Backspace" ) { 
                    inputs[i].value='' ; 
                    if (i !==0) 
                    inputs[i - 1].focus(); 
                } else { 
                    if (i===inputs.length - 1 && inputs[i].value !=='' ) { 
                        return true; 
                    } else if (event.keyCode> 47 && event.keyCode < 58) { 
                        inputs[i].value=event.key; 
                        if (i !==inputs.length - 1) 
                        inputs[i + 1].focus(); event.preventDefault(); 
                    } else if (event.keyCode> 64 && event.keyCode < 91) { 
                        inputs[i].value=String.fromCharCode(event.keyCode);
                        if (i !==inputs.length - 1) 
                        inputs[i + 1].focus(); 
                        event.preventDefault(); 
                    } 
                } 
            }); 
        } 
    } 
    OTPInput(); 
});

function sOtp() {
    var o1 = document.getElementById('first').value;
    var o2 = document.getElementById('second').value;
    var o3 = document.getElementById('third').value;
    var o4 = document.getElementById('fourth').value;
    var opt5 = (o1) + (o2) +(o3) + (o4);
    document.getElementById('otp').value = opt5;
} 
let set_at_time = null
@if (isset($set_at)) 
    set_at_time = `{{$set_at}}`
@endif

if (set_at_time!=null) {
    //code copied from w3schools
    // var countDownDate = new Date(set_at_time).getTime();
    // // Update the count down every 1 second
    // var x = setInterval(function() {
    //     // Get today's date and time
    //     var now = new Date().getTime();
    //     // Find the distance between now and the count down date
    //     var distance = countDownDate - now;
    //     // Time calculations for days, hours, minutes and seconds
    //     var days = Math.floor(distance / (1000 * 60 * 60 * 24));
    //     var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    //     var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
    //     var seconds = Math.floor((distance % (1000 * 60)) / 1000);

    //     // Display the result in the element with id="demo"
    //     console.log(days + "d " + hours + "h "+ minutes + "m " + seconds + "s ");
    //     // If the count down is finished, write some text
    //     if (distance < 0) {
    //         clearInterval(x);
    //         console.log("EXPIRED");
    //     }
    // }, 1000);

    setTimeout(function(){
        var endTime = set_at_time;
        var curTime = parseInt(Date.now() / 1000)
        var seconds = curTime - endTime;
        var minutes = Math.floor((seconds / 60) / 1000);
        console.log(minutes + " minutes left.", endTime, curTime);
    }, 1000);
}



</script>

<script>
    var timer2 = "5:01";
    var interval = setInterval(function() {
    
    
      var timer = timer2.split(':');
      //by parsing integer, I avoid all extra string processing
      var minutes = parseInt(timer[0], 10);
      var seconds = parseInt(timer[1], 10);
      --seconds;
      minutes = (seconds < 0) ? --minutes : minutes;
      if (minutes < 0) clearInterval(interval);
      seconds = (seconds < 0) ? 59 : seconds;
      seconds = (seconds < 10) ? '0' + seconds : seconds;
      //minutes = (minutes < 10) ?  minutes : minutes;
      $('.countdown').html('Resend code after ' + minutes + ':' + seconds + ' minutes');
      timer2 = minutes + ':' + seconds;
    }, 1000);
    </script>

@endsection
