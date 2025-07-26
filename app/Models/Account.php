<?php

namespace App\Models;

use App\Enums\AccountType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'password',
        'email',
        'type',
    ];

    protected $hidden = [
        'password',
        'secret',
    ];

    protected $casts = [
        'type' => AccountType::class,
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('exclude_account_manager', function (Builder $builder) {
            $builder->where('name', '!=', '1');
        });
    }

    public function players()
    {
        return $this->hasMany(Player::class, 'account_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'name', 'name');
    }

    public function verifyPassword(string $password): bool
    {
        return $this->password === sha1($password);
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = sha1($value);
    }

    public function isPremium(): bool
    {
        return strtotime($this->premium_ends_at) > time();
    }

    public function getPremiumStatus(): string
    {
        if (lua('freePremium')) {
            return 'Free Premium Account';
        }

        if ($this->isPremium()) {
            return 'Premium Account';
        }

        return 'Free Account';
    }

    public function getPremiumDate($asTimestamp = false): mixed
    {
        if (lua('freePremium')) {
            return 'the end of time';
        }

        if ($asTimestamp) {
            return strtotime($this->premium_ends_at);
        }

        return date('M j Y, H:i:s T', strtotime($this->premium_ends_at));
    }

    public function getCreationDate(): string
    {
        return date('M j Y, H:i:s T', strtotime($this->creation));
    }
}
