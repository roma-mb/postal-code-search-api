<?php

declare(strict_types=1);

namespace App\Connections\Clients\ViaCep;

use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class ViaCepConnection
{
    /** @throws RequestException */
    public static function getList(): Response
    {
        return Http::get(Routes::getAll())->throw();
    }

    /** @throws RequestException */
    public static function getPostalCode(string $code): Response
    {
        return HTTP::get(Routes::find(code: $code))->throw();
    }
}
