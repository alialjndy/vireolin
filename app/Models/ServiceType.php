<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceType extends Model
{
    use HasFactory;
    protected $fillable = [
        'title',
        'description'
    ];
    protected $hidden = [
        'created_at',
        'updated_at',
    ];
    public function serviceBookings()
    {
        return $this->hasMany(ServiceBooking::class, 'service_id');
    }
    public function images()
    {
        return $this->hasMany(Image::class, 'service_id');
    }
}
