<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovieSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('movies')->insert([
            [
                'title'        => 'Eternal Horizon',
                'description'  => 'A breathtaking sci-fi epic about humanity\'s last colony ship drifting through deep space, where the crew discovers an ancient alien signal that could change everything.',
                'duration'     => 142,
                'genre'        => 'Sci-Fi',
                'release_date' => '2025-03-15',
                'poster'       => '/assets/posters/eternal-horizon.jpg',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'title'        => 'Shadow Protocol',
                'description'  => 'A gripping spy thriller where a disgraced intelligence officer uncovers a conspiracy that reaches the highest levels of government — and must go rogue to stop it.',
                'duration'     => 118,
                'genre'        => 'Thriller',
                'release_date' => '2025-04-22',
                'poster'       => '/assets/posters/shadow-protocol.jpg',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'title'        => 'Ember Falls',
                'description'  => 'A heartwarming drama about two strangers who meet in a small mountain town during the first snowfall of winter, each carrying secrets that will forever bind their lives.',
                'duration'     => 105,
                'genre'        => 'Drama',
                'release_date' => '2025-05-10',
                'poster'       => '/assets/posters/ember-falls.jpg',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'title'        => 'Iron Veil',
                'description'  => 'In a dystopian future where AI controls every aspect of life, one engineer discovers a flaw in the system and must decide whether to exploit it — or destroy it.',
                'duration'     => 133,
                'genre'        => 'Action',
                'release_date' => '2025-06-05',
                'poster'       => '/assets/posters/iron-veil.jpg',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
            [
                'title'        => 'The Last Cartographer',
                'description'  => 'An adventure tale following a young mapmaker who stumbles upon an uncharted island filled with ancient ruins, hidden treasure, and dangers no map could ever prepare her for.',
                'duration'     => 124,
                'genre'        => 'Adventure',
                'release_date' => '2025-07-18',
                'poster'       => '/assets/posters/last-cartographer.jpg',
                'created_at'   => now(),
                'updated_at'   => now(),
            ],
        ]);
    }
}
