<?php

declare(strict_types=1);

namespace App\Services\Patterns;

use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Artisan;
use Random\RandomException;

class HelpersFacade
{
    /** @throws RandomException */
    public function generateToken(User $user): string
    {
        Artisan::all();
        $now = Carbon::now();
        $secretKey  = env('JWT_KEY', '');
        $servername  = env('APP_NAME', '');

        $data = [
            'iat'  => $now->getTimestamp(),
            'jti'  => base64_encode(random_bytes(16)),
            'iss'  => $servername,
            'nbf'  => $now->getTimestamp(),
            'exp'  => $now->addMinutes(30)->getTimestamp(),
            'data' => [
                'userId' => $user->id,
            ],
        ];

        return JWT::encode(
            $data,
            $secretKey,
            'HS512'
        );
    }

    public function decodeRawJWT(): ?array
    {
        $secretKey  = env('JWT_KEY', '');
        preg_match('/Bearer\s(\S+)/', $_SERVER['HTTP_AUTHORIZATION'] ?? '', $matches);

        $token = JWT::decode($matches[1] ?? '', new Key($secretKey, 'HS512'));

        return User::select(['name', 'email'])->find($token->data->userId)?->toArray();
    }
}
