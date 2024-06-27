<?php

declare(strict_types=1);

namespace App\Connections\Clients\ViaCep;

use App\Enumerators\ViaCep;

class Routes
{
    private const ALL = 'SP/Barueri/Alphaville/json/';

    private const FIND = '/json/';

    public static function getAll(): string
    {
        return self::getURI() . self::ALL;
    }

    public static function find(string $code): string
    {
        return self::getURI() . $code . self::FIND;
    }

    private static function getURI()
    {
        return config(ViaCep::getPathApiURI(), '');
    }
}
