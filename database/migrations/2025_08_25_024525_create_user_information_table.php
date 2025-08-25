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
        Schema::create('user_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->foreignId('user_id')->unique()->constrained('users')->onDelete('cascade');

            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('full_name', 200)->nullable()->index();
            $table->date('dob')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();

            $table->string('address_line1', 150)->nullable();
            $table->string('address_line2', 150)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country_code', 10)->nullable();

            $table->string('timezone', 50)->nullable();
            $table->string('language', 10)->default('en');

            $table->string('avatar_url', 255)->nullable();
            $table->string('cover_image_url', 255)->nullable();

            $table->enum('kyc_status', ['pending', 'verified', 'rejected'])->nullable();
            $table->timestamp('kyc_submitted_at')->nullable();
            $table->foreignId('kyc_verified_by')->nullable()->constrained('users')->nullOnDelete();

            $table->string('referral_code', 50)->nullable();
            $table->foreignId('referred_by')->nullable()->constrained('users')->nullOnDelete();

            $table->boolean('marketing_opt_in')->default(false);
            $table->timestamp('privacy_policy_accepted_at')->nullable();
            $table->timestamp('terms_accepted_at')->nullable();
            $table->timestamp('last_password_change_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_information');
    }
};
