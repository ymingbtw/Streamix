<?php

// @formatter:off
// phpcs:ignoreFile
/**
 * A helper file for your Eloquent Models
 * Copy the phpDocs from this file to the correct Model,
 * And remove them from this file, to prevent double declarations.
 *
 * @author Barry vd. Heuvel <barryvdh@gmail.com>
 */


namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $name
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actor newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actor newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actor query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actor whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Actor whereName($value)
 * @mixin \Eloquent
 */
	class Actor extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $actor_id
 * @property string $movie_id
 * @property string $character
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActorMovie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActorMovie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActorMovie query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActorMovie whereActorId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActorMovie whereCharacter($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|ActorMovie whereMovieId($value)
 * @mixin \Eloquent
 */
	class ActorMovie extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property int $id
 * @property string $genre
 * @property-read \Illuminate\Database\Eloquent\Collection<int, \App\Models\Movie> $movies
 * @property-read int|null $movies_count
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Genre newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Genre newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Genre query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Genre whereGenre($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Genre whereId($value)
 * @mixin \Eloquent
 */
	class Genre extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GenreMovie newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GenreMovie newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|GenreMovie query()
 * @mixin \Eloquent
 */
	class GenreMovie extends \Eloquent {}
}

namespace App\Models{
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
	class Movie extends \Eloquent {}
}

namespace App\Models{
/**
 * 
 *
 * @property string $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection<int, \Illuminate\Notifications\DatabaseNotification> $notifications
 * @property-read int|null $notifications_count
 * @method static \Database\Factories\UserFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|User wherePassword($value)
 * @mixin \Eloquent
 */
	class User extends \Eloquent {}
}

