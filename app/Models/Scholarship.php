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
        'title_ar',
        'description_ar',
        'eligibility_ar',
        'required_documents_ar',
        'is_active',
    ];

    /**
     * Fields that have an optional Arabic version stored in "<field>_ar".
     */
    public const TRANSLATABLE = ['title', 'description', 'eligibility', 'required_documents'];

    /**
     * Return the field in the visitor's language: the Arabic version when the site is in
     * Arabic and one was entered, otherwise the English original.
     */
    public function localized(string $field): ?string
    {
        if (app()->getLocale() === 'ar' && in_array($field, self::TRANSLATABLE, true)) {
            $arabic = $this->getAttribute($field . '_ar');

            if (filled($arabic)) {
                return $arabic;
            }
        }

        return $this->getAttribute($field);
    }

    /**
     * Translate a comma-separated list of known values (e.g. "Bachelor, Master, PhD").
     */
    public static function translateList(?string $value): string
    {
        if (blank($value)) {
            return '-';
        }

        $separator = app()->getLocale() === 'ar' ? '، ' : ', ';

        return collect(explode(',', $value))
            ->map(fn ($part) => __(trim($part)))
            ->implode($separator);
    }

    public function getDegreeLabelAttribute(): string
    {
        return self::translateList($this->degree);
    }

    public function getFundingLabelAttribute(): string
    {
        return filled($this->funding_type) ? __($this->funding_type) : __('To be confirmed');
    }

    public function getStatusLabelAttribute(): string
    {
        return $this->status === 'Unknown' ? __('Not announced yet') : __($this->status);
    }

    /**
     * Scholarships shown on the public site: active, and not past their deadline.
     * Closed ones are hidden automatically but kept, so they can be updated for the next cycle.
     */
    public function scopeVisible($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('deadline')
                    ->orWhereDate('deadline', '>=', now()->toDateString());
            });
    }

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