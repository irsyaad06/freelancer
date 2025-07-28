<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Freelancer;
use App\Models\Subcategory;


class FreelancerPhoto extends Model
{
    use HasFactory;

    protected $fillable = [
        'freelancer_id',
        'subcategory_id',
        'title',
        'image_path',
    ];

    public function freelancer()
    {
        return $this->belongsTo(Freelancer::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(Subcategory::class);
    }
}

