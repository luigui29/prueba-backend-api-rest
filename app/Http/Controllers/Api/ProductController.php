<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductPrice;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::with('currency')->get();

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

    public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Producto no encontrado',
                'status' => 404
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'currency_id' => 'sometimes|integer|exists:divisas,id',
            'tax_cost' => 'sometimes|numeric|min:0',
            'manufacturing_cost' => 'sometimes|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $product->update($request->all());

        return response()->json([
            'message' => 'Producto actualizado exitosamente',
            'producto' => $product,
            'status' => 200
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

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

    public function storePrices(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Producto no encontrado',
                'status' => 404
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'currency_id' => 'required|integer|exists:divisas,id',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Error de validación al registrar el precio',
                'errors' => $validator->errors(),
                'status' => 400
            ], 400);
        }

        $productPrice = ProductPrice::updateOrCreate(
            [
                'product_id' => $product->id,
                'currency_id' => $request->currency_id
            ],
            [
                'price' => $request->price
            ]
        );

        return response()->json([
            'message' => 'Precio en divisa registrado exitosamente',
            'precio' => $productPrice,
            'status' => 201
        ], 201);
    }
}