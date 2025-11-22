<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceBooking extends Model
{
    use HasFactory;
    protected $fillable = [
        'service_id',
        'user_id',
        'message',
        'status',
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function serviceType(){
        return $this->belongsTo(ServiceType::class ,'service_id');
    }
    public function user(){
        return $this->belongsTo(User::class ,'user_id');
    }
}
