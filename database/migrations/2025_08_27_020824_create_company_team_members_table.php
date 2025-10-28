<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('company_team_members', function (Blueprint $table) {
            $table->id();
            $table->string('full_name');
            $table->string('job_title');
            $table->string('department')->nullable();
            $table->string('location')->nullable();
            $table->string('profile_image_url')->nullable();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->unsignedInteger('review_count')->default(0);
            $table->json('social_links')->nullable();
            $table->boolean('is_featured')->default(false);
            $table->unsignedInteger('display_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('company_team_members');
    }
};
