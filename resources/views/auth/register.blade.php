@extends('layouts.app')

@section('content')
<section class="w-100 bg-light">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                      <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                      <li class="breadcrumb-item active" aria-current="page">Register</li>
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
                    <h3 class="mb-3">Create an Account</h3>

                    <form method="POST" action="" novalidate="">
                        <input type="hidden" name="_token" value="dfToBNZ5W0f67H0RRZfaZk0WiZyLC4xHZhktl4aF">                                    
                        <div class="form-group">
                            <input type="text" required="" value="" class="form-control" name="name" placeholder="Enter Your Name">
                        </div>
                        <div class="form-group">
                            <input type="email" required="" value="" class="form-control" name="email" placeholder="Enter Your Email">
                        </div>

                        <div class="form-group">
                            <input type="text" required="" value="" class="form-control" name="phone_number" placeholder="Enter Phone Number">
                        </div>

                        <div class="form-group">
                            <input class="form-control" required="" type="password" name="password" placeholder="Password">
                        </div>
                        <div class="form-group">
                            <input class="form-control" required="" type="password" name="password_confirmation" placeholder="Confirm Password">
                        </div>
                        <div class="login_footer form-group">
                            <div class="chek-form">
                                <div class="custome-checkbox">
                                    <input class="form-check-input" required="" type="checkbox" id="exampleCheckbox2" name="agree_terms_and_policy" value="1">
                                    <label class="form-check-label" for="exampleCheckbox2"><a href="http://localhost/docommerce-script/public/terms-conditions">I agree to terms &amp; Policy.</a></label>
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="2" name="store_id">
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block" name="register">Register</button>
                        </div>
                    </form>

                    <div class="different_login">
                        <span> or</span>
                    </div>

                    <div class="form-note text-center">Already have an account? <a href="{{route('login')}}">Sign in now</a></div>
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
