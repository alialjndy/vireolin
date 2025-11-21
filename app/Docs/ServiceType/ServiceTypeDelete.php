<?php
namespace App\Docs\ServiceType;
/**
 * @OA\Delete(
 *     path="serviceTypes/{id}",
 *     summary="Delete a service type",
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
 *         description="Service type deleted"
 *     ),
 *
 *     @OA\Response(
 *         response=403,
 *         description="Forbidden"
 *     )
 * )
 */
