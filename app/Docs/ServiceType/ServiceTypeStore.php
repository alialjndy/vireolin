<?php
namespace App\Docs\ServiceType;
/**
 * @OA\Post(
 *     path="serviceTypes",
 *     summary="Create service type",
 *     tags={"serviceTypes"},
 *     security={{"bearerAuth":{}}},
 *
 *     @OA\RequestBody(
 *         required=true,
 *         @OA\JsonContent(
 *             required={"title"},
 *             @OA\Property(property="title", type="string", example="Cleaning"),
 *             @OA\Property(property="description", type="string", example="Cleaning service description")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=201,
 *         description="Service type created",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string"),
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(type="object")
 *             ),
 *             @OA\Property(property="code", type="integer")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=422,
 *         description="Validation error"
 *     )
 * )
 */

