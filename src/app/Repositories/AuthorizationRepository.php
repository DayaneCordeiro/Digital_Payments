<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class AuthorizationRepository
{
    public function autorize(string $url): bool
    {
        $externalAuthorization = Http::get($url);

        if ($externalAuthorization["message"] == "Autorizado") {
            return true;
        }

        return false;
    }
}
