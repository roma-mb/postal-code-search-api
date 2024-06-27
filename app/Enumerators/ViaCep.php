<?php

declare(strict_types=1);

namespace App\Enumerators;

enum ViaCep: string
{
    case CONFIG_FILE = 'integrations';
    case VIA_CEP = 'viacep';

    public static function getPathApiURI(): string
    {
        return self::CONFIG_FILE->value . '.' . self::VIA_CEP->value . '.' . Domain::API->value;
    }
}
