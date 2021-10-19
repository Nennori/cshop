<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegistrationRequest;
use App\Models\User;
use App\Services\TokenService;
use App\Services\ValidationService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    /**
     * @OA\SecurityScheme(
     *        securityScheme="bearerAuth",
     *        type="http",
     *        in="header",
     *        bearerFormat="JWT",
     *        scheme="bearer"
     *    )
     */
    private $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    /**
     * @OA\Post(
     *     path="/api/register",
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
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegistrationRequest $request)
    {
        User::createUser($request->only(['name', 'surname', 'patronymic', 'email', 'password']));
        return response()->json([], 204);
    }

    /**
     * @OA\Post(
     *     path="/api/login",
     *     operationId="login",
     *     summary="Login user",
     *     tags={"Authentication"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Pass user credentials",
     *         @OA\JsonContent(
     *             required={"email", "password"},
     *             @OA\Property(
     *                 property="email",
     *                 description="email of the new user",
     *                 type="string"
     *             ),
     *             @OA\Property(
     *                 property="password",
     *                 description="password of the new user",
     *                 type="string"
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="User logged in successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 title="data",
     *                 description="Response data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(
     *                         property="access_token",
     *                         title="access token",
     *                         description="Access token",
     *                         type="string",
     *                     ),
     *                     @OA\Property(
     *                         property="refresh_token",
     *                         title="refresh token",
     *                         description="Refresh token",
     *                         type="string",
     *                     )
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response="401",
     *         description="Unauthorized",
     *         @OA\JsonContent(
     *             ref="#/components/schemas/ControllerException"
     *         ),
     *     )
     * )
     * @param Request $request
     * @return JsonResponse
     */
    public function login(Request $request): JsonResponse
    {
        ValidationService::validateAuthorizedUser($request->only('email', 'password'));
        return $this->respondWithTokens($this->tokenService->generateTokens(auth()->user()));
    }



    /**
     * @OA\Delete(
     *     path="/api/logout",
     *     operationId="logout",
     *     summary="Logout user",
     *     description="To logout user you need to send refresh_token",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {} }},
     *     @OA\Response(
     *         response="204",
     *         description="User is logged out"
     *     )
     * )
     */
    public function logout()
    {
        auth()->parseToken()->invalidate(true);
        return response()->json([], 204);
    }

    /**
     * @OA\Post(
     *     path="/api/refresh",
     *     operationId="refresh",
     *     summary="Refresh user's access token",
     *     tags={"Authentication"},
     *     security={{"bearerAuth": {} }},
     *     @OA\Response(
     *         response="200",
     *         description="Tokens refreshed successfully",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="data",
     *                 title="data",
     *                 description="Response data",
     *                 type="array",
     *                 @OA\Items(
     *                     @OA\Property(
     *                         property="access_token",
     *                         title="access token",
     *                         description="Access token",
     *                         type="string",
     *                     ),
     *                     @OA\Property(
     *                         property="refresh_token",
     *                         title="refresh token",
     *                         description="Refresh token",
     *                         type="string",
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function refresh()
    {
        return $this->respondWithTokens($this->tokenService->generateTokens(auth()->user()));
    }

    private function respondWithTokens(array $tokens): \Illuminate\Http\JsonResponse
    {
        return response()->json([
            'data' => [
                'access_token' => $tokens['access'],
                'refresh_token' => $tokens['refresh'],
            ]
        ]);
    }

}
