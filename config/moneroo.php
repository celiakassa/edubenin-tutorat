<?php

declare(strict_types=1);

return [
    'secret_key' => env('MONEROO_SECRET_KEY'),  // snake_case
    'secretKey' => env('MONEROO_SECRET_KEY'),   // camelCase (ce que cherche le package)
];
