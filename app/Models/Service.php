<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Service extends Model
{
    protected $fillable = ['subcategory_id', 'user_id', 'title', 'description'];
    // protected static function booted()
    // {
    //     static::creating(function (Service $service) {
    //         $service->slug = Str::slug($service->name);
    //     });
    // }
    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function packages(): HasMany
    {
        return $this->hasMany(ServicePackage::class);
    }

    public function gallery(): HasMany
    {
        return $this->hasMany(ServiceGallery::class);
    }
}
