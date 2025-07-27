<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServicePackage extends Model
{
    protected $fillable = ['freelancer_id', 'subcategory_id', 'title', 'price', 'description'];

    public function services()
    {
        return $this->hasMany(Service::class);
    }

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }

    
}

