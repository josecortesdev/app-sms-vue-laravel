<?php

namespace App\Services;

interface SmsServiceInterface
{
    public function send(array $phones, string $message): array;
}