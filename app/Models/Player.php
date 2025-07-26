<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Player extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'account_id',
        'sex',
        'vocation',
        'town_id',
        'looktype',
        'lookhead',
        'lookbody',
        'looklegs',
        'lookfeet',
        'level',
        'experience',
        'health',
        'healthmax',
        'mana',
        'manamax',
        'cap',
        'soul',
    ];

    protected $appends = ['outfit_image_url', 'sex_name', 'vocation_name'];

    protected static function booted(): void
    {
        static::addGlobalScope('exclude_account_manager', function (Builder $builder) {
            $builder->where('account_id', '!=', 1);
        });
    }

    public function account()
    {
        return $this->belongsTo(Account::class, 'account_id', 'id');
    }

    public function getVocationNameAttribute(): string
    {
        return app('vocations')->getVocationName($this->vocation);
    }

    public function getSexNameAttribute(): string
    {
        return $this->sex === 0 ? 'Male' : 'Female';
    }

    public function getOutfitImageUrlAttribute(): string
    {
        return config('blacktek.outfits_images_url').'?id='.$this->looktype.'&head='.$this->lookhead.'&body='.$this->lookbody.'&legs='.$this->looklegs.'&feet='.$this->lookfeet;
    }

    public function getRouteKeyName(): string
    {
        return 'name';
    }

    public static function getDefaultOutfit(int $sex): array
    {
        $lookType = match ($sex) {
            0 => 136,
            1 => 128,
            default => 136
        };

        return [
            'looktype' => $lookType,
            'lookhead' => 0,
            'lookbody' => 0,
            'looklegs' => 0,
            'lookfeet' => 0,
        ];
    }

    public static function getNewPlayerDefaults(): array
    {
        return [
            'level' => config('blacktek.characters.new.level'),
            'experience' => experience_for_level(config('blacktek.characters.new.level')),
            'health' => config('blacktek.characters.new.health'),
            'healthmax' => config('blacktek.characters.new.health'),
            'mana' => config('blacktek.characters.new.mana'),
            'manamax' => config('blacktek.characters.new.mana'),
            'cap' => config('blacktek.characters.new.cap'),
            'soul' => config('blacktek.characters.new.soul'),
        ];
    }
}
