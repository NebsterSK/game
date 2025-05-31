<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * 
 *
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int $xp
 * @property int|null $parent_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\CityAsset> $cities
 * @property-read int|null $cities_count
 * @property-read \App\Models\CityAsset|null $cityAsset
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereParentId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Asset whereXp($value)
 * @mixin \Eloquent
 */
class Asset extends Model
{
    protected $fillable = [
        'name',
        'type',
        'xp',
        'parent_id',
    ];

    // Relations
    public function cities(): BelongsToMany
    {
        return $this->belongsToMany(CityAsset::class, 'city_asset')->withPivot(['xp']);
    }

    public function cityAsset(): HasOne
    {
        return $this->hasOne(CityAsset::class);
    }
}
