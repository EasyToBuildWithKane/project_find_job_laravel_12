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
        Schema::create('users', function (Blueprint $table) {
   
            $table->id();

            $table->string('username', 100)->unique();
            $table->string('email', 150)->unique()->nullable();
            $table->string('phone', 20)->unique()->nullable();
            $table->string('password');
            $table->enum('role', ['freelancer', 'employer', 'admin'])->default('freelancer');
            $table->enum('status', ['active', 'suspended', 'deleted'])->default('active');

            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('phone_verified_at')->nullable();

            $table->string('last_login_ip', 45)->nullable();
            $table->timestamp('last_login_at')->nullable();

            $table->boolean('two_factor_enabled')->default(false);
            $table->text('two_factor_secret')->nullable();

            $table->unsignedTinyInteger('failed_login_attempts')->default(0);
            $table->timestamp('last_failed_login_at')->nullable();

            // ========== Thông tin cá nhân ==========
            $table->string('first_name', 100)->nullable();
            $table->string('last_name', 100)->nullable();
            $table->string('full_name', 200)->nullable()->index();
            $table->date('dob')->nullable();
            $table->enum('gender', ['male', 'female', 'other'])->nullable();

            $table->string('address_line', 150)->nullable();
            $table->string('link_social', 150)->nullable();
            $table->string('city', 100)->nullable();
            $table->string('state', 100)->nullable();
            $table->string('postal_code', 20)->nullable();
            $table->string('country_code', 10)->nullable();

            $table->string('timezone', 50)->nullable();
            $table->string('language', 10)->default('en');

            $table->string('avatar_url', 255)->nullable();
            $table->string('cover_image_url', 255)->nullable();

    
            $table->rememberToken();
            $table->softDeletes();
            $table->timestamps();

            // Indexes
            $table->index(['email', 'phone']);
            $table->index(['last_login_at']);
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->integer('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('sessions');
    }
};
