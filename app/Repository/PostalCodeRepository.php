<?php

declare(strict_types=1);

namespace App\Repository;

use App\Connections\Clients\ViaCep\ViaCepConnection;
use App\Exceptions\HttpClientException;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;

class PostalCodeRepository
{
    /**
     * @throws RequestException
     * @throws \Throwable
     */
    public function findAll(): Response
    {
        $codes = ViaCepConnection::getList();

        throw_unless($codes->json(), HttpClientException::postalCodeNotFound());

        return $codes;
    }

    /**
     * @throws RequestException
     * @throws \Throwable
     */
    public function find(string $code): Response
    {
        $codes = ViaCepConnection::getPostalCode(code: $code);
        $content = $codes->json();
        $hasError = empty($content) || ($content['erro'] ?? false);

        throw_if($hasError, HttpClientException::postalCodeNotFound());

        return $codes;
    }
}
