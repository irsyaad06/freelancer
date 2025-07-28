<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Subcategory extends Model
{
    protected $fillable = ['category_id', 'name', 'slug'];

    protected static function booted()
    {
        static::creating(function (Subcategory $subcategory) {
            $subcategory->slug = Str::slug($subcategory->name);
        });
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function freelancers(): BelongsToMany
    {
        return $this->belongsToMany(Freelancer::class, 'freelancer_subcategory');
    }
}
