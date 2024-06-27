<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\LoginFormRequest;
use App\Services\PostalCodeServices;
use Illuminate\Http\Client\RequestException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Throwable;

class PostalCodeController extends Controller
{
    private PostalCodeServices $postalCodeServices;

    public function __construct(PostalCodeServices $postalCodeServices)
    {
        $this->postalCodeServices = $postalCodeServices;
    }

    /**
     * @throws RequestException
     * @throws Throwable
     */
    public function index(): JsonResponse
    {
        $listPostalCodes = $this->postalCodeServices->list()->json();

        return response()->json(
            $listPostalCodes,
            Response::HTTP_OK
        );
    }

    /**
     * @throws RequestException
     * @throws Throwable
     */
    public function show(LoginFormRequest $request, string $code): JsonResponse
    {
        $listPostalCodes = $this->postalCodeServices->show(code: $code)->json();

        return response()->json(
            [$listPostalCodes],
            Response::HTTP_OK
        );
    }
}
