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
    {
        Schema::create('register_invites', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('control_number')->unique();
            $table->string('company')->nullable();
            $table->string('title')->nullable();
            $table->string('attending')->nullable();
            $table->text('notes')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('register_invites');
    }
};
