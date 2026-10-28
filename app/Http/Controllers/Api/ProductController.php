<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPrice;

// Validación y mensajes de error
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

        return response()->json([
            'producto' => $product,
            'status' => 201
        ], 201);
    }
    
    public function show(Product $product)
    {
        $product->load('currency');

        return response()->json([
            'producto' => $product,
            'status' => 200
        ], 200);
    }

    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());

        return response()->json([
            'message' => 'Producto actualizado exitosamente',
            'producto' => $product,
            'status' => 200
        ], 200);
    }

    public function destroy(Product $product)
    {
        $product->delete();

        return response()->json([
            'message' => 'Producto eliminado correctamente',
            'status' => 200
        ], 200);
    }

    public function showPrices(Product $product)
    {
        $prices = $product->prices()->get();

        return response()->json([
            'producto_id' => $product->id,
            'precios' => $prices,
            'status' => 200
        ], 200);
    }

    public function storePrices(StoreProductPriceRequest $request, Product $product)
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