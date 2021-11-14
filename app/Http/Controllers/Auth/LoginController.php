<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use App\Services\SendSMSService;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Session as FacadesSession;

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

    public function showLoginForm()
    {
        if (url()->previous() == url('checkout')) {
            session()->put('intended_url', url()->previous());
        }
        return view('auth.login');
    }

    public function otpRequest(Request $request) {
        $request->validate([
            'mobile' => 'required|numeric|digits:11',
        ]);
        $data =  [];
        $session_data = [];
        //check for validitty
        $otp_number = $request->session()->get($request->mobile);
        if ($otp_number) {
            $to_time = strtotime(now());
            $from_time = strtotime($otp_number['set_at']);
            $calculated_time = round(abs($to_time - $from_time) / 60,2);
            if ($calculated_time < 5) {
                if (\Route::current()->getName() == 'login') {
                    return redirect()->back()->withError("Next Request will be available after 5 minuets");
                } else {
                    $data['mobile'] =  $request->mobile;
                    $data['error']  =  "Next Request will be available after 5 minuets";
                    $data['set_at']  = $calculated_time;
                    return view('auth.login', $data);
                }
            }
        }
        
        $data['otp']= $this->random_number(4);
        $session_data['otp'] = $data['otp'];
        $session_data['set_at'] = now();
        $sb = new SendSMSService($request->mobile, "Your DoCommerce Festival login OTP is ".$data['otp'].". Happy shopping!");
        $sb->send();
        $request->session()->put($request->mobile, $session_data);
        
        $data['mobile'] =  $request->mobile;
        $data['set_at'] =  5.00;
        return view('auth.login', $data);
    }
    public function submitOtp(Request $request) {
        $otp_number = $request->session()->get($request->mobile);
        if ($otp_number['otp'] != $request->otp) {
            $data['mobile'] =  $request->mobile;
            $data['error'] =  'Otp Invalid';
            $to_time = strtotime(now());
            $from_time = strtotime($otp_number['set_at']);
            $calculated_time = round(abs($to_time - $from_time) / 60,2);
            $data['set_at']  = $calculated_time;
            return view('auth.login', $data);
        }
        $this->createOrLogin($request->mobile);
        if(session()->has('intended_url') && (session()->get('intended_url') == url("checkout")))
        {
            session()->forget('intended_url');
            return redirect(route('checkout_page'));
        }
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
        session()->forget($mobile_number);
        $this->guard()->login($user);
        return true;
    }

    function random_number($digit = 1): string
    {
        return str_pad(rand(0, pow(10, $digit) - 1), $digit, '0', STR_PAD_LEFT);
    }
}
