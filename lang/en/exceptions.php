<?php

use App\Enumerators\Exceptions;

return [
    Exceptions::NOT_FOUND->value => 'Not found',
    Exceptions::POSTAL_CODE_NOT_FOUND->value => 'Postal code not found, check digits.',
];
