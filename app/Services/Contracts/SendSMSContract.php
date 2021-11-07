<?php
namespace App\Services\Contracts;

interface SendSMSContract
{
    public function send(array $mobileNoArray, string $message): object;
}
