<?php

namespace Database\Seeders;

use App\Models\Country;
use App\Models\League;
use App\Models\Player;
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
            'email' => 'breno.souza@bild.com.br',
            'email_verified_at' => now(),
            'password' => Hash::make('aaaaaaaa'),
            'remember_token' => 'fsdfasdfasdfdsfasdhdfhj',
        ]);

        $this->createCountries();
        $this->createLeagues();
        $this->createTeams();
        $this->createPlayers();
        $this->createStadia();
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

    public function createLeagues()
    {
        $leagues = [
            ['id' => 1, 'name' => 'Champions League'],
            ['id' => 2, 'name' => 'Euro League'],
            ['id' => 3, 'name' => 'Libertadores'],
        ];

        foreach ($leagues as $key => $value) {
            League::create($value);
        }
    }

    public function createTeams()
    {
        $teams = [
            ['id' => 1, 'name' => 'Real Madrid', 'country_id' => 6],
            ['id' => 2, 'name' => 'Juventus', 'country_id' => 7],
            ['id' => 3, 'name' => 'PSG', 'country_id' => 2],
        ];

        foreach ($teams as $key => $value) {
            $teamCreated = Team::create($value);
            $teamCreated->leagues()->sync([1]);
        }
    }

    public function createPlayers()
    {
        $players = [
            [
                'name' => 'Cristiano Ronaldo',
                'country_id' => 5,
                'team_id' => 2,
                'position' => 'ATA'
            ],
            [
                'name' => 'Neymar',
                'country_id' => 1,
                'team_id' => 3,
                'position' => 'ATA'
            ],
            [
                'name' => 'Kroos',
                'country_id' => 3,
                'team_id' => 1,
                'position' => 'VOL'
            ],
            [
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
}
