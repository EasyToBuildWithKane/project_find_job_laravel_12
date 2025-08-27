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
        Schema::create('company_profiles', function (Blueprint $table) {
            $table->id();
            $table->string('section_key')->unique(); // ví dụ: 'about', 'vision', 'mission'
            $table->string('headline')->nullable(); // Our Company
            $table->string('title'); // About Our Company
            $table->text('summary')->nullable(); // mô tả ngắn
            $table->longText('body')->nullable(); // nội dung chính (HTML/Markdown)
            $table->string('featured_image_url')->nullable();
            $table->string('cta_label')->nullable(); // Read More
            $table->string('cta_link')->nullable(); // URL của CTA            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_profiles');
    }
};
