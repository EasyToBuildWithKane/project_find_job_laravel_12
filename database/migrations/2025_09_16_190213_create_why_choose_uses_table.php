<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('why_choose_us', function (Blueprint $table) {
            $table->id();
            $table->string('section_title', 255)->nullable(); // VD: "Why choose us"
            $table->string('section_subtitle', 255)->nullable(); // VD: "You will find your ideal candidates…"
            $table->string('item_title', 255); // VD: "Cost Effective"
            $table->text('item_description')->nullable(); // mô tả item
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('why_choose_us');
    }
};
