<?php

namespace App\DataFixtures;

use App\Entity\Achievement;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AchievementFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        $achievements = [
            // Score total
            [
                'code' => 'score_100',
                'type' => 'total_score',
                'threshold' => 100,
                'name' => 'Niveau 1 : Participant engagé',
                'description' => 'Tu as atteint 100 points de score. Ton aventure écologique commence.',
                'imageUrl' => 'src/images/achievement/score/achievementImgParticipantEngage.png',
            ],
            [
                'code' => 'score_500',
                'type' => 'total_score',
                'threshold' => 500,
                'name' => 'Niveau 2 : Acteur du changement',
                'description' => 'Tu as atteint 500 points de score. Tes efforts commencent à faire une vraie différence.',
                'imageUrl' => 'src/images/achievement/score/achievementImgActeurDuChangement.png',
            ],
            [
                'code' => 'score_1000',
                'type' => 'total_score',
                'threshold' => 1000,
                'name' => 'Niveau 3 : Briseur de Twin',
                'description' => 'Tu as atteint 1000 points de score. Ton Twin commence sérieusement à trembler.',
                'imageUrl' => 'src/images/achievement/score/achievementImgBriseurDeTwin.png',
            ],
            [
                'code' => 'score_5000',
                'type' => 'total_score',
                'threshold' => 5000,
                'name' => 'Niveau 4 : Destructeur de Twin',
                'description' => 'Tu as atteint 5000 points de score. Peu de Twins survivent à une telle détermination.',
                'imageUrl' => 'src/images/achievement/score/achievementImgDestructeurDeTwin.png',
            ],
            [
                'code' => 'score_10000',
                'type' => 'total_score',
                'threshold' => 10000,
                'name' => 'Niveau 5 : Maître des Twin',
                'description' => 'Tu as atteint 10000 points de score. Tu règnes désormais sur le champ de bataille écologique.',
                'imageUrl' => 'src/images/achievement/score/achievementImgMaitreDesTwin.png',
            ],

            // Nombre de victoires
            [
                'code' => 'victory_1',
                'type' => 'victory_count',
                'threshold' => 1,
                'name' => 'Premier sang vert',
                'description' => 'Tu as remporté ta première victoire contre ton Twin.',
                'imageUrl' => 'src/images/achievement/victory/achievementImgPremierSangVert.png',
            ],
            [
                'code' => 'victory_5',
                'type' => 'victory_count',
                'threshold' => 5,
                'name' => 'Chasseur de Twins',
                'description' => 'Tu as remporté 5 victoires. Ton Twin commence à te craindre.',
                'imageUrl' => 'src/images/achievement/victory/achievementImgChasseurDeTwins.png',
            ],
            [
                'code' => 'victory_10',
                'type' => 'victory_count',
                'threshold' => 10,
                'name' => 'Fléau des reflets',
                'description' => 'Tu as remporté 10 victoires. Les Twins tombent les uns après les autres.',
                'imageUrl' => 'src/images/achievement/victory/achievementImgFleauDesReflets.png',
            ],
            [
                'code' => 'victory_50',
                'type' => 'victory_count',
                'threshold' => 50,
                'name' => 'Marcheur des semaines',
                'description' => 'Tu as remporté 50 victoires. Ta persévérance forge ta légende.',
                'imageUrl' => 'src/images/achievement/victory/achievementImgMarcheurDesSemaines.png',
            ],
            [
                'code' => 'victory_100',
                'type' => 'victory_count',
                'threshold' => 100,
                'name' => 'Légende des Twins',
                'description' => 'Tu as remporté 100 victoires. Ton nom résonne dans toutes les semaines de TheTwin.',
                'imageUrl' => 'src/images/achievement/victory/achievementImgLegendeDesTwins.png',
            ],

            // Nombre d'achievements obtenus
            [
                'code' => 'achievement_1',
                'type' => 'achievement_count',
                'threshold' => 1,
                'name' => 'Premiers faits d’armes',
                'description' => 'Tu as obtenu ton premier achievement.',
                'imageUrl' => 'src/images/achievement/achievement/achievementImgPremiersFaitsDArmes.png',
            ],
            [
                'code' => 'achievement_3',
                'type' => 'achievement_count',
                'threshold' => 3,
                'name' => 'Collectionneur novice',
                'description' => 'Tu as obtenu 3 achievements. Ta collection commence à prendre forme.',
                'imageUrl' => 'src/images/achievement/achievement/achievementImgCollectionneurNovice.png',
            ],
            [
                'code' => 'achievement_5',
                'type' => 'achievement_count',
                'threshold' => 5,
                'name' => 'Aventurier décoré',
                'description' => 'Tu as obtenu 5 achievements. Tes exploits commencent à se voir.',
                'imageUrl' => 'src/images/achievement/achievement/achievementImgAventurierDecore.png',
            ],
            [
                'code' => 'achievement_10',
                'type' => 'achievement_count',
                'threshold' => 10,
                'name' => 'Héros ornementé',
                'description' => 'Tu as obtenu 10 achievements. Peu de joueurs portent autant de distinctions.',
                'imageUrl' => 'src/images/achievement/achievement/achievementImgHerosOrnemente.png',
            ],
            [
                'code' => 'achievement_30',
                'type' => 'achievement_count',
                'threshold' => 30,
                'name' => 'Archiviste des exploits',
                'description' => 'Tu as obtenu 30 achievements. Ton parcours est gravé dans l’histoire de TheTwin.',
                'imageUrl' => 'src/images/achievement/achievement/achievementImgArchivisteDesExploits.png',
            ],

            // Déplacement
            [
                'code' => 'category_deplacement_100',
                'type' => 'category_deplacement',
                'threshold' => 100,
                'name' => 'Déplacement - Éclaireur urbain',
                'description' => 'Tu as atteint 100 points dans la catégorie Déplacement.',
                'imageUrl' => 'src/images/achievement/deplacement/achievementImgDeplacementEclaireurUrbain.png',
            ],
            [
                'code' => 'category_deplacement_300',
                'type' => 'category_deplacement',
                'threshold' => 300,
                'name' => 'Déplacement - Voyageur responsable',
                'description' => 'Tu as atteint 300 points dans la catégorie Déplacement.',
                'imageUrl' => 'src/images/achievement/deplacement/achievementImgDeplacementVoyageurResponsable.png',
            ],
            [
                'code' => 'category_deplacement_500',
                'type' => 'category_deplacement',
                'threshold' => 500,
                'name' => 'Déplacement - Rouleur des vents',
                'description' => 'Tu as atteint 500 points dans la catégorie Déplacement.',
                'imageUrl' => 'src/images/achievement/deplacement/achievementImgDeplacementRouleurDesVents.png',
            ],
            [
                'code' => 'category_deplacement_1000',
                'type' => 'category_deplacement',
                'threshold' => 1000,
                'name' => 'Déplacement - Maître de la mobilité',
                'description' => 'Tu as atteint 1000 points dans la catégorie Déplacement.',
                'imageUrl' => 'src/images/achievement/deplacement/achievementImgDeplacementMaitreDeLaMobilite.png',
            ],
            [
                'code' => 'category_deplacement_5000',
                'type' => 'category_deplacement',
                'threshold' => 5000,
                'name' => 'Déplacement - Seigneur des chemins verts',
                'description' => 'Tu as atteint 5000 points dans la catégorie Déplacement.',
                'imageUrl' => 'src/images/achievement/deplacement/achievementImgDeplacementSeigneurDesCheminsVerts.png',
            ],

            // Alimentation
            [
                'code' => 'category_alimentation_100',
                'type' => 'category_alimentation',
                'threshold' => 100,
                'name' => 'Alimentation - Cuisinier éveillé',
                'description' => 'Tu as atteint 100 points dans la catégorie Alimentation.',
                'imageUrl' => 'src/images/achievement/alimentation/achievementImgAlimentationCuisinierEveille.png',
            ],
            [
                'code' => 'category_alimentation_300',
                'type' => 'category_alimentation',
                'threshold' => 300,
                'name' => 'Alimentation - Gourmet conscient',
                'description' => 'Tu as atteint 300 points dans la catégorie Alimentation.',
                'imageUrl' => 'src/images/achievement/alimentation/achievementImgAlimentationGourmetConscient.png',
            ],
            [
                'code' => 'category_alimentation_500',
                'type' => 'category_alimentation',
                'threshold' => 500,
                'name' => 'Alimentation - Gardien de l’assiette verte',
                'description' => 'Tu as atteint 500 points dans la catégorie Alimentation.',
                'imageUrl' => 'src/images/achievement/alimentation/achievementImgAlimentationGardienDeLAssietteVerte.png',
            ],
            [
                'code' => 'category_alimentation_1000',
                'type' => 'category_alimentation',
                'threshold' => 1000,
                'name' => 'Alimentation - Maître des récoltes',
                'description' => 'Tu as atteint 1000 points dans la catégorie Alimentation.',
                'imageUrl' => 'src/images/achievement/alimentation/achievementImgAlimentationMaitreDesRecoltes.png',
            ],
            [
                'code' => 'category_alimentation_5000',
                'type' => 'category_alimentation',
                'threshold' => 5000,
                'name' => 'Alimentation - Seigneur du festin durable',
                'description' => 'Tu as atteint 5000 points dans la catégorie Alimentation.',
                'imageUrl' => 'src/images/achievement/alimentation/achievementImgAlimentationSeigneurDuFestinDurable.png',
            ],

            // Consommation
            [
                'code' => 'category_consommation_100',
                'type' => 'category_consommation',
                'threshold' => 100,
                'name' => 'Consommation - Acheteur avisé',
                'description' => 'Tu as atteint 100 points dans la catégorie Consommation.',
                'imageUrl' => 'src/images/achievement/consommation/achievementImgConsommationAcheteurAvise.png',
            ],
            [
                'code' => 'category_consommation_300',
                'type' => 'category_consommation',
                'threshold' => 300,
                'name' => 'Consommation - Gardien du bon choix',
                'description' => 'Tu as atteint 300 points dans la catégorie Consommation.',
                'imageUrl' => 'src/images/achievement/consommation/achievementImgConsommationGardienDuBonChoix.png',
            ],
            [
                'code' => 'category_consommation_500',
                'type' => 'category_consommation',
                'threshold' => 500,
                'name' => 'Consommation - Briseur d’achats inutiles',
                'description' => 'Tu as atteint 500 points dans la catégorie Consommation.',
                'imageUrl' => 'src/images/achievement/consommation/achievementImgConsommationBriseurDAchatsInutiles.png',
            ],
            [
                'code' => 'category_consommation_1000',
                'type' => 'category_consommation',
                'threshold' => 1000,
                'name' => 'Consommation - Maître des ressources',
                'description' => 'Tu as atteint 1000 points dans la catégorie Consommation.',
                'imageUrl' => 'src/images/achievement/consommation/achievementImgConsommationMaitreDesRessources.png',
            ],
            [
                'code' => 'category_consommation_5000',
                'type' => 'category_consommation',
                'threshold' => 5000,
                'name' => 'Consommation - Seigneur de la sobriété',
                'description' => 'Tu as atteint 5000 points dans la catégorie Consommation.',
                'imageUrl' => 'src/images/achievement/consommation/achievementImgConsommationSeigneurDeLaSobriete.png',
            ],

            // Énergie
            [
                'code' => 'category_energie_100',
                'type' => 'category_energie',
                'threshold' => 100,
                'name' => 'Énergie - Veilleur d’étincelle',
                'description' => 'Tu as atteint 100 points dans la catégorie Énergie.',
                'imageUrl' => 'src/images/achievement/energie/achievementImgEnergieVeilleurDEtincelle.png',
            ],
            [
                'code' => 'category_energie_300',
                'type' => 'category_energie',
                'threshold' => 300,
                'name' => 'Énergie - Dompteur de watts',
                'description' => 'Tu as atteint 300 points dans la catégorie Énergie.',
                'imageUrl' => 'src/images/achievement/energie/achievementImgEnergieDompteurDeWatts.png',
            ],
            [
                'code' => 'category_energie_500',
                'type' => 'category_energie',
                'threshold' => 500,
                'name' => 'Énergie - Gardien du courant sobre',
                'description' => 'Tu as atteint 500 points dans la catégorie Énergie.',
                'imageUrl' => 'src/images/achievement/energie/achievementImgEnergieGardienDuCourantSobre.png',
            ],
            [
                'code' => 'category_energie_1000',
                'type' => 'category_energie',
                'threshold' => 1000,
                'name' => 'Énergie - Maître des flux',
                'description' => 'Tu as atteint 1000 points dans la catégorie Énergie.',
                'imageUrl' => 'src/images/achievement/energie/achievementImgEnergieMaitreDesFlux.png',
            ],
            [
                'code' => 'category_energie_5000',
                'type' => 'category_energie',
                'threshold' => 5000,
                'name' => 'Énergie - Seigneur des puissances vertes',
                'description' => 'Tu as atteint 5000 points dans la catégorie Énergie.',
                'imageUrl' => 'src/images/achievement/energie/achievementImgEnergieSeigneurDesPuissancesVertes.png',
            ],

            // Numérique
            [
                'code' => 'category_numerique_100',
                'type' => 'category_numerique',
                'threshold' => 100,
                'name' => 'Numérique - Nettoyeur de données',
                'description' => 'Tu as atteint 100 points dans la catégorie Numérique.',
                'imageUrl' => 'src/images/achievement/numerique/achievementImgNumeriqueNettoyeurDeDonnees.png',
            ],
            [
                'code' => 'category_numerique_300',
                'type' => 'category_numerique',
                'threshold' => 300,
                'name' => 'Numérique - Gardien du cloud léger',
                'description' => 'Tu as atteint 300 points dans la catégorie Numérique.',
                'imageUrl' => 'src/images/achievement/numerique/achievementImgNumeriqueGardienDuCloudLeger.png',
            ],
            [
                'code' => 'category_numerique_500',
                'type' => 'category_numerique',
                'threshold' => 500,
                'name' => 'Numérique - Briseur de surcharge',
                'description' => 'Tu as atteint 500 points dans la catégorie Numérique.',
                'imageUrl' => 'src/images/achievement/numerique/achievementImgNumeriqueBriseurDeSurcharge.png',
            ],
            [
                'code' => 'category_numerique_1000',
                'type' => 'category_numerique',
                'threshold' => 1000,
                'name' => 'Numérique - Maître des octets sobres',
                'description' => 'Tu as atteint 1000 points dans la catégorie Numérique.',
                'imageUrl' => 'src/images/achievement/numerique/achievementImgNumeriqueMaitreDesOctetsSobres.png',
            ],
            [
                'code' => 'category_numerique_5000',
                'type' => 'category_numerique',
                'threshold' => 5000,
                'name' => 'Numérique - Seigneur du réseau vert',
                'description' => 'Tu as atteint 5000 points dans la catégorie Numérique.',
                'imageUrl' => 'src/images/achievement/numerique/achievementImgNumeriqueSeigneurDuReseauVert.png',
            ],

            // Déchets
            [
                'code' => 'category_dechets_100',
                'type' => 'category_dechets',
                'threshold' => 100,
                'name' => 'Déchets - Ramasseur vigilant',
                'description' => 'Tu as atteint 100 points dans la catégorie Déchets.',
                'imageUrl' => 'src/images/achievement/dechets/achievementImgDechetsRamasseurVigilant.png',
            ],
            [
                'code' => 'category_dechets_300',
                'type' => 'category_dechets',
                'threshold' => 300,
                'name' => 'Déchets - Trieur confirmé',
                'description' => 'Tu as atteint 300 points dans la catégorie Déchets.',
                'imageUrl' => 'src/images/achievement/dechets/achievementImgDechetsTrieurConfirme.png',
            ],
            [
                'code' => 'category_dechets_500',
                'type' => 'category_dechets',
                'threshold' => 500,
                'name' => 'Déchets - Gardien du recyclage',
                'description' => 'Tu as atteint 500 points dans la catégorie Déchets.',
                'imageUrl' => 'src/images/achievement/dechets/achievementImgDechetsGardienDuRecyclage.png',
            ],
            [
                'code' => 'category_dechets_1000',
                'type' => 'category_dechets',
                'threshold' => 1000,
                'name' => 'Déchets - Maître de la seconde vie',
                'description' => 'Tu as atteint 1000 points dans la catégorie Déchets.',
                'imageUrl' => 'src/images/achievement/dechets/achievementImgDechetsMaitreDeLaSecondeVie.png',
            ],
            [
                'code' => 'category_dechets_5000',
                'type' => 'category_dechets',
                'threshold' => 5000,
                'name' => 'Déchets - Seigneur du zéro gaspillage',
                'description' => 'Tu as atteint 5000 points dans la catégorie Déchets.',
                'imageUrl' => 'src/images/achievement/dechets/achievementImgDechetsSeigneurDuZeroGaspillage.png',
            ],

            // Engagement écologique
            [
                'code' => 'category_engagement_ecologique_100',
                'type' => 'category_engagement_ecologique',
                'threshold' => 100,
                'name' => 'Engagement écologique - Recrue verte',
                'description' => 'Tu as atteint 100 points dans la catégorie Engagement écologique.',
                'imageUrl' => 'src/images/achievement/engagement_ecologique/achievementImgEngagementEcologiqueRecrueVerte.png',
            ],
            [
                'code' => 'category_engagement_ecologique_300',
                'type' => 'category_engagement_ecologique',
                'threshold' => 300,
                'name' => 'Engagement écologique - Porte-voix du vivant',
                'description' => 'Tu as atteint 300 points dans la catégorie Engagement écologique.',
                'imageUrl' => 'src/images/achievement/engagement_ecologique/achievementImgEngagementEcologiquePorteVoixDuVivant.png',
            ],
            [
                'code' => 'category_engagement_ecologique_500',
                'type' => 'category_engagement_ecologique',
                'threshold' => 500,
                'name' => 'Engagement écologique - Gardien des causes vertes',
                'description' => 'Tu as atteint 500 points dans la catégorie Engagement écologique.',
                'imageUrl' => 'src/images/achievement/engagement_ecologique/achievementImgEngagementEcologiqueGardienDesCausesVertes.png',
            ],
            [
                'code' => 'category_engagement_ecologique_1000',
                'type' => 'category_engagement_ecologique',
                'threshold' => 1000,
                'name' => 'Engagement écologique - Maître de la mobilisation',
                'description' => 'Tu as atteint 1000 points dans la catégorie Engagement écologique.',
                'imageUrl' => 'src/images/achievement/engagement_ecologique/achievementImgEngagementEcologiqueMaitreDeLaMobilisation.png',
            ],
            [
                'code' => 'category_engagement_ecologique_5000',
                'type' => 'category_engagement_ecologique',
                'threshold' => 5000,
                'name' => 'Engagement écologique - Seigneur de la canopée',
                'description' => 'Tu as atteint 5000 points dans la catégorie Engagement écologique.',
                'imageUrl' => 'src/images/achievement/engagement_ecologique/achievementImgEngagementEcologiqueSeigneurDeLaCanopee.png',
            ],
        ];

        foreach ($achievements as $achievementData) {
            $achievement = new Achievement();
            $achievement->setCode($achievementData['code']);
            $achievement->setType($achievementData['type']);
            $achievement->setThreshold($achievementData['threshold']);
            $achievement->setName($achievementData['name']);
            $achievement->setDescription($achievementData['description']);
            $achievement->setImageUrl($achievementData['imageUrl']);

            $manager->persist($achievement);
        }

        $manager->flush();
    }
}