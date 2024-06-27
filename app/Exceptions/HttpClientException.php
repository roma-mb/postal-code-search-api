<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Enumerators\Exceptions;
use Illuminate\Http\Response;

class HttpClientException extends BuildException
{
    public static function postalCodeNotFound(): BuildException
    {
        return new BuildException(
            [
                'shortMessage' => Exceptions::POSTAL_CODE_NOT_FOUND->value,
                'message' => __('exceptions.' . Exceptions::POSTAL_CODE_NOT_FOUND->value),
                'httpCode' => Response::HTTP_NOT_FOUND,
            ]
        );
    }
}
