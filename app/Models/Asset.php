<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property int $id
 * @property string $name
 * @property string $type
 * @property int $xp
 * @property int|null $parent_id
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ColonyAsset> $colonies
 * @property-read int|null $colonies_count
 * @property-read \App\Models\ColonyAsset|null $colonyAsset
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
    public function colonies(): BelongsToMany
    {
        return $this->belongsToMany(ColonyAsset::class, 'colony_asset')->withPivot(['xp']);
    }

    public function colonyAsset(): HasOne
    {
        return $this->hasOne(ColonyAsset::class);
    }
}
