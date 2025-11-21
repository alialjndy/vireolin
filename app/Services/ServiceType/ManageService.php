<?php
namespace App\Services\ServiceType;

use App\Models\ServiceType;
use App\Services\Image\ImageService;
use App\Traits\Response;
use Exception;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class ManageService{
    protected $imageService ;
    public function __construct(ImageService $imageService)
    {
        $this->imageService = $imageService ;
    }
    use Response;
    /**
     * Summary of getAllServices
     * @return array{code: mixed, data: mixed, message: mixed, status: mixed|array{code: mixed, errors: mixed, message: mixed, status: mixed}}
     */
    public function getAllServices(){
        try{
            $user = JWTAuth::parseToken()->authenticate();

            // Conditionally eager load serviceRequests for admin users
            $allServices = $user->hasRole('admin')
                ? ServiceType::with(['serviceRequests', 'images'])->paginate(10)
                : ServiceType::with('images')->paginate(10);

            return $this->successResponse('success', 'Done Successfully!' , [$allServices], 200);
        }catch(Exception $e){
            Log::error('Error when Fetching All Service Types '. $e->getMessage());
            return $this->failedResponse('failed', 'Error Occurred!' , [$e->getMessage()] , $e->getCode() ?? 500);
        }


    }
    /**
     * Create a new service type.
     * @param array $data
     * @return array{code: mixed, data: mixed, message: mixed, status: mixed|array{code: mixed, errors: mixed, message: mixed, status: mixed}}
     */
    public function create(array $data , $photos = null){
        try{
            // Mass assign safe data to create service type
            $service = ServiceType::create($data);

            if($photos){
                // Handle image uploads if photos are provided
                set_time_limit(60);
                $result = $this->imageService->storeMultipleImage($photos , $service);
            }
            return $this->successResponse('success', 'Done Successfully!' , ['service' => $service , 'photos' => $result ?? null], 201);
        }catch(Exception $e){
            Log::error('Error when Creating Service Type '. $e->getMessage());
            return $this->failedResponse('failed', $e->getMessage() , [$e->getMessage()] , $e->getCode() ?? 500);
        }
    }
    /**
     * Update an existing service type.
     * @param array $data
     * @param ServiceType $serviceType
     * @return array{code: mixed, data: mixed, message: mixed, status: mixed|array{code: mixed, errors: mixed, message: mixed, status: mixed}}
     */
    public function update(array $data , ServiceType $serviceType){
        try{
            // Update model and refresh to ensure latest state is returned
            $serviceType->update($data);
            return $this->successResponse('success', 'Done Successfully!' , [$serviceType->refresh()], 200);
        }catch(Exception $e){
            Log::error('Error when Updating Service Type '. $e->getMessage());
            return $this->failedResponse('failed', 'Error Occurred!' , [$e->getMessage()] , $e->getCode() ?? 500);
        }
    }
    /**
     * Show a single service type.
     * Admins include related service requests.
     * @param ServiceType $serviceType
     * @return array{code: mixed, data: mixed, message: mixed, status: mixed|array{code: mixed, errors: mixed, message: mixed, status: mixed}}
     */
    public function show(ServiceType $serviceType){
        try{
            $user = JWTAuth::parseToken()->authenticate();

            // Eager load serviceRequests only for admin users
            if($user->hasRole('admin')){
                $serviceType = $serviceType->load(['serviceRequests', 'images']);
            }else{
                $serviceType = $serviceType->load('images');
            }
            return $this->successResponse('success', 'Done Successfully!' , [$serviceType], 200);
        }catch(Exception $e){
            Log::error('Error when Fetching Service Type '. $e->getMessage());
            return $this->failedResponse('failed', 'Error Occurred!' , [$e->getMessage()] , $e->getCode() ?? 500);
        }
    }
}
