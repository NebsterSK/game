<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cities', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name', 20);
            $table->unsignedInteger('turn')->nullable(false)->default(0);
            $table->unsignedInteger('population')->nullable(false)->default(100);
            $table->unsignedInteger('builders')->nullable(false)->default(0);
            $table->unsignedInteger('engineers')->nullable(false)->default(0);
            $table->unsignedInteger('scientists')->nullable(false)->default(0);
            $table->unsignedBigInteger('user_id');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cities');
    }
};
