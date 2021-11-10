<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\SendSMSService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Contracts\Session\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function otpRequest(Request $request) {
        $request->validate([
            'mobile' => 'required|numeric|digits:11',
        ]);
        $data =  [];
        $data['otp']= $this->random_number(4);
        $sb = new SendSMSService($request->mobile, "Your DoCommerce Festival login OTP is ".$data['otp'].". Happy shopping!");
        $sb->send();
        $request->session()->put($request->mobile, $data['otp']);
        $data['mobile'] =  $request->mobile;
        return view('auth.login', $data);
    }
    public function submitOtp(Request $request) {
        $otp_number = $request->session()->get($request->mobile);
        if ($otp_number != $request->otp) {
            $data['mobile'] =  $request->mobile;
            $data['error'] =  'Otp Invalid';
            return view('auth.login', $data);
        } 

        $this->createOrLogin($request->mobile);
        return redirect(url($this->redirectTo));
    }

    public function createOrLogin($mobile_number) {
        $user = User::where('phone_number', $mobile_number)->first();
        if (!$user) {
            $user = User::create([
                'name' => $mobile_number,
                'email' => $mobile_number."@gmail.com",
                'phone_number' => $mobile_number,
                'password' => Hash::make(12345678),
            ]);
        }
        $this->guard()->login($user);
        return true;
    }

    function random_number($digit = 1): string
    {
        return str_pad(rand(0, pow(10, $digit) - 1), $digit, '0', STR_PAD_LEFT);
    }
}
