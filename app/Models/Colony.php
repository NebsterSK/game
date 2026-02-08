<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property string $id
 * @property string $name
 * @property int $turn
 * @property int $population
 * @property int $builders
 * @property int $engineers
 * @property int $scientists
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\ColonyAsset> $colonyAssets
 * @property-read int|null $colony_assets_count
 * @property-read \App\Models\User $user
 *
 * @method static \Database\Factories\ColonyFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colony newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colony newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colony query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colony whereBuilders($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colony whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colony whereEngineers($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colony whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colony whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colony wherePopulation($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colony whereScientists($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colony whereTurn($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colony whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Colony whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Colony extends Model
{
    /** @use HasFactory<\Database\Factories\ColonyFactory> */
    use HasFactory;

    use HasUuids;

    protected $fillable = [
        'turn',
        'population',
        'builders',
        'engineers',
        'scientists',
    ];

    // Relations
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    //    public function assets(): BelongsToMany
    //    {
    //        return $this->belongsToMany(Asset::class, 'colony_asset')->withPivot(['xp']);
    //    }

    public function colonyAssets(): HasMany
    {
        return $this->hasMany(ColonyAsset::class);
    }
}
