<?php

namespace Database\Seeders;

use App\Models\Competition;
use App\Models\Country;
use App\Models\Game;
use App\Models\Goal;
use App\Models\Player;
use App\Models\Scoreboard;
use App\Models\Stadium;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Breno',
            'email' => 'aaaa@aaaa',
            'email_verified_at' => now(),
            'password' => Hash::make('aaaa'),
            'remember_token' => 'fsdfasdfasdfdsfasdhdfhj',
        ]);

        $this->createCountries();
        $this->createCompetitions();
        $this->createTeams();
        $this->createPlayers();
        $this->createStadia();
        $this->createGames();
        $this->createScoreboards();
        $this->createGoals();
    }

    public function createCountries()
    {
        $coutries = [
            ['id' => 1, 'name' => 'Brasil'],
            ['id' => 2, 'name' => 'França'],
            ['id' => 3, 'name' => 'Alemanha'],
            ['id' => 4, 'name' => 'Inglaterra'],
            ['id' => 5, 'name' => 'Portugal'],
            ['id' => 6, 'name' => 'Espanha'],
            ['id' => 7, 'name' => 'Itália']
        ];

        foreach ($coutries as $key => $value) {
            Country::create($value);
        }
    }

    public function createCompetitions()
    {
        $competition = [
            [
                'id' => 1,
                'name' => 'Champions League',
                'season' => '2021/2022',
                'active' => 1,
                'name_photo' => '20210309130415champions-league.jpg'
            ],
            [
                'id' => 2,
                'name' => 'Euro League',
                'season' => '2021/2022',
                'active' => 1,
                'name_photo' => '20210309130455uefa-euro.jpg'
            ],
            [
                'id' => 3,
                'name' => 'Libertadores',
                'season' => '2021',
                'active' => 1,
                'name_photo' => '20210309130613libertadores.png'
            ],
        ];

        foreach ($competition as $key => $value) {
            Competition::create($value);
        }
    }

    public function createTeams()
    {
        $teams = [
            ['id' => 1, 'name' => 'Real Madrid', 'country_id' => 6, 'name_photo' => '20210305142008real.jpg'],
            ['id' => 2, 'name' => 'Juventus', 'country_id' => 7, 'name_photo' => '20210304003317juventus.png'],
            ['id' => 3, 'name' => 'PSG', 'country_id' => 2, 'name_photo' => '20210304003317psg.png'],
        ];

        foreach ($teams as $key => $value) {
            $teamCreated = Team::create($value);
            $teamCreated->competitions()->sync([1]);
        }
    }

    public function createPlayers()
    {
        $players = [
            [
                'id' => 1,
                'name' => 'Cristiano Ronaldo',
                'country_id' => 5,
                'team_id' => 2,
                'position' => 'ATA'
            ],
            [
                'id' => 2,
                'name' => 'Neymar',
                'country_id' => 1,
                'team_id' => 3,
                'position' => 'ATA'
            ],
            [
                'id' => 3,
                'name' => 'Kroos',
                'country_id' => 3,
                'team_id' => 1,
                'position' => 'VOL'
            ],
            [
                'id' => 4,
                'name' => 'Sergio Ramos',
                'country_id' => 6,
                'team_id' => 1,
                'position' => 'ZAG'
            ],
        ];

        foreach ($players as $key => $value) {
            Player::create($value);
        }
    }

    public function createStadia()
    {
        $stadia = [
            ['id' => 1, 'name' => 'Santiago Bernabeu', 'country_id' => 6],
            ['id' => 2, 'name' => 'San Siro', 'country_id' => 7],
        ];

        foreach ($stadia as $key => $value) {
            Stadium::create($value);
        }
    }

    public function createGames()
    {
        $games = [
            [
                'id' => 1,
                'date' => now(),
                'time' => now(),
                'status' => 'open',
                'team_home_id' => 1,
                'team_guest_id' => 2,
                'stadium_id' => 1,
                'competition_id' => 1,
                'stage' => 'oitavas'
            ],
            [
                'id' => 2,
                'date' => now(),
                'time' => now(),
                'status' => 'finished',
                'team_home_id' => 2,
                'team_guest_id' => 3,
                'stadium_id' => 2,
                'competition_id' => 1,
                'stage' => 'oitavas'
            ],
        ];

        foreach ($games as $key => $value) {
            Game::create($value);
        }
    }

    public function createScoreboards()
    {
        $scoreboards = [
            [
                'id' => 1,
                'type'  => 'official',
                'game_id' => 1,
                'team_home_scoreboard' => 1,
                'team_guest_scoreboard' => 0
            ],
        ];

        foreach ($scoreboards as $key => $value) {
            Scoreboard::create($value);
        }
    }

    public function createGoals()
    {
        $goals = [
            [
                'id' => 1,
                'player_id' => 4,
                'team_id' => 1,
                'scoreboard_id' => 1,
            ],
        ];

        foreach ($goals as $key => $value) {
            Goal::create($value);
        }
    }
}
