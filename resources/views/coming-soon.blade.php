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
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{asset('web_assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('web_assets/css/style.css')}}" />

    <style>
        html, body {
            height: 100vh;
            width: 100%;
            background-color: #000;
        }
        * {
            margin: 0;
            padding:0;
        }
        .cs-wrapper {
            height: 100vh;
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: flex-start;
        }

        .cs-wrapper img {
            max-width: 100%;
            height: 100%;
        }
        .w-100 {
            width: 100%;
            position: absolute;
            bottom: 0;
            left: 0;
        }
        .copyright {
            text-align: center;
            color: #ddd;
            padding:15px 0;
            margin: 0;
            font-family: 'Quicksand', sans-serif;
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

        @media only screen and (min-device-width: 320px) and (max-device-width: 812px) {
            body {
                overflow-x: hidden;
            }
            .cs-wrapper img {
                max-width: 100%;
                height: auto;
            }
        }
    </style>
</head>

<body>
    <div class="cs-wrapper">
        <img src="{{asset('web_assets/images/fastival-coming-soon.png')}}" alt="DoCommerce 11-11 Festival 2021" class="d-none d-md-block">
        <img src="{{asset('web_assets/images/fastival-coming-soon-sm.jpg')}}" alt="DoCommerce 11-11 Festival 2021" class="d-block d-md-none">
    </div>

    <div class="w-100 text-center">
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

    <script>
        $('.participate-btn').click(function () {
            $('#participate-modal').modal('show');
        });
        @if($errors->any())
            $('#participate-modal').modal('show');
        @endif
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