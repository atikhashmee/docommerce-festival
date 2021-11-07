<?php
namespace App\Services;

use App\Services\SMSGateways\ZamanItSmsService;
use Illuminate\Support\Facades\Log;

class SendSMSService
{
    private $number;
    private $message;
    private $smsService;

    public function __construct($number, $message)
    {
        $this->number = $number;
        $this->message = $message;
        $this->smsService = new ZamanItSmsService();
    }



    /**
     * Fire API using Message
     *
     * @param string $message
     * @return object
     */
    private function fireApi(string $message): object
    {
        Log::info("Send Message: $message");

        if (config('developer.sms_api') == 'off') {
            return json_decode(json_encode([
                'status' => 'success',
            ]));
        }
        return $this->smsService->send([$this->number], $message);
    }

    /**
     * Send SMS using Plain Text Message
     *
     * @return object
     */
    public function send()
    {
        return $this->fireApi($this->message);
    }

    /**
     * Send SMS using SimpleMessage Instance
     *
     * @return object
     */
    public function sendSimpleMessage()
    {
        $txt = '';
        foreach ($this->message->introLines as $line) {
            $txt .= $line . "\n";
        }

        return $this->fireApi($txt);
    }
}
