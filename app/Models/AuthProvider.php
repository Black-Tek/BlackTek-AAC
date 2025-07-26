<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuthProvider extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'provider',
        'nickname',
        'avatar',
        'provider_id',
        'token',
        'login_at',
    ];

    protected $casts = [
        'login_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public static function findByProvider(string $provider, string $providerId): ?self
    {
        return static::where('provider', $provider)
            ->where('provider_id', $providerId)
            ->first();
    }

    public static function updateOrCreateProvider(
        int $userId,
        string $provider,
        string $providerId,
        array $data
    ): self {
        return static::updateOrCreate(
            [
                'provider' => $provider,
                'provider_id' => $providerId,
            ],
            array_merge($data, [
                'user_id' => $userId,
                'login_at' => now(),
            ])
        );
    }
}
