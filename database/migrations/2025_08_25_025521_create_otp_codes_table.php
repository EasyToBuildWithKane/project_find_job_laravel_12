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
        Schema::create('otp_codes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->nullable()->constrained('users')->onDelete('cascade');

            $table->string('otp', 10);
            $table->string('context', 50)->index();
            $table->string('delivery_method', 20)->default('email');

            $table->unsignedTinyInteger('attempts')->default(0);
            $table->timestamp('expires_at');

            $table->boolean('is_used')->default(false);
            $table->timestamp('used_at')->nullable();

            $table->ipAddress('sent_to_ip')->nullable();
            $table->timestamps();

            $table->index(['user_id', 'context', 'is_used']);
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('otp_codes');
    }
};
