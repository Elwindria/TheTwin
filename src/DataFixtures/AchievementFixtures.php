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
                'name' => 'Niveau 1 : Participant engagé',
                'description' => 'Tu as atteint 100 points de score. Ton aventure écologique commence.',
                'imageUrl' => 'src/images/achievement/achievementImgParticipantEngage.png',
            ],
            [
                'name' => 'Niveau 2 : Acteur du changement',
                'description' => 'Tu as atteint 500 points de score. Tes efforts commencent à faire une vraie différence.',
                'imageUrl' => 'src/images/achievement/achievementImgActeurDuChangement.png',
            ],
            [
                'name' => 'Niveau 3 : Briseur de Twin',
                'description' => 'Tu as atteint 1000 points de score. Ton Twin commence sérieusement à trembler.',
                'imageUrl' => 'src/images/achievement/achievementImgBriseurDeTwin.png',
            ],
            [
                'name' => 'Niveau 4 : Destructeur de Twin',
                'description' => 'Tu as atteint 5000 points de score. Peu de Twins survivent à une telle détermination.',
                'imageUrl' => 'src/images/achievement/achievementImgDestructeurDeTwin.png',
            ],
            [
                'name' => 'Niveau 5 : Maître des Twin',
                'description' => 'Tu as atteint 10000 points de score. Tu règnes désormais sur le champ de bataille écologique.',
                'imageUrl' => 'src/images/achievement/achievementImgMaitreDesTwin.png',
            ],

            // Nombre de victoires
            [
                'name' => 'Premier sang vert',
                'description' => 'Tu as remporté ta première victoire contre ton Twin.',
                'imageUrl' => 'src/images/achievement/achievementImgPremierSangVert.png',
            ],
            [
                'name' => 'Chasseur de Twins',
                'description' => 'Tu as remporté 5 victoires. Ton Twin commence à te craindre.',
                'imageUrl' => 'src/images/achievement/achievementImgChasseurDeTwins.png',
            ],
            [
                'name' => 'Fléau des reflets',
                'description' => 'Tu as remporté 10 victoires. Les Twins tombent les uns après les autres.',
                'imageUrl' => 'src/images/achievement/achievementImgFleauDesReflets.png',
            ],
            [
                'name' => 'Marcheur des semaines',
                'description' => 'Tu as remporté 50 victoires. Ta persévérance forge ta légende.',
                'imageUrl' => 'src/images/achievement/achievementImgMarcheurDesSemaines.png',
            ],
            [
                'name' => 'Légende des Twins',
                'description' => 'Tu as remporté 100 victoires. Ton nom résonne dans toutes les semaines de TheTwin.',
                'imageUrl' => 'src/images/achievement/achievementImgLegendeDesTwins.png',
            ],

            // Nombre d'achievements obtenus
            [
                'name' => 'Premiers faits d’armes',
                'description' => 'Tu as obtenu ton premier achievement.',
                'imageUrl' => 'src/images/achievement/achievementImgPremiersFaitsDArmes.png',
            ],
            [
                'name' => 'Collectionneur novice',
                'description' => 'Tu as obtenu 3 achievements. Ta collection commence à prendre forme.',
                'imageUrl' => 'src/images/achievement/achievementImgCollectionneurNovice.png',
            ],
            [
                'name' => 'Aventurier décoré',
                'description' => 'Tu as obtenu 5 achievements. Tes exploits commencent à se voir.',
                'imageUrl' => 'src/images/achievement/achievementImgAventurierDecore.png',
            ],
            [
                'name' => 'Héros ornementé',
                'description' => 'Tu as obtenu 10 achievements. Peu de joueurs portent autant de distinctions.',
                'imageUrl' => 'src/images/achievement/achievementImgHerosOrnemente.png',
            ],
            [
                'name' => 'Archiviste des exploits',
                'description' => 'Tu as obtenu 30 achievements. Ton parcours est gravé dans l’histoire de TheTwin.',
                'imageUrl' => 'src/images/achievement/achievementImgArchivisteDesExploits.png',
            ],

            // Déplacement
            [
                'name' => 'Déplacement - Éclaireur urbain',
                'description' => 'Tu as atteint 100 points dans la catégorie Déplacement.',
                'imageUrl' => 'src/images/achievement/achievementImgDeplacementEclaireurUrbain.png',
            ],
            [
                'name' => 'Déplacement - Voyageur responsable',
                'description' => 'Tu as atteint 300 points dans la catégorie Déplacement.',
                'imageUrl' => 'src/images/achievement/achievementImgDeplacementVoyageurResponsable.png',
            ],
            [
                'name' => 'Déplacement - Rouleur des vents',
                'description' => 'Tu as atteint 500 points dans la catégorie Déplacement.',
                'imageUrl' => 'src/images/achievement/achievementImgDeplacementRouleurDesVents.png',
            ],
            [
                'name' => 'Déplacement - Maître de la mobilité',
                'description' => 'Tu as atteint 1000 points dans la catégorie Déplacement.',
                'imageUrl' => 'src/images/achievement/achievementImgDeplacementMaitreDeLaMobilite.png',
            ],
            [
                'name' => 'Déplacement - Seigneur des chemins verts',
                'description' => 'Tu as atteint 5000 points dans la catégorie Déplacement.',
                'imageUrl' => 'src/images/achievement/achievementImgDeplacementSeigneurDesCheminsVerts.png',
            ],

            // Alimentation
            [
                'name' => 'Alimentation - Cuisinier éveillé',
                'description' => 'Tu as atteint 100 points dans la catégorie Alimentation.',
                'imageUrl' => 'src/images/achievement/achievementImgAlimentationCuisinierEveille.png',
            ],
            [
                'name' => 'Alimentation - Gourmet conscient',
                'description' => 'Tu as atteint 300 points dans la catégorie Alimentation.',
                'imageUrl' => 'src/images/achievement/achievementImgAlimentationGourmetConscient.png',
            ],
            [
                'name' => 'Alimentation - Gardien de l’assiette verte',
                'description' => 'Tu as atteint 500 points dans la catégorie Alimentation.',
                'imageUrl' => 'src/images/achievement/achievementImgAlimentationGardienDeLAssietteVerte.png',
            ],
            [
                'name' => 'Alimentation - Maître des récoltes',
                'description' => 'Tu as atteint 1000 points dans la catégorie Alimentation.',
                'imageUrl' => 'src/images/achievement/achievementImgAlimentationMaitreDesRecoltes.png',
            ],
            [
                'name' => 'Alimentation - Seigneur du festin durable',
                'description' => 'Tu as atteint 5000 points dans la catégorie Alimentation.',
                'imageUrl' => 'src/images/achievement/achievementImgAlimentationSeigneurDuFestinDurable.png',
            ],

            // Consommation
            [
                'name' => 'Consommation - Acheteur avisé',
                'description' => 'Tu as atteint 100 points dans la catégorie Consommation.',
                'imageUrl' => 'src/images/achievement/achievementImgConsommationAcheteurAvise.png',
            ],
            [
                'name' => 'Consommation - Gardien du bon choix',
                'description' => 'Tu as atteint 300 points dans la catégorie Consommation.',
                'imageUrl' => 'src/images/achievement/achievementImgConsommationGardienDuBonChoix.png',
            ],
            [
                'name' => 'Consommation - Briseur d’achats inutiles',
                'description' => 'Tu as atteint 500 points dans la catégorie Consommation.',
                'imageUrl' => 'src/images/achievement/achievementImgConsommationBriseurDAchatsInutiles.png',
            ],
            [
                'name' => 'Consommation - Maître des ressources',
                'description' => 'Tu as atteint 1000 points dans la catégorie Consommation.',
                'imageUrl' => 'src/images/achievement/achievementImgConsommationMaitreDesRessources.png',
            ],
            [
                'name' => 'Consommation - Seigneur de la sobriété',
                'description' => 'Tu as atteint 5000 points dans la catégorie Consommation.',
                'imageUrl' => 'src/images/achievement/achievementImgConsommationSeigneurDeLaSobriete.png',
            ],

            // Énergie
            [
                'name' => 'Énergie - Veilleur d’étincelle',
                'description' => 'Tu as atteint 100 points dans la catégorie Énergie.',
                'imageUrl' => 'src/images/achievement/achievementImgEnergieVeilleurDEtincelle.png',
            ],
            [
                'name' => 'Énergie - Dompteur de watts',
                'description' => 'Tu as atteint 300 points dans la catégorie Énergie.',
                'imageUrl' => 'src/images/achievement/achievementImgEnergieDompteurDeWatts.png',
            ],
            [
                'name' => 'Énergie - Gardien du courant sobre',
                'description' => 'Tu as atteint 500 points dans la catégorie Énergie.',
                'imageUrl' => 'src/images/achievement/achievementImgEnergieGardienDuCourantSobre.png',
            ],
            [
                'name' => 'Énergie - Maître des flux',
                'description' => 'Tu as atteint 1000 points dans la catégorie Énergie.',
                'imageUrl' => 'src/images/achievement/achievementImgEnergieMaitreDesFlux.png',
            ],
            [
                'name' => 'Énergie - Seigneur des puissances vertes',
                'description' => 'Tu as atteint 5000 points dans la catégorie Énergie.',
                'imageUrl' => 'src/images/achievement/achievementImgEnergieSeigneurDesPuissancesVertes.png',
            ],

            // Numérique
            [
                'name' => 'Numérique - Nettoyeur de données',
                'description' => 'Tu as atteint 100 points dans la catégorie Numérique.',
                'imageUrl' => 'src/images/achievement/achievementImgNumeriqueNettoyeurDeDonnees.png',
            ],
            [
                'name' => 'Numérique - Gardien du cloud léger',
                'description' => 'Tu as atteint 300 points dans la catégorie Numérique.',
                'imageUrl' => 'src/images/achievement/achievementImgNumeriqueGardienDuCloudLeger.png',
            ],
            [
                'name' => 'Numérique - Briseur de surcharge',
                'description' => 'Tu as atteint 500 points dans la catégorie Numérique.',
                'imageUrl' => 'src/images/achievement/achievementImgNumeriqueBriseurDeSurcharge.png',
            ],
            [
                'name' => 'Numérique - Maître des octets sobres',
                'description' => 'Tu as atteint 1000 points dans la catégorie Numérique.',
                'imageUrl' => 'src/images/achievement/achievementImgNumeriqueMaitreDesOctetsSobres.png',
            ],
            [
                'name' => 'Numérique - Seigneur du réseau vert',
                'description' => 'Tu as atteint 5000 points dans la catégorie Numérique.',
                'imageUrl' => 'src/images/achievement/achievementImgNumeriqueSeigneurDuReseauVert.png',
            ],

            // Déchets
            [
                'name' => 'Déchets - Ramasseur vigilant',
                'description' => 'Tu as atteint 100 points dans la catégorie Déchets.',
                'imageUrl' => 'src/images/achievement/achievementImgDechetsRamasseurVigilant.png',
            ],
            [
                'name' => 'Déchets - Trieur confirmé',
                'description' => 'Tu as atteint 300 points dans la catégorie Déchets.',
                'imageUrl' => 'src/images/achievement/achievementImgDechetsTrieurConfirme.png',
            ],
            [
                'name' => 'Déchets - Gardien du recyclage',
                'description' => 'Tu as atteint 500 points dans la catégorie Déchets.',
                'imageUrl' => 'src/images/achievement/achievementImgDechetsGardienDuRecyclage.png',
            ],
            [
                'name' => 'Déchets - Maître de la seconde vie',
                'description' => 'Tu as atteint 1000 points dans la catégorie Déchets.',
                'imageUrl' => 'src/images/achievement/achievementImgDechetsMaitreDeLaSecondeVie.png',
            ],
            [
                'name' => 'Déchets - Seigneur du zéro gaspillage',
                'description' => 'Tu as atteint 5000 points dans la catégorie Déchets.',
                'imageUrl' => 'src/images/achievement/achievementImgDechetsSeigneurDuZeroGaspillage.png',
            ],

            // Engagement écologique
            [
                'name' => 'Engagement écologique - Recrue verte',
                'description' => 'Tu as atteint 100 points dans la catégorie Engagement écologique.',
                'imageUrl' => 'src/images/achievement/achievementImgEngagementEcologiqueRecrueVerte.png',
            ],
            [
                'name' => 'Engagement écologique - Porte-voix du vivant',
                'description' => 'Tu as atteint 300 points dans la catégorie Engagement écologique.',
                'imageUrl' => 'src/images/achievement/achievementImgEngagementEcologiquePorteVoixDuVivant.png',
            ],
            [
                'name' => 'Engagement écologique - Gardien des causes vertes',
                'description' => 'Tu as atteint 500 points dans la catégorie Engagement écologique.',
                'imageUrl' => 'src/images/achievement/achievementImgEngagementEcologiqueGardienDesCausesVertes.png',
            ],
            [
                'name' => 'Engagement écologique - Maître de la mobilisation',
                'description' => 'Tu as atteint 1000 points dans la catégorie Engagement écologique.',
                'imageUrl' => 'src/images/achievement/achievementImgEngagementEcologiqueMaitreDeLaMobilisation.png',
            ],
            [
                'name' => 'Engagement écologique - Seigneur de la canopée',
                'description' => 'Tu as atteint 5000 points dans la catégorie Engagement écologique.',
                'imageUrl' => 'src/images/achievement/achievementImgEngagementEcologiqueSeigneurDeLaCanopee.png',
            ],
        ];

        foreach ($achievements as $achievementData) {
            $achievement = new Achievement();
            $achievement->setName($achievementData['name']);
            $achievement->setDescription($achievementData['description']);
            $achievement->setImageUrl($achievementData['imageUrl']);

            $manager->persist($achievement);
        }

        $manager->flush();
    }
}