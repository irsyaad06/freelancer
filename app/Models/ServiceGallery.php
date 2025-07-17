<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class ServiceGallery extends Model
{
    protected $fillable = ['service_id', 'image_url'];
    // protected static function booted()
    // {
    //     static::creating(function (ServiceGallery $serviceGallery) {
    //         $serviceGallery->slug = Str::slug($serviceGallery->name);
    //     });
    // }
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
