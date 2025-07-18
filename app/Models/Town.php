<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Town extends Model
{
    public $timestamps = false;

    public function getName(): string
    {
        return $this->name;
    }

    public static function getAvailableTowns(): array
    {
        return self::all()->pluck('name', 'id')->toArray();
    }
}
