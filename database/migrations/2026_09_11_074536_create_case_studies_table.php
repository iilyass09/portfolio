<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('case_studies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->cascadeOnDelete();
            $table->string('tagline');
            $table->string('duration');
            $table->string('role');
            $table->string('tools');
            $table->string('hero_bg')->nullable();
            $table->enum('layout', ['ux', 'data'])->default('ux');
            $table->text('figma_prototype_url')->nullable();
            $table->text('figma_lofi_url')->nullable();
            $table->longText('background')->nullable();
            $table->longText('problem')->nullable();
            $table->longText('goal')->nullable();
            $table->longText('footer_description')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('case_studies');
    }
};
