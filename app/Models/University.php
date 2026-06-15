<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class University extends Model
{
    protected $fillable = [
        'country_id',
        'name',
        'city',
        'website',
        'description',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function scholarships()
    {
        return $this->hasMany(Scholarship::class);
    }

    public function assistanceRequests()
    {
        return $this->hasMany(AssistanceRequest::class);
    }
}