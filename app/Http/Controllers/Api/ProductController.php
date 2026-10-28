<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

//Validación
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\StoreProductPriceRequest;

use Illuminate\Http\JsonResponse;

//Documentacion en Swagger
use OpenApi\Attributes as OA;

class ProductController extends Controller
{
    #[OA\Get(
        path: "/api/products",
        operationId: "getProductsList",
        description: "Devuelve la lista general de productos registrados.",
        summary: "Obtener listado de productos",
        tags: ["Productos"]
    )]
    #[OA\Response(
        response: 200,
        description: "Operación exitosa",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(
                    property: "productos",
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/Product")
                ),
                new OA\Property(property: "status", type: "integer", example: 200)
            ]
        )
    )]
    public function index(): JsonResponse
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron productos registrados',
                'status' => 200
            ], 200);
        }

        return response()->json([
            'productos' => $products,
            'status' => 200
        ], 200);
    }

    #[OA\Post(
        path: "/api/products",
        operationId: "storeProduct",
        description: "Crea un producto en la base de datos y lo asocia a su divisa base.",
        summary: "Registrar un nuevo producto",
        tags: ["Productos"]
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(ref: "#/components/schemas/StoreProductBody")
    )]
    #[OA\Response(
        response: 201,
        description: "Producto creado exitosamente",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "producto", ref: "#/components/schemas/Product"),
                new OA\Property(property: "status", type: "integer", example: 201)
            ]
        )
    )]
    #[OA\Response(
        response: 422,
        description: "Error de validación de datos de entrada"
    )]
    public function store(StoreProductRequest $request): JsonResponse
    {
        $product = Product::create($request->validated());

        return response()->json([
            'producto' => $product,
            'status' => 201
        ], 201);
    }

    #[OA\Get(
        path: "/api/products/{product}",
        operationId: "getProductById",
        description: "Devuelve la información de un producto específico mediante su ID.",
        summary: "Obtener detalles de un producto",
        tags: ["Productos"]
    )]
    #[OA\Parameter(
        name: "product",
        description: "ID del Producto",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Response(
        response: 200,
        description: "Operación exitosa",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "producto", ref: "#/components/schemas/Product"),
                new OA\Property(property: "status", type: "integer", example: 200)
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: "Producto no encontrado"
    )]
    public function show(Product $product): JsonResponse
    {
        $product->load('currency');

        return response()->json([
            'producto' => $product,
            'status' => 200
        ], 200);
    }

    #[OA\Put(
        path: "/api/products/{product}",
        operationId: "updateProduct",
        description: "Actualiza parcialmente o totalmente un registro de producto.",
        summary: "Actualizar un producto existente",
        tags: ["Productos"]
    )]
    #[OA\Parameter(
        name: "product",
        description: "ID del Producto",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(ref: "#/components/schemas/StoreProductBody")
    )]
    #[OA\Response(
        response: 200,
        description: "Producto actualizado exitosamente",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "message", type: "string", example: "Producto actualizado exitosamente"),
                new OA\Property(property: "producto", ref: "#/components/schemas/Product"),
                new OA\Property(property: "status", type: "integer", example: 200)
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: "Producto no encontrado"
    )]
    #[OA\Response(
        response: 422,
        description: "Error de validación"
    )]
    public function update(UpdateProductRequest $request, Product $product): JsonResponse
    {
        $product->update($request->validated());

        return response()->json([
            'message' => 'Producto actualizado exitosamente',
            'producto' => $product,
            'status' => 200
        ], 200);
    }

    #[OA\Delete(
        path: "/api/products/{product}",
        operationId: "deleteProduct",
        description: "Elimina de la base de datos el registro del producto recibido.",
        summary: "Eliminar un producto",
        tags: ["Productos"]
    )]
    #[OA\Parameter(
        name: "product",
        description: "ID del Producto",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Response(
        response: 200,
        description: "Producto eliminado correctamente",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "message", type: "string", example: "Producto eliminado correctamente"),
                new OA\Property(property: "status", type: "integer", example: 200)
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: "Producto no encontrado"
    )]
    public function destroy(Product $product): JsonResponse
    {
        $product->delete();

        return response()->json([
            'message' => 'Producto eliminado correctamente',
            'status' => 200
        ], 200);
    }

    #[OA\Get(
        path: "/api/products/{product}/prices",
        operationId: "getProductPrices",
        description: "Retorna el listado de precios registrados para el producto filtrado.",
        summary: "Consultar precios de un producto en distintas divisas",
        tags: ["Productos"]
    )]
    #[OA\Parameter(
        name: "product",
        description: "ID del Producto",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\Response(
        response: 200,
        description: "Operación exitosa",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "producto_id", type: "integer", example: 1),
                new OA\Property(
                    property: "precios",
                    type: "array",
                    items: new OA\Items(ref: "#/components/schemas/ProductPrice")
                ),
                new OA\Property(property: "status", type: "integer", example: 200)
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: "Producto no encontrado"
    )]
    public function showPrices(Product $product): JsonResponse
    {
        $prices = $product->prices()->get();

        return response()->json([
            'producto_id' => $product->id,
            'precios' => $prices,
            'status' => 200
        ], 200);
    }

    #[OA\Post(
        path: "/api/products/{product}/prices",
        operationId: "storeProductPrice",
        description: "Registra un precio específico en la tabla pivote de productos y divisas.",
        summary: "Asignar o actualizar el precio de un producto en una divisa",
        tags: ["Productos"]
    )]
    #[OA\Parameter(
        name: "product",
        description: "ID del Producto",
        in: "path",
        required: true,
        schema: new OA\Schema(type: "integer")
    )]
    #[OA\RequestBody(
        required: true,
        content: new OA\JsonContent(ref: "#/components/schemas/StorePriceBody")
    )]
    #[OA\Response(
        response: 201,
        description: "Precio registrado exitosamente",
        content: new OA\JsonContent(
            properties: [
                new OA\Property(property: "message", type: "string", example: "Precio en divisa registrado exitosamente"),
                new OA\Property(property: "precio", ref: "#/components/schemas/ProductPrice"),
                new OA\Property(property: "status", type: "integer", example: 201)
            ]
        )
    )]
    #[OA\Response(
        response: 404,
        description: "Producto no encontrado"
    )]
    #[OA\Response(
        response: 422,
        description: "Error de validación"
    )]
    public function storePrices(StoreProductPriceRequest $request, Product $product): JsonResponse
    {
        $productPrice = $product->prices()->updateOrCreate(
            ['currency_id' => $request->validated('currency_id')],
            ['price' => $request->validated('price')]
        );

        return response()->json([
            'message' => 'Precio en divisa registrado exitosamente',
            'precio' => $productPrice,
            'status' => 201
        ], 201);
    }
}