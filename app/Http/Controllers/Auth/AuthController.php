<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use App\Services\Auth\AuthService;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    protected $service ;
    public function __construct(AuthService $service)
    {
        $this->service = $service ;
    }
    /**
     * @OA\Post(
     *     path="/register",
     *     operationId="registerUser",
     *     tags={"Authentication"},
     *     summary="Register new user",
     *     description="Register new user with the provided information.",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="User data for register",
     *         @OA\JsonContent(
     *             required={"name","email","password","password_confirmation","phone_number"},
     *             @OA\Property(property="name", type="string", minLength=3, maxLength=100, example="Ali Aljndy",description="Full Name User"),
     *             @OA\Property(property="email", type="string", format="email", example="ahmed@example.com", description="user email"),
     *             @OA\Property(property="password", type="string", format="password", minLength=8, example="Password123!", description="password must have at least 8 characters including uppercase, lowercase, numbers, and symbols"),
     *             @OA\Property(property="password_confirmation", type="string", format="password", example="Password123!", description="Password Confirmation"),
     *             @OA\Property(property="phone_number", type="string", minLength=8, maxLength=15, example="0998680361", description="")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="User Registered Successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="User registered. Please check your email to verify your account."),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...", description="JWT token"),
     *                 @OA\Property(property="token-type", type="string", example="Bearer", description="Token Type")
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Failed Validation",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Error in server",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function register(RegisterRequest $request){
        $info = $this->service->register($request->validated());
        return $info['status'] == 'success'
            ? self::success($info['data'] ,200 ,$info['message'])
            : self::error('Error Occurred' ,$info['status'] , $info['code'] ,[$info['errors']]);
    }
    /**
     * @OA\Post(
     *     path="/login",
     *     operationId="loginUser",
     *     tags={"Authentication"},
     *     summary="Login User",
     *     description="Login User With Provided info.",
     *
     *     @OA\RequestBody(
     *         required=true,
     *         description="Login Data",
     *         @OA\JsonContent(
     *             required={"email","password"},
     *             @OA\Property(property="email", type="string", format="email", example="ahmed@example.com", description="user email"),
     *             @OA\Property(property="password", type="string", format="password", example="Password123!", description="password")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="logged in successfully!",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="Logged in Successfully!"),
     *             @OA\Property(property="data", type="object",
     *                 @OA\Property(property="token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9...", description="JWT token"),
     *                 @OA\Property(property="user", type="object",
     *                     @OA\Property(property="id", type="integer", example=1),
     *                     @OA\Property(property="name", type="string", example="Ali"),
     *                     @OA\Property(property="email", type="string", example="ahmed@example.com"),
     *                     @OA\Property(property="phone_number", type="string", example="0998680361"),
     *                     @OA\Property(property="email_verified_at", type="string", format="date-time", example=null),
     *                     @OA\Property(property="created_at", type="string", format="date-time"),
     *                     @OA\Property(property="updated_at", type="string", format="date-time")
     *                 ),
     *                 @OA\Property(property="roles", type="array",
     *                     @OA\Items(type="string", example="customer"),
     *                     description="User Roles"
     *                 )
     *             )
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Invalid Credentials",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="failed"),
     *             @OA\Property(property="message", type="string", example="Invalid credentials. Please try again."),
     *             @OA\Property(property="data", type="object", example={}),
     *             @OA\Property(property="code", type="integer", example=401)
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=422,
     *         description="Failed validation",
     *         @OA\JsonContent(ref="#/components/schemas/ValidationError")
     *     ),
     *
     *     @OA\Response(
     *         response=500,
     *         description="Error in server",
     *         @OA\JsonContent(ref="#/components/schemas/ErrorResponse")
     *     )
     * )
     */
    public function login(LoginRequest $request){
        $info = $this->service->login($request->validated());
        return $info['status'] == 'success'
            ? self::success($info['data'] ,200 ,$info['message'])
            : self::error('Error Occurred' ,$info['status'] , $info['code'] ?? 500);
    }
    /**
     * @OA\Post(
     *     path="/logout",
     *     operationId="logoutUser",
     *     tags={"Authentication"},
     *     summary="Logout User",
     *     description="logout user and destroy the token.",
     *
     *     security={{"bearerAuth":{}}},
     *
     *     @OA\Response(
     *         response=200,
     *         description="User Logged out successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="message", type="string", example="User Logged Out Successfully"),
     *             @OA\Property(property="data", type="array", @OA\Items())
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=401,
     *         description="Invalid Token",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="failed"),
     *             @OA\Property(property="message", type="string", example="Unauthorized"),
     *             @OA\Property(property="code", type="integer", example=401)
     *         )
     *     )
     * )
     */
    public function logout(Request $request){
        $info = $this->service->logout();
        return self::success([] ,200 ,$info['message']);
    }
}
