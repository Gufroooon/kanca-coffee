<?php
require __DIR__.'/vendor/autoload.php';

$m = new App\Http\Middleware\RoleMiddleware;
$ref = new ReflectionMethod($m, 'handle');
echo $ref->getParameters()[2]->isVariadic() ? "variadic\n" : "not variadic\n";
