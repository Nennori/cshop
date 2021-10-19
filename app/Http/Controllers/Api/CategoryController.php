<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/",
     *     operationId="register",
     *     summary="Register new user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         description="Pass user credentials",
     *         @OA\JsonContent(
     *             required={"name", "surname", "email", "password", "password_confirmation"},
     *             @OA\Property(
     *                 property="name",
     *                 description="name of the new user",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="surname",
     *                 description="surname of the new user",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="patronymic",
     *                 description="patronymic of the new user",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="about",
     *                 description="Additional info about user",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="email",
     *                 description="email of the new user",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 description="password of the new user",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="password_confirmation",
     *                 description="confirmation of user's password",
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="User registered successfully"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/ControllerException"
     *         )
     *     )
     * )
     * @param RegistrationRequest $request
     * @return JsonResponse
     */

    public function index(RegistrationRequest $request)
    {
        return response()->json(['data' => Category::all()], 200);
    }

    public function store(Request $request)
    {
        return response()->json(['data' => Category::createCategory($request)], 200);
    }

    public function update(Request $request, Category $category)
    {
        $category->updateCategory($request);
        return response()->json(['data' => $category], 200);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([], 204);
    }

    public function show(Category $category)
    {
        return response()->json(['data' => $category]);
    }
}
