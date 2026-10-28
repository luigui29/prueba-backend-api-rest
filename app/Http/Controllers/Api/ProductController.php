<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Http\Requests\StoreProductPriceRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        // Retornar mensaje si no se encontraron productos
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

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        // Retornar si la validación falla
        if (!$product) {
            return response()->json([
                'message' => 'Error al crear el producto',
                'status' => 500
            ], 500);
        }

        return response()->json([
            'producto' => $product,
            'status' => 201
        ], 201);
    }

    public function show($id)
    {
        $product = Product::with('currency')->find($id);

        // Retornar si el producto no se encuentra en la BD
        if (!$product) {
            return response()->json([
                'message' => 'Producto no encontrado',
                'status' => 404
            ], 404);
        }

        return response()->json([
            'producto' => $product,
            'status' => 200
        ], 200);
    }

    public function update(UpdateProductRequest $request, $id)
    {
        $product = Product::find($id);

        // Retornar si el producto no se encuentra en la BD
        if (!$product) {
            return response()->json([
                'message' => 'Producto no encontrado',
                'status' => 404
            ], 404);
        }

        $product->update($request->validated());

        return response()->json([
            'message' => 'Producto actualizado exitosamente',
            'producto' => $product,
            'status' => 200
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        // Retornar si el producto no se encuentra en la BD
        if (!$product) {
            return response()->json([
                'message' => 'Producto no encontrado',
                'status' => 404
            ], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Producto eliminado correctamente',
            'status' => 200
        ], 200);
    }

    public function showPrices($id)
    {
        $product = Product::find($id);

        // Retornar si el producto no se encuentra en la BD
        if (!$product) {
            return response()->json([
                'message' => 'Producto no encontrado',
                'status' => 404
            ], 404);
        }

        $prices = ProductPrice::with('currency')
            ->where('product_id', $id)
            ->get();

        return response()->json([
            'producto_id' => $product->id,
            'precios' => $prices,
            'status' => 200
        ], 200);
    }

    public function storePrices(StoreProductPriceRequest $request, $id)
    {
        $product = Product::find($id);

        // Retornar si el producto no se encuentra en la BD
        if (!$product) {
            return response()->json([
                'message' => 'Producto no encontrado',
                'status' => 404
            ], 404);
        }

        $productPrice = ProductPrice::updateOrCreate(
            [
                'product_id' => $product->id,
                'currency_id' => $request->validated('currency_id')
            ],
            [
                'price' => $request->validated('price')
            ]
        );

        return response()->json([
            'message' => 'Precio en divisa registrado exitosamente',
            'precio' => $productPrice,
            'status' => 201
        ], 201);
    }
}