<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class SendEmailRepository
{
    public function sendEmail(string $url): bool
    {
        $sendEmailConfirmation = Http::get($url);

        if ($sendEmailConfirmation["message"] == "Success") {
            return true;
        }

        return false;
    }
}
