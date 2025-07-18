<?php

namespace App\Models;

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
}
