<?php

use App\Enumerators\Domain;
use App\Enumerators\ViaCep;

return [
    ViaCep::VIA_CEP->value => [
        Domain::API->value => env('VIA_CEP_API', ''),
    ],
];
