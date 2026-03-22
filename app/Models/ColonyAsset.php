<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $colony_id
 * @property int $asset_id
 * @property int $xp
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read \App\Models\Asset $asset
 * @property-read \App\Models\Colony $colony
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColonyAsset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColonyAsset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColonyAsset query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColonyAsset whereAssetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColonyAsset whereColonyId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColonyAsset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColonyAsset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColonyAsset whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ColonyAsset whereXp($value)
 * @mixin \Eloquent
 */
#[Table('colony_asset')]
#[Fillable(['colony_id', 'asset_id', 'xp'])]
class ColonyAsset extends Model
{
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
