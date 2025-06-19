<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;

/**
 *
 *
 * @property string $id
 * @property string $title
 * @property string $description
 * @property int $duration
 * @property int $release_date
 * @property string $maturity_rating
 * @property string $backdrop
 * @property string $video
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Genre> $genres
 * @property-read int|null $genres_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie filter($filters)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereBackdrop($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereDuration($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereMaturityRating($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereReleaseDate($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereTitle($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Movie whereVideo($value)
 * @mixin \Eloquent
 */
class Movie extends Model
{
    //
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = [
        'id',
        'title',
        'description',
        'duration',
        'release_date',
        'maturity_rating',
        'backdrop',
        'video',
    ];
    public $timestamps = false;

    public function genres()
    {
        return $this->belongsToMany(Genre::class);
    }
}
