<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * 
 *
 * @property int $id
 * @property string $city_id
 * @property int $asset_id
 * @property int $xp
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\Asset $asset
 * @property-read \App\Models\City $city
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CityAsset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CityAsset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CityAsset query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CityAsset whereAssetId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CityAsset whereCityId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CityAsset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CityAsset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CityAsset whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|CityAsset whereXp($value)
 * @mixin \Eloquent
 */
class CityAsset extends Model
{
    protected $table = 'city_asset';

    protected $fillable = [
        'city_id',
        'asset_id',
        'xp',
    ];

    // Relations
    public function city(): BelongsTo
    {
        return $this->belongsTo(City::class);
    }

    public function asset(): BelongsTo
    {
        return $this->belongsTo(Asset::class);
    }
}
