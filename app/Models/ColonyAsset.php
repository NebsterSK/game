<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $colony_id
 * @property int $asset_id
 * @property int $xp
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Asset $asset
 * @property-read \App\Models\Colony $colony
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColonyAsset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColonyAsset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColonyAsset query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColonyAsset whereAssetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColonyAsset whereColonyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColonyAsset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColonyAsset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColonyAsset whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColonyAsset whereXp($value)
 *
 * @mixin \Eloquent
 */
class ColonyAsset extends Model
{
    protected $table = 'colony_asset';

    protected $fillable = [
        'colony_id',
        'asset_id',
        'xp',
    ];

    // Relations
    public function colony(): BelongsTo
    {
        return $this->belongsTo(Colony::class);
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
