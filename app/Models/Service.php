<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    protected $fillable = ['freelancer_id', 'subcategory_id', 'service_package_id', 'title'];

    public function servicePackage()
    {
        return $this->belongsTo(ServicePackage::class);
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
