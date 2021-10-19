<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/products",
     *     operationId="getProducts",
     *     summary="Get list of products",
     *     @OA\Parameter(
     *         name="page",
     *         in="quey",
     *         description="page number",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="count",
     *         in="query",
     *         description="count of items per page",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/ControllerException"
     *         )
     *     )
     * )
     */
    public function index()
    {
        return response()->json(['data' => Product::all()], 200);
    }

    public function store(Request $request)
    {
        $product = Product::createProduct($request);
        return response()->json(['data' => $product], 200);
    }

    public function update(Request $request, Product $product)
    {
        return response()->json(['data' => $product->updateProduct($request)], 200);
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json([], 204);
    }

    public function show(Product $product)
    {
        return response()->json(['data' => $product]);
    }

    public function changeSubcategory(Request $request, Product $product)
    {
        return $product->changeSubcategory($request->get('subcategory_id'));
    }
}
