<?php

declare(strict_types=1);

namespace App\Services;

use App\Repository\PostalCodeRepository;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\Client\Response;

class PostalCodeServices
{
    private PostalCodeRepository $postalCodeRepository;

    public function __construct(PostalCodeRepository $postalCodeRepository)
    {
        $this->postalCodeRepository = $postalCodeRepository;
    }

    /**
     * @throws RequestException
     * @throws \Throwable
     */
    public function list(): Response
    {
        return $this->postalCodeRepository->findAll();
    }

    /**
     * @throws RequestException
     * @throws \Throwable
     */
    public function show(string $code): Response
    {
        return $this->postalCodeRepository->find(code: $code);
    }
}
