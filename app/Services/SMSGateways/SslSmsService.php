<?php
namespace App\Services\SMSGateways;

use App\Services\Contracts\SendSMSContract;
use Illuminate\Support\Facades\Http;

class SslSmsService implements SendSMSContract
{
    private $user;
    private $pass;
    private $sid;
    private $url;

    /**
     * SslSmsService constructor.
     */
    public function __construct()
    {
        $this->user = config('sslsms.user');
        $this->pass = config('sslsms.pass');
        $this->sid = config('sslsms.sid');
        $this->url = "http://sms.sslwireless.com/pushapi/dynamic/server.php";
    }

    /**
     * Send the message to desired number
     *
     * @param array $mobileNoArray
     * @param string $message
     * @return object
     */
    public function send(array $mobileNoArray, string $message): object
    {
        $mobileNoArray = array_map(function ($mobile) {
            return $mobile;
        }, $mobileNoArray);
        $key = time();
        $response = Http::asForm()->post($this->url, [
            'user' => $this->user,
            'pass' => $this->pass,
            'sid' => $this->sid,
            'sms' => array_map(function ($mobile) use ($message, $key) {
                return array($mobile, $message, $key);
            }, $mobileNoArray)
        ]);
        $result = $response->body();
        $parsed_result = simplexml_load_string($result);

        if ($parsed_result->SMSINFO->REFERENCEID) {
            return json_decode(json_encode([
                'status' => 'success',
                'result' => 'sms sent',
                'phone' => join(',', $mobileNoArray),
                'message' => $message,
                'reference_no' => $parsed_result->SMSINFO->CSMSID,
                'ssl_reference_no' => $parsed_result->SMSINFO->REFERENCEID,
                'datetime' => date('Y-m-d H:ia')
            ]));
        } else if ($parsed_result->SMSINFO->SMSVALUE) {
            return json_decode(json_encode([
                'status' => 'failed',
                'result' => 'invalid mobile or text',
                'phone' => join(',', $mobileNoArray),
                'message' => $message,
                'reference_no' => '',
                'ssl_reference_no' => '',
                'datetime' => date('Y-m-d H:ia')
            ]));
        } else if ($parsed_result->SMSINFO->MSISDNSTATUS) {
            return json_decode(json_encode([
                'status' => 'failed',
                'result' => 'invalid mobile no',
                'phone' => join(',', $mobileNoArray),
                'message' => $message,
                'reference_no' => '',
                'ssl_reference_no' => '',
                'datetime' => date('Y-m-d H:ia')
            ]));
        } else {
            return json_decode(json_encode([
                'status' => 'failed',
                'result' => 'invalid credentials',
                'phone' => join(',', $mobileNoArray),
                'message' => $message,
                'reference_no' => '',
                'ssl_reference_no' => '',
                'datetime' => date('Y-m-d H:ia')
            ]));
        }
    }
}
