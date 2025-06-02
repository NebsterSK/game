<?php

use App\Enums\AssetType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable(false);
            $table->enum('type', ['building', 'technology', 'research'])->nullable(false);
            $table->unsignedInteger('xp')->nullable(false)->default(100);
            $table->unsignedBigInteger('parent_id')->nullable();
        });

        DB::table('assets')->insert([
            [
                'id' => 1,
                'name' => 'Housing',
                'type' => AssetType::Building->value,
                'xp' => 100,
                'parent_id' => null,
            ],
            [
                'id' => 2,
                'name' => 'Workshop',
                'type' => AssetType::Building->value,
                'xp' => 200,
                'parent_id' => 1,
            ],
            [
                'id' => 3,
                'name' => 'Laboratory',
                'type' => AssetType::Building->value,
                'xp' => 250,
                'parent_id' => 1,
            ],
            [
                'id' => 4,
                'name' => 'Power generator',
                'type' => AssetType::Technology->value,
                'xp' => 350,
                'parent_id' => null,
            ],
            [
                'id' => 5,
                'name' => 'Antena',
                'type' => AssetType::Technology->value,
                'xp' => 50,
                'parent_id' => 4,
            ],
            [
                'id' => 6,
                'name' => 'Telescope',
                'type' => AssetType::Technology->value,
                'xp' => 80,
                'parent_id' => 4,
            ],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
