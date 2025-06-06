<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('colony_asset', function (Blueprint $table) {
            $table->id();
            $table->uuid('colony_id');
            $table->unsignedBigInteger('asset_id');
            $table->unsignedInteger('xp')->default(0);
            $table->timestamps();

            $table->unique(['colony_id', 'asset_id']);
            $table->foreign('colony_id')->references('id')->on('colonies')->cascadeOnUpdate()->cascadeOnDelete();
            $table->foreign('asset_id')->references('id')->on('assets')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('colony_asset');
    }
};
