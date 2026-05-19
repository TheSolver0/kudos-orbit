<?php

namespace Database\Seeders;

use App\Models\Direction;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    private static array $avatarsMen = [
        'https://i.pinimg.com/1200x/ff/d5/1c/ffd51c259d9fd07370309cd93f031adb.jpg',
        'https://i.pinimg.com/1200x/52/99/d3/5299d3a179231855a17467619e18ae02.jpg',
        'https://i.pinimg.com/1200x/74/61/3b/74613b9a25935ee4d89d5ba08505c8ed.jpg',
        'https://i.pinimg.com/1200x/8f/23/44/8f23447418ff5e3e048ad43742eaf93a.jpg',
        'https://i.pinimg.com/1200x/69/05/23/690523b4ed80d7aebd12e3e28ac23584.jpg',
    ];

    private static array $avatarsWomen = [
        'https://i.pinimg.com/1200x/0a/de/79/0ade7978a78e1880decc809bdd382f60.jpg',
        'https://i.pinimg.com/1200x/a3/8b/76/a38b76a2832e89a3e132d2058a387385.jpg',
        'https://i.pinimg.com/1200x/b5/92/07/b5920724ed2120a34e511b75a06bdde2.jpg',
        'https://i.pinimg.com/1200x/70/60/d8/7060d80bb20205640417494f8d641462.jpg',
        'https://i.pinimg.com/1200x/f7/18/a7/f718a7c6290bcacf48f118915e6b9c5b.jpg',
    ];

    private static array $feminineFirstNames = [
        'Evodie',
        'Marie',
    ];

    private static function pickAvatar(string $firstName, int $index): string
    {
        $isFeminine = in_array($firstName, self::$feminineFirstNames, true);

        $pool = $isFeminine
            ? self::$avatarsWomen
            : self::$avatarsMen;

        return $pool[$index % count($pool)];
    }

    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator',
                'email' => 'lucfotso0@gmail.com',
                // 'phone' => '690048482',
                'role' => 'Super Administrateur',
                'department' => 'Administration',
            ],

            [
                'name' => 'Evodie NGONDA',
                'email' => 'evodie.ngonda.orbitclans@outlook.com',
                // 'phone' => '681457453',
                'role' => 'Assistante',
                'department' => 'Administration',
            ],

            [
                'name' => 'FOTSO Luc',
                'email' => 'luc.fotso.orbitclans@outlook.com',
                // 'phone' => '690048482',
                'role' => 'Développeur',
                'department' => 'DSI',
            ],

            [
                'name' => 'M. LOMIE Kenny',
                'email' => 'kenny.lomie.orbitclans@outlook.com',
                // 'phone' => '656818751',
                'role' => 'CEO',
                'department' => 'Administration',
            ],

            [
                'name' => 'M. SANAMA Ferdinand',
                'email' => 'ferdinand.sanama.orbitclans@outlook.com',
                // 'phone' => '690048482',
                'role' => 'CEO',
                'department' => 'Direction Générale',
            ],

            [
                'name' => 'NGO TONYE Marie',
                'email' => 'marie.tonye.orbitclans@outlook.com',
                // 'phone' => '690048482',
                'role' => 'Collaboratrice',
                'department' => 'Administration',
            ],

            [
                'name' => 'NOGNANI David',
                'email' => 'david.nonagni.orbitclans@outlook.com',
                // 'phone' => '690048482',
                'role' => 'Stagiaire Académique',
                'department' => 'DSI',
            ],

            [
                'name' => 'Ryan Diogne',
                'email' => 'ryandiogne3@gmail.com',
                // 'phone' => '690048482',
                'role' => 'Collaborateur',
                'department' => 'Administration',
            ],
            [
                'name' => 'SIBAFO Salomon',
                'email' => 'salomon.sibafo.orbitclans@outlook.com',
                // 'phone' => '674727292',
                'role' => 'Collaborateur',
                'department' => 'Administration',
            ],

            [
                'name' => 'TAPTUE Dilane',
                'email' => 'dilane.taptue.orbitclans@outlook.com',
                // 'phone' => '690048482',
                'role' => 'Collaborateur',
                'department' => 'Administration',
            ],

            [
                'name' => 'YOUBOU ANDERSON',
                'email' => 'anderson.youbou.orbitclans@outlook.com',
                // 'phone' => '696720639',
                'role' => 'Collaborateur',
                'department' => 'Administration',
            ],
        ];

        foreach ($users as $index => $data) {

            $direction = Direction::firstOrCreate(
                [
                    'code' => Str::slug($data['department'] ?? 'GEN', '_'),
                ],
                [
                    'name' => $data['department'] ?? 'Général',
                ]
            );

            $firstName = explode(' ', trim($data['name']))[0];

            $user = User::updateOrCreate(
                [
                    'email' => $data['email'],
                ],
                [
                    'name' => $data['name'],
                    // 'phone' => $data['phone'],
                    'role' => $data['role'],
                    'direction_id' => $direction->id,
                    'points_total' => random_int(100, 2500),
                    'password' => Hash::make('password'),
                    'avatar' => self::pickAvatar($firstName, $index),
                    'email_verified_at' => now(),
                ]
            );

            /*
            |--------------------------------------------------------------------------
            | Attribution automatique des rôles
            |--------------------------------------------------------------------------
            |
            | Managers :
            | - Kenny
            | - Ferdinand
            | - Evodie
            | - Luc
            | - Dilane
            |
            | Admins :
            | - Kenny
            | - Ferdinand
            | - Luc
            | - Dilane
            |
            */

            $managerNames = [
                'M. LOMIE Kenny',
                'M. SANAMA Ferdinand',
                'Evodie NGONDA',
                'FOTSO Luc',
                'TAPTUE Dilane',
            ];

            $adminNames = [
                'M. LOMIE Kenny',
                'M. SANAMA Ferdinand',
                'FOTSO Luc',
                'TAPTUE Dilane',
            ];

            $roles = ['employee'];

            if (in_array($data['name'], $managerNames, true)) {
                $roles[] = 'manager';
            }

            if (in_array($data['name'], $adminNames, true)) {
                $roles[] = 'admin';
            }

            $user->syncRoles($roles);
        }
    }
}
