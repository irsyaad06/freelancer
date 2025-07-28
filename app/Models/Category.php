<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
    protected $fillable = ['name', 'slug','icon'];

    protected static function booted()
    {
        static::creating(function (Category $category) {
            $category->slug = Str::slug($category->name);
        });
    }

    public function subcategories(): HasMany
    {
        return $this->hasMany(Subcategory::class);
    }
}
