<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('postings', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->enum('source',
                ['LinkedIn', 'Indeed', 'Jobboom', 'Jobillico', 'JobBank', 'Other']);
            $table->string('source_id');
            $table->enum('employment_type',
                ['full_time', 'part_time', 'contract', 'internship', 'temporary']);
            $table->enum('work_mode',
                ['in_office', 'remote', 'hybrid']);
            $table->string('url', 2048);
            $table->string('company');
            $table->string('title');
            $table->text('description');
            $table->enum('status', [
                'new',
                'postulated',
                'dropped',
                'rejected',
                'interview_scheduled',
                'interview_completed',
                'interview_dropped',
                'interview_rejected',
                'job_offered',
                'job_accepted',
                'job_refused',
            ])->default('new');
            $table->text('cover_letter')->nullable();

            $table->timestamps();

            $table->index('status');
            $table->index('source');
            $table->unique(['source', 'source_id']);
            $table->fullText(['company', 'title', 'description']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('postings');
    }
};
