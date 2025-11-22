<?php

namespace App\Http\Controllers;

use App\Http\Requests\Service\CreateServiceRequest;
use App\Http\Requests\Service\UpdateServiceRequest;
use App\Models\ServiceType;
use App\Services\ServiceType\ManageService;
use Illuminate\Http\Request;
use App\Http\Requests\Image\UpdateImageRequest;
use App\Http\Requests\Image\UploadImageRequest;
use App\Services\Image\ImageService;
use Tymon\JWTAuth\Facades\JWTAuth;

class ServiceTypeController extends Controller
{
    protected $service ;
    protected $imageService ;
    public function __construct(ManageService $service , ImageService $imageService)
    {
        $this->service = $service ;
        $this->imageService = $imageService ;
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
        $user = JWTAuth::parseToken()->authenticate();

        // Conditionally eager load serviceRequests for admin users
        $allServices = $user->hasRole('admin')
            ? ServiceType::with(['serviceBookings', 'images'])->paginate(10)
            : ServiceType::with('images')->paginate(10);
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
    public function store(CreateServiceRequest $request , UploadImageRequest $uploadRequest)
    {
        $photos = $uploadRequest->file('images');
        $info = $this->service->create($request->validated() , $photos);
        return $info['status'] == 'success'
            ? self::success(['service' =>$info['data']['service'] , 'photo_info' => $info['data']['photos'] ?? null] , 201)
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
    public function update(UpdateServiceRequest $request,UpdateImageRequest $imgRequest ,ServiceType $serviceType)
    {
        $uploadedPhotos = $imgRequest->file('new_photos'); // New photos to upload

        $deletePhotos = $imgRequest->input('deleted_photos'); // IDs of photos to delete

        $info = $this->service->update($request->validated() , $serviceType , $uploadedPhotos , $deletePhotos);
        return $info['status'] == 'success'
            ? self::success(
                [
                    'service' =>$info['data']['service'],
                    'message stored' => $info['data']['message stored'] ?? null,
                    'message deleted' => $info['data']['message deleted'] ?? null
                ] ,
                200)
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
        $info = $this->service->delete($serviceType);

        return $info['status'] == 'success'
            ? self::success([$info['data']])
            : self::error($info['message'] ,$info['status'] ,$info['code'] ,[$info['errors']]);
    }
}
