<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    protected $fillable = [
        'name',
        'code',
    ];

    public function universities()
    {
        return $this->hasMany(University::class);
    }

    public function scholarships()
    {
        return $this->hasMany(Scholarship::class);
    }
}