<?php
namespace App\Services\Auth;

use App\Models\User;
use App\Traits\Response;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthService{
    use Response ;
    public function register(array $data){
            try{
                $user = User::create($data);

                // Send Authentication email.
                $user->sendEmailVerificationNotification();

                // Assign default role to the new user.
                $user->assignRole('customer');

                // Response messages
                return $this->successResponse(
                    'success' ,
                    'User registered. Please check your email to verify your account.',
                    ['token' => JWTAuth::fromUser($user) , 'token-type' => 'Bearer'],
                    200
                );
            }catch(Exception $e){
                Log::error('Error when Register User '. $e->getMessage());
                return $this->failedResponse('failed' ,'Error Occurred!' ,[$e->getMessage()] ,500);
            }
    }
    public function login(array $data){
        try{

            // dd(JWTAuth::attempt($data));

            if(!JWTAuth::attempt($data)){
                return $this->failedResponse('failed' ,'Invalid credentials. Please try again.' ,[] ,401);
            }else{
                $token = JWTAuth::attempt($data);
                $user  = JWTAuth::user();
                $roles = $user->getRoleNames();

                return $this->successResponse(
                    'success',
                    'Logged in Successfully!',
                    ['token' =>$token  ,'user' => ['name' => $user->name , 'email' => $user->email] ,'roles' => $roles],
                    200
                );
            }
        }catch(Exception $e){
            Log::error('Error when Login User '. $e->getMessage());
            return $this->failedResponse('failed' ,'Error Occurred!' ,[] ,$e->getCode() ?? 500);
        }
    }
    public function logout(){
        Auth::logout();
        return $this->successResponse('success' ,'User Logged Out Successfully',[]);
    }
}
