<?php
namespace App\Docs\ServiceType;
/**
 * @OA\Put(
 *     path="serviceTypes/{id}",
 *     summary="Update service type",
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
 *     @OA\RequestBody(
 *         required=false,
 *         @OA\JsonContent(
 *             @OA\Property(property="title", type="string", example="Updated Title"),
 *             @OA\Property(property="description", type="string", example="Updated description")
 *         )
 *     ),
 *
 *     @OA\Response(
 *         response=200,
 *         description="Service type updated"
 *     ),
 *
 *     @OA\Response(
 *         response=422,
 *         description="Validation error"
 *     )
 * )
 */
