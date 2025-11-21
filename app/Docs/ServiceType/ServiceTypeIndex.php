<?php
namespace App\Docs\ServiceType;
/**
 * @OA\Get(
 *     path="serviceTypes",
 *     summary="Get all service types",
 *     tags={"serviceTypes"},
 *     security={{"bearerAuth":{}}},
 *     @OA\Response(
 *         response=200,
 *         description="List of service types",
 *         @OA\JsonContent(
 *             @OA\Property(property="status", type="string"),
 *             @OA\Property(property="message", type="string"),
 *             @OA\Property(property="data", type="array",
 *                 @OA\Items(type="object")
 *             ),
 *             @OA\Property(property="code", type="integer")
 *         )
 *     )
 * )
 */
