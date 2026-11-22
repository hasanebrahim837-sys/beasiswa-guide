<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Optional Arabic versions of the scholarship texts, shown when the site is in Arabic.
 * When a field is empty, the English text is shown instead.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            $table->string('title_ar')->nullable()->after('title');
            $table->text('description_ar')->nullable()->after('description');
            $table->text('eligibility_ar')->nullable()->after('eligibility');
            $table->text('required_documents_ar')->nullable()->after('required_documents');
        });
    }

    public function down(): void
    {
        Schema::table('scholarships', function (Blueprint $table) {
            $table->dropColumn(['title_ar', 'description_ar', 'eligibility_ar', 'required_documents_ar']);
        });
    }
};
