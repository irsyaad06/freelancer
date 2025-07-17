<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
class ServicePackage extends Model
{
    protected $fillable = ['service_id', 'name','description', 'price', 'revisions', 'duration'];
    // protected static function booted()
    // {
    //     static::creating(function (ServicePackage $servicePackage) {
    //         $servicePackage->slug = Str::slug($servicePackage->name);
    //     });
    // }
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}
