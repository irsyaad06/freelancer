<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageService extends Model
{
    protected $fillable = ['service_package_id', 'name', 'is_included'];

    public function servicePackage(): BelongsTo
    {
        return $this->belongsTo(ServicePackage::class);
    }
}
