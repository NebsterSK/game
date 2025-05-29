<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('city_asset', function (Blueprint $table) {
            $table->id();
            $table->uuid('city_id');
            $table->unsignedBigInteger('asset_id');
            $table->unsignedInteger('xp')->default(0);
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('asset_id')->references('id')->on('assets')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('city_asset');
    }
};
