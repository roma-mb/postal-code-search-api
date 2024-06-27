<?php

declare(strict_types=1);

namespace App\Enumerators;

enum Exceptions: string
{
    case NOT_FOUND = 'notFound';
    case UNAUTHORIZED = 'unauthorized';
    case POSTAL_CODE_NOT_FOUND = 'postalCodeNotFound';
}
