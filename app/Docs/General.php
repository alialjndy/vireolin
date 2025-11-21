<?php

namespace App\Docs;
/**
 * @OA\Info(
 *     title="Vireolin API",
 *     version="1.0.0",
 *     description="API توثيق لتطبيق Vireolin"
 * )
 *
 * @OA\Server(
 *     url="http://localhost:8000/api",
 *     description="Local Development Server"
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 *
 * @OA\Tag(
 *     name="Authentication",
 *     description="عمليات المصادقة والتسجيل والدخول والخروج"
 * )
 *
 * @OA\Tag(
 *     name="serviceTypes",
 *     description="API Endpoints for Managing Service Types"
 * )
  * @OA\Schema(
 *     schema="SuccessResponse",
 *     type="object",
 *     @OA\Property(property="status", type="string", example="success"),
 *     @OA\Property(property="message", type="string", example="Operation completed successfully"),
 *     @OA\Property(property="data", type="object")
 * )
 *
 * @OA\Schema(
 *     schema="ErrorResponse",
 *     type="object",
 *     @OA\Property(property="status", type="string", example="failed"),
 *     @OA\Property(property="message", type="string", example="Error occurred"),
 *     @OA\Property(property="errors", type="object", example={}),
 *     @OA\Property(property="code", type="integer", example=500)
 * )
 *
 * @OA\Schema(
 *     schema="ValidationError",
 *     type="object",
 *     @OA\Property(property="status", type="string", example="failed"),
 *     @OA\Property(property="message", type="string", example="failed validation please confirm the input"),
 *     @OA\Property(property="errors", type="object")
 * )
 */
class General {}
