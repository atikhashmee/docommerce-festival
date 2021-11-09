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


<section class="w-100 products-section py-5">
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
                    <h3 class="mb-3">OTP</h3>
                      
                      <form method="POST" action="{{ route('submit.otp') }}">
                        @csrf
                          <div class="form-group">
                              <input type="hidden" name="mobile" value="{{$mobile}}">
                              <input id="otp" type="number" class="form-control @error('otp') is-invalid @enderror" name="otp" value="{{ old('otp') }}" required autofocus>
                              @error('otp')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                          <div class="form-group">
                              <button type="submit" class="btn btn-success btn-block" name="login">Login</button>
                          </div>
                      </form> 
                      <form method="POST" id="resend-otp" action="{{ route('otp.login') }}">
                        @csrf
                        <input  type="hidden" name="mobile" value="{{$mobile}}">
                      </form> 
                      <a href="javascript:void(0)" onclick="document.querySelector('#resend-otp').submit()">Resend OTP to {{$mobile}}</a> <br>
                      <a href="{{route("login")}}">Change Mobile Number</a>
                    @else
                      <h3 class="mb-3">Mobile</h3>
                      <form method="POST" action="{{ route('otp.login') }}">
                        @csrf
                          <div class="form-group">
                              <input id="mobile" type="text" class="form-control @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autocomplete="Email/Phone Number" autofocus>
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

<section class="faq-section w-100 py-5">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h3 class="text-center intro-h2">
                    FAQ about DoCommerce festival 2021
                </h3>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="accordion mt-5" id="festivalFAQ">
                    <div class="card">
                      <div class="card-header" id="headingOne">
                        <h2 class="mb-0">
                          <button class="btn btn-block text-left faq-btn" type="button" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            Q1: When this festival will start?
                          </button>
                        </h2>
                      </div>
                  
                      <div id="collapseOne" class="collapse show" aria-labelledby="headingOne" data-parent="#festivalFAQ">
                        <div class="card-body">
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum nesciunt exercitationem, a iure consequuntur accusamus ex eligendi autem quod blanditiis dolores aut laboriosam ut laborum sequi hic velit sint numquam.
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header" id="headingTwo">
                        <h2 class="mb-0">
                          <button class="btn btn-block text-left faq-btn collapsed" type="button" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                            Q2: When can I view the discounted prices?
                          </button>
                        </h2>
                      </div>
                      <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#festivalFAQ">
                        <div class="card-body">
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum nesciunt exercitationem, a iure consequuntur accusamus ex eligendi autem quod blanditiis dolores aut laboriosam ut laborum sequi hic velit sint numquam.
                        </div>
                      </div>
                    </div>
                    <div class="card">
                      <div class="card-header" id="headingThree">
                        <h2 class="mb-0">
                          <button class="btn btn-block text-left faq-btn collapsed" type="button" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                            Q3: How can I be sure that I get the maximum discounts?
                          </button>
                        </h2>
                      </div>
                      <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#festivalFAQ">
                        <div class="card-body">
                            Lorem, ipsum dolor sit amet consectetur adipisicing elit. Voluptatum nesciunt exercitationem, a iure consequuntur accusamus ex eligendi autem quod blanditiis dolores aut laboriosam ut laborum sequi hic velit sint numquam.
                        </div>
                      </div>
                    </div>
                  </div>
            </div>
        </div>
    </div>
</section>
@endsection
