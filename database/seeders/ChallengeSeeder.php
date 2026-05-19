<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ChallengeSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = User::query()
            ->whereHas('roles', fn ($q) => $q->where('name', 'admin'))
            ->value('id');

        $managerId = User::query()
            ->whereHas('roles', fn ($q) => $q->where('name', 'manager'))
            ->value('id');

        $employeeId = User::query()->value('id');

        $defaultCreatorId = $adminId
            ?? $managerId
            ?? $employeeId;

        if (! $defaultCreatorId) {
            return;
        }

        DB::table('challenges')->truncate();

        DB::table('challenges')->insert([

            /*
            |--------------------------------------------------------------------------
            | CHALLENGES EN COURS
            |--------------------------------------------------------------------------
            */

            [
                'id' => 1,
                'name' => 'Challenge Innovation',
                'description' => 'Chaque collaborateur est invité à proposer une idée innovante pouvant améliorer un produit, automatiser une tâche interne, optimiser les performances ou améliorer l’expérience utilisateur. Les meilleures propositions seront étudiées et intégrées dans la roadmap produit.',
                'cover_image' => 'https://i1-e.pinimg.com/1200x/86/de/25/86de25bf5b2b497bb8be816e43e60bc0.jpg',
                'category' => 'innovation',
                'start_date' => '2026-05-01',
                'end_date' => '2026-06-15',
                'points_bonus' => 500,
                'status' => 'active',
                'for_all' => 1,
                'created_by' => $adminId ?? $defaultCreatorId,
                'division_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            [
                'id' => 2,
                'name' => 'Challenge Designer',
                'description' => 'Les designers UX/UI de l’entreprise sont challengés à produire les meilleures interfaces modernes et intuitives pour les projets internes. Les créations seront évaluées sur la créativité, l’ergonomie, la cohérence visuelle et l’expérience utilisateur.',
                'cover_image' => 'https://i1-e.pinimg.com/1200x/16/43/3d/16433da943b3c7475072bc64480f49a1.jpg',
                'category' => 'design',
                'start_date' => '2026-05-05',
                'end_date' => '2026-06-05',
                'points_bonus' => 400,
                'status' => 'active',
                'for_all' => 1,
                'created_by' => $managerId ?? $defaultCreatorId,
                'division_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ],

            /*
            |--------------------------------------------------------------------------
            | ANCIENS CHALLENGES
            |--------------------------------------------------------------------------
            */

            [
                'id' => 3,
                'name' => 'Hackathon Interne API Performance',
                'description' => 'Challenge interne autour de l’optimisation backend et de la performance API. Les équipes ayant réduit le temps de réponse des services critiques ont été récompensées.',
                'cover_image' => 'https://i1-e.pinimg.com/1200x/cf/8b/53/cf8b5331b1fdddb23b0f229dbf66324b.jpg',
                'category' => 'performance',
                'start_date' => '2026-02-10',
                'end_date' => '2026-03-10',
                'points_bonus' => 350,
                'status' => 'finished',
                'for_all' => 0,
                'created_by' => $adminId ?? $defaultCreatorId,
                'division_id' => null,
                'created_at' => '2026-02-10 10:00:00',
                'updated_at' => '2026-03-10 18:00:00',
            ],

            [
                'id' => 4,
                'name' => 'Sprint Qualité Frontend',
                'description' => 'Défi consacré à l’amélioration de la qualité frontend : correction de bugs UI, responsive design et accessibilité des applications web et mobile.',
                'cover_image' => 'https://i1-e.pinimg.com/1200x/6b/c5/98/6bc5985439df332a6857b552a3d72135.jpg',
                'category' => 'qualite',
                'start_date' => '2026-01-15',
                'end_date' => '2026-02-01',
                'points_bonus' => 250,
                'status' => 'finished',
                'for_all' => 1,
                'created_by' => $managerId ?? $defaultCreatorId,
                'division_id' => null,
                'created_at' => '2026-01-15 08:00:00',
                'updated_at' => '2026-02-01 18:00:00',
            ],

            [
                'id' => 5,
                'name' => 'Challenge Cybersécurité',
                'description' => 'Compétition interne autour des bonnes pratiques de cybersécurité : détection de failles, sécurisation des endpoints et amélioration des politiques d’accès.',
                'cover_image' => 'https://i1-e.pinimg.com/1200x/ab/b0/df/abb0dfa57c91867c3b9dc324ddf081cc.jpg',
                'category' => 'security',
                'start_date' => '2025-11-20',
                'end_date' => '2025-12-20',
                'points_bonus' => 600,
                'status' => 'finished',
                'for_all' => 0,
                'created_by' => $adminId ?? $defaultCreatorId,
                'division_id' => null,
                'created_at' => '2025-11-20 09:00:00',
                'updated_at' => '2025-12-20 18:00:00',
            ],

            [
                'id' => 6,
                'name' => 'Challenge Collaboration Produit',
                'description' => 'Défi inter-équipes visant à améliorer la collaboration entre développeurs, designers et product managers autour des projets stratégiques.',
                'cover_image' => 'https://i1-e.pinimg.com/1200x/ae/d8/f5/aed8f5fa4f7e0c3ccdeb0e5c332d930a.jpg',
                'category' => 'collaboration',
                'start_date' => '2026-03-01',
                'end_date' => '2026-04-01',
                'points_bonus' => 300,
                'status' => 'finished',
                'for_all' => 1,
                'created_by' => $managerId ?? $defaultCreatorId,
                'division_id' => null,
                'created_at' => '2026-03-01 08:00:00',
                'updated_at' => '2026-04-01 18:00:00',
            ],

        ]);
    }
}