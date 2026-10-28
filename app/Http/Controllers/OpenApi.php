<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Info(
    version: "1.0.0",
    title: "API REST de Productos (Prueba Backend)",
)]
#[OA\Server(
    url: "http://localhost:8000"
)]
class OpenApi
{
}