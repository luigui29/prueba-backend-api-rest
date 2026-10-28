<?php

namespace App\Http\Controllers;

use OpenApi\Attributes as OA;

#[OA\Schema(
    schema: "Product",
    title: "Producto",
    description: "Modelo de Producto",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 1),
        new OA\Property(property: "name", type: "string", example: "Monitor"),
        new OA\Property(property: "description", type: "string", example: "Monitor"),
        new OA\Property(property: "price", type: "number", format: "float", example: 250.42),
        new OA\Property(property: "currency_id", type: "integer", example: 1),
        new OA\Property(property: "tax_cost", type: "number", format: "float", example: 40.34),
        new OA\Property(property: "manufacturing_cost", type: "number", format: "float", example: 120.56),
        new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2026-10-27T20:42:24Z"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2026-10-27T20:42:24Z")
    ]
)]
#[OA\Schema(
    schema: "ProductPrice",
    title: "Precio de Producto en Divisa",
    description: "Registro de precio asociado a una divisa específica",
    properties: [
        new OA\Property(property: "id", type: "integer", example: 10),
        new OA\Property(property: "product_id", type: "integer", example: 1),
        new OA\Property(property: "currency_id", type: "integer", example: 2),
        new OA\Property(property: "price", type: "number", format: "float", example: 9125.12),
        new OA\Property(property: "created_at", type: "string", format: "date-time", example: "2026-10-27T20:45:00Z"),
        new OA\Property(property: "updated_at", type: "string", format: "date-time", example: "2026-10-27T20:45:00Z")
    ]
)]
#[OA\Schema(
    schema: "StoreProductBody",
    type: "object",
    required: ["name", "description", "price", "currency_id", "tax_cost", "manufacturing_cost"],
    properties: [
        new OA\Property(property: "name", type: "string", example: "Laptop Gamer"),
        new OA\Property(property: "description", type: "string", example: "Laptop Gamer"),
        new OA\Property(property: "price", type: "number", format: "float", example: 1200.45),
        new OA\Property(property: "currency_id", type: "integer", example: 1),
        new OA\Property(property: "tax_cost", type: "number", format: "float", example: 192.32),
        new OA\Property(property: "manufacturing_cost", type: "number", format: "float", example: 800.14)
    ]
)]
#[OA\Schema(
    schema: "StorePriceBody",
    type: "object",
    required: ["currency_id", "price"],
    properties: [
        new OA\Property(property: "currency_id", type: "integer", example: 2),
        new OA\Property(property: "price", type: "number", format: "float", example: 43800.12)
    ]
)]
class OpenApiSchemas
{
}