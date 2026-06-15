<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssistanceRequest extends Model
{
    protected $fillable = [
        'user_id',
        'scholarship_id',
        'university_id',
        'full_name',
        'email',
        'whatsapp',
        'nationality',
        'degree',
        'status',
        'student_notes',
        'admin_notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }

    public function university()
    {
        return $this->belongsTo(University::class);
    }

    public function documents()
    {
        return $this->hasMany(Document::class);
    }
}