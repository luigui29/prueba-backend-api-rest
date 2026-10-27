<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;

use Illuminate\Http\Request;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();

        if ($products->isEmpty()) {
            $data = [
                'message' => 'No se encontraron productos registrados',
                'status' => 200
            ];

            return response()->json($data, 200);
        }

        $data = [
            'productos' => $products,
            'status' => 200
        ];

        return response()->json($data, 200);
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());

        // Retornar error al fallar creación
        if (!$product) {
            $data = [
                'message' => 'Error al crear el producto',
                'status' => 500
            ];

            return response()->json($data, 500);
        }

        $data = [
            'producto' => $product,
            'status' =>  201
        ];

        return response()->json($data, 201);
    }

    public function show()
    {}

    public function update()
    {}

    public function destroy()
    {}

    public function showPrices()
    {}

    public function storePrices()
    {}
}
