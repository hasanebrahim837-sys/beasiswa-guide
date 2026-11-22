<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

/**
 * Student documents used to be saved in the public folder (storage/app/public), where anyone
 * with the link could open them. Move every existing document to the private disk.
 */
return new class extends Migration
{
    public function up(): void
    {
        $this->move(Storage::disk('public'), Storage::disk('local'));
    }

    public function down(): void
    {
        $this->move(Storage::disk('local'), Storage::disk('public'));
    }

    private function move($from, $to): void
    {
        DB::table('documents')->orderBy('id')->each(function ($document) use ($from, $to) {
            $path = $document->file_path;

            if ($from->exists($path) && ! $to->exists($path)) {
                $to->writeStream($path, $from->readStream($path));

                if ($to->exists($path)) {
                    $from->delete($path);
                }
            }
        });
    }
};
