<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    /**
     * Student documents (passports, certificates, transcripts...) are personal data.
     * They are stored on the private "local" disk (storage/app/private), which has no public URL,
     * and are only served to admins through AdminAssistanceRequestController::document().
     */
    public const DISK = 'local';

    protected $fillable = [
        'assistance_request_id',
        'document_type',
        'file_path',
        'original_name',
    ];

    public function assistanceRequest()
    {
        return $this->belongsTo(AssistanceRequest::class);
    }
}