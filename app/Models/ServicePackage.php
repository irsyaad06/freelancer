<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServicePackage extends Model
{
    protected $fillable = ['freelancer_id', 'subcategory_id', 'title', 'price', 'description'];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($servicePackage) {
            // Cek apakah sudah ada paket dengan freelancer, subkategori, dan title yang sama
            $existing = static::where('freelancer_id', $servicePackage->freelancer_id)
                ->where('subcategory_id', $servicePackage->subcategory_id)
                ->where('title', $servicePackage->title)
                ->first();

            if ($existing) {
                throw new \Exception('Paket ini sudah ada untuk freelancer ini dalam subkategori yang sama.');
            }
        });

        static::updating(function ($servicePackage) {
            // Cek apakah sudah ada paket dengan freelancer, subkategori, dan title yang sama (kecuali yang sedang diupdate)
            $existing = static::where('freelancer_id', $servicePackage->freelancer_id)
                ->where('subcategory_id', $servicePackage->subcategory_id)
                ->where('title', $servicePackage->title)
                ->where('id', '!=', $servicePackage->id)
                ->first();

            if ($existing) {
                throw new \Exception('Paket ini sudah ada untuk freelancer ini dalam subkategori yang sama.');
            }
        });
    }

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

    public static function getUniquePackages($freelancerId, $subcategoryId)
    {
        return static::where('freelancer_id', $freelancerId)
            ->where('subcategory_id', $subcategoryId)
            ->get();
    }
}

