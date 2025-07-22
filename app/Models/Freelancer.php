<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Freelancer extends Model
{
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'bio',
        'profile_photo',
        'rating',
        'is_verified',
    ];

    public function subcategories(): BelongsToMany
    {
        return $this->belongsToMany(Subcategory::class, 'freelancer_subcategory');
    }

    public function photos(): HasMany
    {
        return $this->hasMany(FreelancerPhoto::class);
    }

    public function servicePackages(): HasMany
    {
        return $this->hasMany(ServicePackage::class);
    }

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }
}
