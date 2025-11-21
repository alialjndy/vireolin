<?php
namespace App\Docs\ServiceType;
/**
 * @OA\Get(
 *     path="serviceTypes/{id}",
 *     summary="Get a single service type",
 *     tags={"serviceTypes"},
 *     security={{"bearerAuth":{}}},
 *
 *     @OA\Parameter(
 *         name="id",
 *         in="path",
 *         required=true,
 *         description="ServiceType ID",
 *         @OA\Schema(type="integer")
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Single service type info"
 *     ),
 *
 *     @OA\Response(
 *         response=404,
 *         description="Service type not found"
 *     )
 * )
 */
