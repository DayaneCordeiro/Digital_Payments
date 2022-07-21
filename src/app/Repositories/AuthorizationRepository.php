<?php

namespace App\Repositories;

use Illuminate\Support\Facades\Http;

class AuthorizationRepository
{
    const STATUS_APPROVED = 'approved';
    const STATUS_NOT_APPROVED = 'not-approved';

    public function authorize(): bool
    {
        $authorizationUrl = config('services.transaction.authorization');

        $externalAuthorization = Http::get($authorizationUrl);

        if ($externalAuthorization["message"] == "Autorizado") {
            return self::STATUS_APPROVED;
        }

        return self::STATUS_NOT_APPROVED;
    }
}
