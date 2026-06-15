<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    protected $fillable = [
        'country_id',
        'university_id',
        'title',
        'degree',
        'funding_type',
        'open_date',
        'deadline',
        'official_link',
        'source_link',
        'description',
        'eligibility',
        'required_documents',
        'is_active',
    ];

    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function assistanceRequests()
    {
        return $this->hasMany(AssistanceRequest::class);
    }

    public function getStatusAttribute()
    {
        if (!$this->open_date || !$this->deadline) {
            return 'Unknown';
        }

        $today = now()->toDateString();

        if ($today < $this->open_date) {
            return 'Coming Soon';
        }

        if ($today > $this->deadline) {
            return 'Closed';
        }

        if (now()->diffInDays($this->deadline, false) <= 7) {
            return 'Closing Soon';
        }

        return 'Open';
    }
}