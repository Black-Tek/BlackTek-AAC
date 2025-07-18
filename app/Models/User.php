<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class User extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'name',
        'password',
        'email',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
        ];
    }

    public function account(): HasOne
    {
        return $this->hasOne(Account::class, 'name', 'name');
    }

    protected static function booted(): void
    {
        static::creating(function (User $user) {
            $user->account()->create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => $user->password,
            ]);
            $user->password = Hash::make($user->password);
        });

        static::updating(function (User $user) {
            if ($user->isDirty('password')) {
                $user->account->update(['password' => $user->password]);
                $user->password = Hash::make($user->password);
            }

            if ($user->isDirty('email')) {
                $user->account->update(['email' => $user->email]);
            }
        });
    }
}
