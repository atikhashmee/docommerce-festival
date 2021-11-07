<?php
namespace App\Services\SMSGateways;

use App\Services\Contracts\SendSMSContract;
use Illuminate\Support\Facades\Http;

class ZamanItSmsService implements SendSMSContract
{
    private $api_key;
    private $senderid;
    private $url;

    /**
     * SslSmsService constructor.
     */
    public function __construct()
    {
        $this->api_key = config('zamanitsms.api_key');
        $this->senderid = config('zamanitsms.senderid');
        $this->url = "http://isms.zaman-it.com/smsapimany";
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

        $response = Http::asForm()->post($this->url, $this->formData($mobileNoArray, $message));
        if ($response->ok()) {
            if ($response->successful()) {
                return (object)['success' => true, 'response' => 'SMS sent! ' . $response->body()];
            } else {
                return (object)['success' => false, 'response' => 'SMS sending failed! ' . $response->body()];
            }
        } else {
            return (object)['success' => false, 'response' => 'Response not OK! ' . $response->body()];
        }
    }

    /**
     * @param array $mobileNoArray
     * @param string $message
     * @return array
     */
    private function formData(array $mobileNoArray, string $message): array
    {
        return [
            'api_key' => $this->api_key,
            'senderid' => $this->senderid,
            'label' => 'OTP',
            'messages' => json_encode(array_map(function ($mobile) use ($message) {
                return [
                    'to' => $mobile,
                    'message' => $message,
                ];
            }, $mobileNoArray))
        ];
    }
}
