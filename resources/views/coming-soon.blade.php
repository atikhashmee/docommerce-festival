<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" href="assets/images/favicon.png" />
    <title>DoCommerce 11-11 Festival 2021</title>
    <meta name="description" content="DoCommerce 11-11 Festival 2021">
    <link rel="canonical" href="" />

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('web_assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('web_assets/css/style.css')}}" />

    <style>
        html, body {
            min-height: 100vh;
            width: 100%;
            background-color: #000;
            font-family: 'Lato', sans-serif;
        }
        * {
            margin: 0;
            padding:0;
        }
        .cs-wrapper {
            height: 64vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .cs-wrapper img {
            max-width: 100%;
            height: 100%;
        }
        
        .copyright {
            text-align: center;
            color: #ddd;
            padding:15px 0;
            margin: 0;
            font-family: 'Lato', sans-serif;
            font-size: 12px;
        }
        .copyright a {
            color: #ddd;
            text-decoration: none;
        }
        .addcart-btn {
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            border-color: rgb(129,55,144);
            /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#813790+0,622d75+100 */
        background: rgb(129,55,144); /* Old browsers */
        background: -moz-linear-gradient(left,  rgba(129,55,144,1) 0%, rgba(98,45,117,1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(left,  rgba(129,55,144,1) 0%,rgba(98,45,117,1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to right,  rgba(129,55,144,1) 0%,rgba(98,45,117,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#813790', endColorstr='#622d75',GradientType=1 ); /* IE6-9 */

        }

        .addcart-btn:is(:hover, :focus) {
            /* Permalink - use to edit and share this gradient: https://colorzilla.com/gradient-editor/#963fa7+0,813790+100 */
        background: rgb(150,63,167); /* Old browsers */
        background: -moz-linear-gradient(left,  rgba(150,63,167,1) 0%, rgba(129,55,144,1) 100%); /* FF3.6-15 */
        background: -webkit-linear-gradient(left,  rgba(150,63,167,1) 0%,rgba(129,55,144,1) 100%); /* Chrome10-25,Safari5.1-6 */
        background: linear-gradient(to right,  rgba(150,63,167,1) 0%,rgba(129,55,144,1) 100%); /* W3C, IE10+, FF16+, Chrome26+, Opera12+, Safari7+ */
        filter: progid:DXImageTransform.Microsoft.gradient( startColorstr='#963fa7', endColorstr='#813790',GradientType=1 ); /* IE6-9 */
            box-shadow: none;
            color: #fff !important;
            border-color: rgb(129,55,144);
        }

        #participate-modal .modal-header {
            border-bottom: none;
            padding-bottom: 0;
        }

        .login-wrapper {
		    border: 1px solid rgba(0, 0, 0, 0.05);
		    margin-bottom: 30px;
		}

        /* countdown */

    .flipper {
  color: #333;
  display: block;
  font-size: 50px;
  line-height: 100%;
  padding: 0;
  margin: 0;
  font-size: 50px !important;
  height: 65px;
}
.flipper.flipper-invisible {
  font-size: 0px !important;
}

.flipper-group {
  position: relative;
  white-space: nowrap;
  display: block;
  float: left;
  padding: 0;
  margin: 0;
}
.flipper-group label {
  position: absolute;
  color: #ffea3f;
  font-size: 30%;
  top: 100%;
  line-height: 1em;
  left: 50%;
  -webkit-transform: translate(-50%, 0);
          transform: translate(-50%, 0);
  text-align: center;
  padding-top: .5em;
}

.flipper-digit {
  white-space: nowrap;
  position: relative;
  padding: 0;
  margin: 0;
  display: inline-block;
  float: left;
    height: 1.2em;
  overflow-y: hidden;
}
.flipper-digit span {
  font-size: 25%;
}

.flipper-delimiter {
  white-space: nowrap;
  display: block;
  float: left;
  padding: 0;
  margin: 0;
  color: #ffea3f;
  min-width: .1em;
  white-space: nowrap;
  display: block;
  padding-top: 0.1em;
  padding-bottom: 0.1em;
  line-height: 1em;
}

.flipper-group.flipper-delimiter {
  padding-left: 6px;
  padding-right: 6px;
}

.digit-face {
  display: block;
  visibility: hidden;
  position: relative;
  border-radius: 0.1em;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 8;
  padding-top: 0.1em;
  padding-bottom: 0.1em;
  padding-left: 0.1em;
  padding-right: 0.1em;
  box-sizing: border-box;
  text-align: center;
}

.digit-next {
  display: block;
  position: relative;
  border-radius: 0.1em;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 8;
  height: 1.2em;
  background: #ffea3f;
  padding-top: 0.1em;
  padding-bottom: 0.1em;
  padding-left: 0.1em;
  padding-right: 0.1em;
  box-sizing: border-box;
  text-align: center;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
}

.digit-top {
  z-index: 10;
  top: 0;
  left: 0;
  right: 0;
  height: 50%;
  -webkit-backface-visibility: hidden;
          backface-visibility: hidden;
  pointer-events: none;
  overflow: hidden;
  position: absolute;
  background: #ffea3f;
  padding-top: 0.1em;
  padding-bottom: 0;
  padding-left: 0.1em;
  padding-right: 0.1em;
  border-top-left-radius: 0.1em;
  border-top-right-radius: 0.1em;
  box-sizing: border-box;
  text-align: center;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  transition: background 0s linear, -webkit-transform 0s linear;
  transition: transform 0s linear, background 0s linear;
  transition: transform 0s linear, background 0s linear, -webkit-transform 0s linear;
  -webkit-transform-origin: 0 0.6em 0 !important;
          transform-origin: 0 0.6em 0 !important;
  -webkit-transform-style: preserve-3d !important;
          transform-style: preserve-3d !important;
  z-index: 20;
}
.digit-top.r {
  transition: background 0.2s linear, -webkit-transform 0.2s linear;
  transition: transform 0.2s linear, background 0.2s linear;
  transition: transform 0.2s linear, background 0.2s linear, -webkit-transform 0.2s linear;
  -webkit-transform: rotateX(90deg);
          transform: rotateX(90deg);
  background: #efb61c;
}

.digit-top2 {
  visibility: hidden;
  position: absolute;
  height: 50%;
  left: 0;
  right: 0;
  background: #efb61c;
  transition: -webkit-transform 0.2s linear;
  transition: transform 0.2s linear;
  transition: transform 0.2s linear, -webkit-transform 0.2s linear;
  line-height: 0em !important;
  top: 50% !important;
  bottom: auto !important;
  padding-top: 0;
  padding-bottom: 0.1em;
  padding-left: 0.1em;
  padding-right: 0.1em;
  border-bottom-left-radius: 0.1em;
  border-bottom-right-radius: 0.1em;
  overflow: hidden;
  text-align: center;
  -webkit-user-select: none;
     -moz-user-select: none;
      -ms-user-select: none;
          user-select: none;
  transition: background 0s linear, -webkit-transform 0s linear;
  transition: transform 0s linear, background 0s linear;
  transition: transform 0s linear, background 0s linear, -webkit-transform 0s linear;
  -webkit-transform: rotateX(-90deg);
          transform: rotateX(-90deg);
  -webkit-transform-style: preserve-3d !important;
          transform-style: preserve-3d !important;
  -webkit-transform-origin: 0 0 0 !important;
          transform-origin: 0 0 0 !important;
  z-index: 20;
}
.digit-top2.r {
  visibility: visible;
  transition: background 0.2s linear 0.2s, -webkit-transform 0.2s linear 0.2s;
  transition: transform 0.2s linear 0.2s, background 0.2s linear 0.2s;
  transition: transform 0.2s linear 0.2s, background 0.2s linear 0.2s, -webkit-transform 0.2s linear 0.2s;
  -webkit-transform: rotateX(0deg);
          transform: rotateX(0deg);
  background: #ffea3f;
}

.digit-bottom {
  -webkit-backface-visibility: hidden;
          backface-visibility: hidden;
  pointer-events: none;
  position: absolute;
  overflow: hidden;
  background: #ffea3f;
  height: 50%;
  left: 0;
  right: 0;
  bottom: 0;
  z-index: 9;
  line-height: 0em;
  padding-top: 0;
  padding-bottom: 0.1em;
  padding-left: 0.1em;
  padding-right: 0.1em;
  border-bottom-left-radius: 0.1em;
  border-bottom-right-radius: 0.1em;
  box-sizing: border-box;
  text-align: center;
  transition: none;
}
.digit-bottom.r {
  transition: background 0.2s linear;
  background: #efb61c;
}

.flipper-digit:after {
  content: "";
  position: absolute;
  height: 2px;
  background: rgba(0, 0, 0, 0.5);
  top: 50%;
  display: block;
  z-index: 30;
  left: 0;
  right: 0;
}

.flipper-dark {
  color: #ffea3f;
}
.flipper-dark .flipper-delimiter {
  color: #333;
}
.flipper-dark .digit-next {
  background: #333;
}
.flipper-dark .digit-top {
  background: #333;
}
.flipper-dark .digit-top.r {
  background: black;
}
.flipper-dark .digit-top2 {
  background: black;
}
.flipper-dark .digit-top2.r {
  background: #333;
}
.flipper-dark .digit-bottom {
  background: #333;
}

.flipper-dark-labels .flipper-group label {
  color: #333;
}

.applyDiv {
    margin-top: 65px;
}

.addcart-btn {
    font-weight: 400;
}

@media only screen and (min-device-width: 320px) and (max-device-width: 812px) {
    body {
        overflow-x: hidden;
    }
    .cs-wrapper img {
        max-width: 100%;
        height: auto;
    }

    .flipper {
        font-size: 40px !important;
        height: 54px;
    }
    .flipper-group.flipper-delimiter {
        padding-left: 4px;
        padding-right: 4px;
    }
    .flipper-group label {
        font-size: 40%;
    }
}
    </style>
</head>

<body>
    <div class="cs-wrapper">
        <img src="{{asset('web_assets/images/fastival-coming-soon.png')}}" alt="DoCommerce 11-11 Festival 2021" class="d-none d-md-block">
        <img src="{{asset('web_assets/images/fastival-coming-soon-sm.jpg')}}" alt="DoCommerce 11-11 Festival 2021" class="d-block d-md-none">
    </div>

    <div class="flipper d-flex justify-content-center" data-reverse="true" data-datetime="2021-11-11 00:00:00" data-template="dd|HH|ii|ss" data-labels="Days|Hours|Minutes|Seconds" id="myFlipper"></div>

    <div class="w-100 text-center applyDiv">
        <button class="btn btn-success addcart-btn participate-btn">Apply to Participate</button>
        <p class="copyright">Copyright &copy; 2021 <a href="https://docommerce.com/">DoCommerce Ltd</a></p>
    </div>


    <!--product details popup -->
    <div class="modal fade" id="participate-modal" tabindex="-1" aria-labelledby="participate-modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div class="login-wrapper shadow-sm p-4 rounded bg-white">
                                <h3 class="mb-3">Participate on DoCommerce 11-11 Festival</h3>
                                <form method="POST" action="{{ route('store.perticipant') }}">
                                    @csrf                                   
                                    <div class="form-group">
                                        <input type="text"  value="{{old('name')}}" class="form-control" name="name" placeholder="Enter Your Name">
                                        @error('name')
                                            <span class="text-danger">{{$message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group">
                                        <input type="email"  value="{{old('email')}}" class="form-control" name="email" placeholder="Enter Your Email">
                                        @error ('email')
                                            <span class="text-danger">{{$message }}</span>
                                        @enderror
                                    </div>
        
                                    <div class="form-group">
                                        <input type="text"  value="{{old('phone_number')}}" class="form-control" name="phone_number" placeholder="Enter Phone Number">
                                        @error('phone_number')
                                            <span class="text-danger">{{$message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="text"  value="{{old('business_name')}}" class="form-control" name="business_name" placeholder="Enter Business Name">
                                        @error ('business_name')
                                            <span class="text-danger">{{$message }}</span>
                                        @enderror
                                    </div>

                                    <div class="form-group">
                                        <input type="text" value="" class="form-control" name="business_address" placeholder="Enter Business Address">
                                    </div>
                                    <input type="hidden" value="2" name="store_id">
                                    @if (env('RECAPTCHA_ENABLE'))
                                        <div class="form-group has-feedback">
                                            @if(config('services.recaptcha.sitekey'))
                                                <div class="g-recaptcha" data-sitekey="{{config('services.recaptcha.sitekey')}}"></div>
                                            @endif
                                            @error('g-recaptcha-response')
                                                <span class="invalid-feedback d-block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    @endif
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-primary addcart-btn btn-block" name="apply">Apply to Participate</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </div>

    <script src="{{asset('web_assets/js/jquery.min.js')}}"></script>
    <script src="{{asset('web_assets/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{asset('web_assets/js/jquery.flipper-responsive.js')}}"></script>

    <script>
        $('.participate-btn').click(function () {
            $('#participate-modal').modal('show');
        });
        @if($errors->any())
            $('#participate-modal').modal('show');
        @endif

        jQuery(function ($) {
            $('#myFlipper').flipper('init');
        });
    </script>
    <script src="{{ asset('web_assets/iCheck/icheck.min.js') }}"></script>
    <script src="https://www.google.com/recaptcha/api.js"></script>
    <script>
        $(function () {
            $('input').iCheck({
                checkboxClass: 'icheckbox_square-blue',
                radioClass: 'iradio_square-blue',
                increaseArea: '20%' /* optional */
            });
        </script>
</body>

</html>