<?php
namespace App\Traits;
trait Response{
    protected function successResponse($status ,$message ,$data = [] ,$code = 200){
        return [
            'status'    => $status ,
            'message'   => $message ,
            'data'      => $data ,
            'code'      => $code
        ];
    }
    protected function failedResponse($status ,$message ,$errors = [] ,$code = 400){
        return [
            'status'    => $status ,
            'message'   => $message ,
            'errors'    => $errors ,
            'code'      => $code
        ];
    }
}
