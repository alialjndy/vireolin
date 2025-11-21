<?php

namespace App\Http\Controllers;

use App\Http\Requests\Service\CreateServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Models\ServiceType;
use App\Services\ServiceType\ManageService;
use Illuminate\Http\Request;
use App\Docs\ServiceType as DocsServiceType ;

class ServiceTypeController extends Controller
{
    protected $service ;
    public function __construct(ManageService $service)
    {
        $this->service = $service ;
    }
    /**
     * @OA\Get(
     *     path="/serviceTypes",
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
    public function index()
    {
        $allServices = ServiceType::with('serviceRequests')->paginate(10);
        return self::paginated($allServices);
    }

    /**
     * @OA\Post(
     *     path="/serviceTypes",
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
    public function store(CreateServiceRequest $request)
    {
        $info = $this->service->create($request->validated());
        return $info['status'] == 'success'
            ? self::success([$info['data']] , 201)
            : self::error($info['message'] , $info['status'] ,$info['code'] ,[$info['errors']]);
    }

    /**
     * @OA\Get(
     *     path="/serviceTypes/{id}",
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
    public function show(ServiceType $serviceType)
    {
        $info = $this->service->show($serviceType);
        return $info['status'] == 'success'
            ? self::success([$info['data']] , 200)
            : self::error($info['message'] , $info['status'] ,$info['code'] ,[$info['errors']]);
    }

    /**
     * @OA\Put(
     *     path="/serviceTypes/{id}",
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
    public function update(UpdateServiceRequest $request, ServiceType $serviceType)
    {
        $info = $this->service->update($request->validated() , $serviceType);
        return $info['status'] == 'success'
            ? self::success([$info['data']] , 200)
            : self::error($info['message'] , $info['status'] ,$info['code'] ,[$info['errors']]);
    }

    /**
     * @OA\Delete(
     *     path="/serviceTypes/{id}",
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
    public function destroy(ServiceType $serviceType)
    {
        $this->authorize('delete', $serviceType);
        $serviceType->delete();
        return self::success([]);
    }
}
