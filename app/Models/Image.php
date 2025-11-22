<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        'image_path',
        'service_id',
    ];
    protected $appends = ['url'];
    protected $hidden = [
        'created_at',
        'updated_at'
    ];
    public function getUrlAttribute(){
        return url('storage/'. $this->image_path);
    }
}
