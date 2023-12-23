<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {    //fffffff
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->boolean('is_accepted')->default(false);
            $table->boolean('is_blocked')->default(false);
            $table->string('email')->unique();
            $table->string('social_link');
            $table->string('image');
            // $table->foreignId('user_id');
            $table->enum('role',['user','admin','teacher']);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
