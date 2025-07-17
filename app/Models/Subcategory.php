<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class Subcategory extends Model
{
    protected $fillable = ['category_id', 'name'];
    protected static function booted()
    {
        static::creating(function (SubCategory $subcategory) {
            $subcategory->slug = Str::slug($subcategory->name);
        });
    }
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function services(): HasMany
    {
        return $this->hasMany(Service::class);
    }
}
