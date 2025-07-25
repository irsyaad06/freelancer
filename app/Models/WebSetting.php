<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WebSetting extends Model
{
    protected $fillable = [
        'logo_web',
        'nama_web',
        'deskripsi_web',
        'alamat_web',
        'email_web',
        'telepon_web',
        'facebook_web',
        'instagram_web',
        'twitter_web',
    ];
}
