<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceRequest extends Model
{
    protected $fillable = [
        'service_id',
        'user_id',
        'message',
        'status',
    ];
    public function serviceType(){
        return $this->belongsTo(ServiceType::class ,'service_id');
    }
    public function user(){
        return $this->belongsTo(User::class ,'user_id');
    }
}
