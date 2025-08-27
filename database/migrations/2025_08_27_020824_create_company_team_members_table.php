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
        Schema::create('company_team_members', function (Blueprint $table) {
            $table->id();
            $table->string('full_name'); // VD: Arlene McCoy
            $table->string('job_title'); // VD: Frontend Developer
            $table->string('department')->nullable(); // VD: Engineering, Marketing
            $table->string('location')->nullable(); // VD: New York, US
            $table->string('profile_image_url')->nullable();
            $table->unsignedTinyInteger('rating')->default(5);
            $table->unsignedInteger('review_count')->default(0);
            $table->json('social_links')->nullable(); // {"facebook": "...", "linkedin": "..."}
            $table->boolean('is_featured')->default(false); // nếu cần highlight
            $table->unsignedInteger('display_order')->default(0); // sắp xếp
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_team_members');
    }
};
