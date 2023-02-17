<?php

use App\Kernel;

require_once dirname(__DIR__).'/vendor/autoload_runtime.php';

return function (array $context) {
    $context['APP_DEBUG'] = 1;
    $context['APP_ENV'] = 'dev';
    return new Kernel($context['APP_ENV'], (bool) $context['APP_DEBUG']);
};
