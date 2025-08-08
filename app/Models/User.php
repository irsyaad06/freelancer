<?php

// app/Models/User.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Log;
use App\Models\Freelancer;

class User extends Authenticatable implements FilamentUser
{
    use HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password', 'role', 'no_whatsapp'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Method wajib dari interface FilamentUser
    public function canAccessPanel(Panel $panel): bool
    {
        Log::info('canAccessPanel dipanggil untuk user id: ' . $this->id);
        return true; // Ganti logika ini sesuai kebutuhan akses kamu
    }

    // Kalau kamu mau, method ini bisa kamu hapus atau biarkan, tapi Filament default pakai canAccessPanel()
    public function canAccessFilament(): bool
    {
        Log::info('canAccessFilament dipanggil untuk user id: ' . $this->id);
        return true;
    }
}
