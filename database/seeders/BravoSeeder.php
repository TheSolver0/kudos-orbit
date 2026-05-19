<?php

namespace Database\Seeders;

use App\Models\Bravo;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;

/**
 * BravoSeeder
 * -----------
 * Génère ~120 bravos réalistes entre les utilisateurs existants.
 *
 * Prérequis :
 *   - UserSeeder doit avoir tourné (on récupère les users en base)
 *   - La table `bravos` doit exister avec au minimum :
 *       sender_id, receiver_id, message, points, created_at
 *
 * Lancement :
 *   php artisan db:seed --class=BravoSeeder
 *
 * Ou ajoutez dans DatabaseSeeder::run() :
 *   $this->call(BravoSeeder::class);
 */
class BravoSeeder extends Seeder
{
    // ── Messages de bravo variés (contexte entreprise camerounaise) ──
    private static array $messages = [
    "Excellent travail sur la livraison du projet client, le résultat est vraiment impressionnant !",
    "Merci pour ton aide précieuse pendant la réunion stratégique avec le client. Tu as été remarquable.",
    "Tu as géré cette mission avec beaucoup de professionnalisme. Kudos !",
    "Ton implication dans le développement de cette solution digitale est remarquable. Continue ainsi !",
    "Merci pour ta réactivité et ta disponibilité sur ce sprint. Toute l’équipe apprécie.",
    "Félicitations pour la démo produit d’hier. Le client a été très satisfait.",
    "Tu as assuré un support technique exemplaire pendant la phase critique du déploiement.",
    "Ton sens de l’initiative a permis de débloquer le projet rapidement. Merci !",
    "La qualité de ton travail sur cette architecture logicielle mérite d’être saluée. Kudos !",
    "Merci d’avoir accompagné les nouveaux collaborateurs avec autant d’énergie et de bienveillance.",
    "Ton compte rendu technique était clair, structuré et très professionnel. Félicitations.",
    "Tu es toujours prêt(e) à aider l’équipe sur les tâches complexes. C’est une vraie force chez Orbit.",
    "Kudos pour avoir respecté les délais sur un projet aussi exigeant !",
    "Ton calme et ta rigueur pendant l’incident de production ont été déterminants. Merci.",
    "Je voulais simplement te dire que ton travail est remarqué et apprécié à sa juste valeur.",
    "Tu as représenté Orbit avec beaucoup de professionnalisme lors de cette présentation client.",
    "Kudos pour l’organisation irréprochable de notre workshop digital.",
    "Merci d’avoir géré les retours clients avec autant de patience et d’efficacité.",
    "Ton engagement dépasse clairement les attentes. C’est vraiment apprécié.",
    "Tu es une source d’inspiration pour toute l’équipe. Continue comme ça !",
    "Félicitations pour cette évolution bien méritée au sein de l’équipe Orbit.",
    "Ton expertise technique a sauvé le projet à un moment critique. Merci pour ton professionnalisme.",
    "Merci pour ton écoute et ton soutien pendant cette période intense du projet.",
    "Ton travail sur la base de données et les optimisations backend a énormément aidé l’équipe.",
    "Kudos pour avoir livré cette fonctionnalité avant la deadline. C’est rare et très apprécié !",
    "Ton design UI/UX a considérablement amélioré l’expérience utilisateur de la plateforme.",
    "Merci pour les optimisations apportées à l’API. Les performances sont nettement meilleures.",
    "Ton esprit d’équipe pendant ce hackathon interne a fait toute la différence.",
    "Le client a particulièrement apprécié ton professionnalisme et ta capacité à proposer des solutions pertinentes.",
    "Kudos pour la qualité du code livré. La review technique était excellente.",
    "Ton travail sur l’identité visuelle du produit apporte une vraie valeur à Orbit.",
    "Merci d’avoir pris l’initiative de documenter tout le workflow technique pour l’équipe.",
    "Tu as su transformer une idée complexe en une solution digitale simple et efficace.",
    "Ton implication dans la réussite du projet est clairement visible. Excellent travail !",
    "Merci pour ta disponibilité même sous pression. C’est très apprécié par toute l’équipe.",
];

    // ── Valeurs de points possibles ──────────────────────────────────
    private static array $pointValues = [10, 20, 25, 30, 50, 75, 100];

    public function run(): void
    {
        $users = User::all();

        if ($users->count() < 2) {
            $this->command->warn('Pas assez d\'utilisateurs pour générer des bravos. Lancez d\'abord UserSeeder.');
            return;
        }

        $userIds = $users->pluck('id')->toArray();
        $total   = 0;

        // Générer ~6 bravos par utilisateur (en tant qu'expéditeur)
        foreach ($userIds as $senderId) {
            $nbBravos = random_int(4, 8);

            // Destinataires potentiels : tout le monde sauf l'expéditeur
            $potentialReceivers = array_values(array_filter($userIds, fn($id) => $id !== $senderId));
            shuffle($potentialReceivers);
            $receivers = array_slice($potentialReceivers, 0, $nbBravos);

            foreach ($receivers as $receiverId) {
                $points  = self::$pointValues[array_rand(self::$pointValues)];
                $message = self::$messages[array_rand(self::$messages)];

                // Date aléatoire dans les 90 derniers jours
                $createdAt = Carbon::now()->subDays(random_int(0, 90))
                                          ->subHours(random_int(0, 23))
                                          ->subMinutes(random_int(0, 59));

                Bravo::create([
                    'sender_id'   => $senderId,
                    'receiver_id' => $receiverId,
                    'message'     => $message,
                    'points'      => $points,
                    'created_at'  => $createdAt,
                    'updated_at'  => $createdAt,
                ]);

                $total++;
            }
        }

        // Mettre à jour les points_total des utilisateurs
        foreach (User::all() as $user) {
            $received = Bravo::where('receiver_id', $user->id)->sum('points');
            // Adaptez selon votre logique métier :
            // $user->update(['points_total' => $received]);
        }

        $this->command->info("✅ {$total} bravos créés avec succès.");
    }
}