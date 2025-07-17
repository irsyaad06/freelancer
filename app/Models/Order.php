<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Order extends Model
{
    protected $fillable = ['user_id', 'service_package_id', 'description', 'attachment', 'status'];
    // protected static function booted()
    // {
    //     static::creating(function (Category $category) {
    //         $category->slug = Str::slug($category->name);
    //     });
    // }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(ServicePackage::class, 'service_package_id');
    }
}
