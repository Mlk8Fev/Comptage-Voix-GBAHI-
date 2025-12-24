<?php

namespace Database\Seeders;

use App\Models\Candidat;
use App\Models\LieuVote;
use App\Models\BureauVote;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ElectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Créer les 7 candidats
        $candidats = [
            ['nom_complet' => 'GBAHI DJOUA LUC'],
            ['nom_complet' => 'KOUADIO ERIC'],
            ['nom_complet' => 'KONE DOSSOGUI'],
            ['nom_complet' => 'BONI PLACIDE STEPHANE'],
            ['nom_complet' => 'ADOU LANDRY'],
            ['nom_complet' => 'KOUADIA BEDI NOEL OLIVIER'],
            ['nom_complet' => 'ZADI ZADI PATRICK'],
        ];

        foreach ($candidats as $candidat) {
            Candidat::create($candidat);
        }

        // Créer les lieux de vote pour OKROUYO
        $lieuxOkrouyo = [
            'GROUPE SCOLAIRE OKROUYO',
            'PLACE PUBLIQUE CPT GARAGE BELEKE',
            'GROUPE SCOLAIRE KAGNANAKO',
            'EPP ERNESTKRO',
            'GS OTTAWA',
            'EPP GRAGBAZO',
            'PLACE PUBLIQUE DOBOKO',
            'PLACE PUBLIQUE CPT SANTOSKRO',
            'GROUPE SCOLAIRE DOBOUO 1-2',
            'GS TOLAKRO 1-2',
            'EPP TAYO',
            'EPP ZOGBODOUA',
            'EPP EMILEKRO',
            'GROUPE SCOLAIRE GBALEBOUO',
            'EPP PETIT BOUAKE',
            'GROUPE SCOLAIRE JULESKRO',
            'EPP ALBERTKRO',
            'GS BERNARDKRO',
            'EPP MABEHIRI I',
            'EPP BERTINKRO',
            'EPP KOUAKOUKRO-GUIBOUO',
            'EPP YOBOUEKRO',
            'EPP GBADA KOUAMEKRO',
            'EPP 4 CARREFOURS',
            'EPP MATHIEUKRO',
            'EPP AGBANOU',
            'EPP MABEHIRI II',
            'EPP KOUDOUYO',
            'EPP KAYO',
            'GS KPADA 1-2',
            'EPP AMANIKRO',
            'GS SIPEFCI OTTAWA (V1) 1-3',
            'EPP SIPEFCI (V2)-4',
            'EPP V3 OKROUYO',
            'GS OKROUYO SODEPALM (V4) 1-2',
            'EPP MARTINKRO',
            'EPP N\'DA KOUASSIKRO',
            'EPP GBLYO',
            'EPP DOGABRE',
            'EPP KAOKA',
            'EPP YOBOUETKRO',
            'EPP CPT KOUAKOUDANKRO',
            'EPP ASSIOBLEDI',
            'EPP SAPH BONIKRO (ECOLE COMMUNAUTAIRE)',
            'PLACE PUBLIQUE CPT RAPHAELKRO',
            'EPP N\'GORANKRO',
            'EPP ABRIGAKRO',
            'EPP CPT KOUASSIKANKRO',
            'EPP KRA-YAOKRO',
        ];

        // Créer les lieux de vote pour LILIYO
        $lieuxLiliyo = [
            'EPP OUREGBABRE 1',
            'EPP YACOLIDABOUO',
            'PLACE PUBLIQUE CPT BAYOGO',
            'GROUPE SCOLAIRE LESSIRI',
            'GS LILIYO 1 ET 2',
            'EPP MARC-KRO CPT',
            'EPP SAYO',
            'GROUPE SCOLAIRE KOZIAYO 1',
            'EPP N\'ZUE KOFFIKRO CPT',
            'GROUPE SCOLAIRE GNOGBOYO',
            'EPP PETIT BEOUMI CPT',
            'GROUPE SCOLAIRE NENEFEROUA',
            'PLACE PUBLIQUE CPT TRAORE ZIE',
            'PLACE PUBLIQUE CPT LAGOUKRO',
            'PLACE PUBLIQUE CPT ROGERKR',
            'EPP KODA CENTRE',
            'EPP KOUADIOKRO',
            'EPP PETIT BOUAKE',
            'GROUPE SCOLAIRE LAZOA CARREFOUR',
            'EPP BABAEROUA',
            'EPP GNAPAYO',
            'EPP PETIT YAMOUSSOUKRO',
            'PLACE PUBLIQUE CPT BENJAMINKRO',
            'PLACE PUBLIQUE CPT PETIT DIMBOKRO',
            'CPT N\'GOKRO',
            'PLACE PUBLIQUE CPT NOUVEAU QUARTIER',
        ];

        // Créer les lieux de vote OKROUYO avec leurs bureaux
        foreach ($lieuxOkrouyo as $nomLieu) {
            $lieu = LieuVote::create([
                'nom' => $nomLieu,
                'commune' => 'OKROUYO',
                'circonscription' => 'Circonscription OKROUYO',
            ]);

            // Créer les bureaux de vote (1 à 5 selon le lieu)
            $nbBureaux = in_array($nomLieu, ['GROUPE SCOLAIRE OKROUYO', 'GS SIPEFCI OTTAWA (V1) 1-3', 'GS OKROUYO SODEPALM (V4) 1-2']) ? 5 : 
                        (in_array($nomLieu, ['GROUPE SCOLAIRE DOBOUO 1-2', 'GS TOLAKRO 1-2', 'GS KPADA 1-2']) ? 2 : 1);

            for ($i = 1; $i <= $nbBureaux; $i++) {
                BureauVote::create([
                    'lieu_vote_id' => $lieu->id,
                    'numero' => str_pad($i, 2, '0', STR_PAD_LEFT),
                    'hommes_inscrits' => rand(100, 300),
                    'femmes_inscrits' => rand(100, 300),
                    'est_ouvert' => true,
                ]);
            }
        }

        // Créer les lieux de vote LILIYO avec leurs bureaux
        foreach ($lieuxLiliyo as $nomLieu) {
            $lieu = LieuVote::create([
                'nom' => $nomLieu,
                'commune' => 'LILIYO',
                'circonscription' => 'Circonscription LILIYO',
            ]);

            // Créer les bureaux de vote (1 à 3 selon le lieu)
            $nbBureaux = in_array($nomLieu, ['EPP YACOLIDABOUO', 'GS LILIYO 1 ET 2']) ? 3 : 1;

            for ($i = 1; $i <= $nbBureaux; $i++) {
                BureauVote::create([
                    'lieu_vote_id' => $lieu->id,
                    'numero' => str_pad($i, 2, '0', STR_PAD_LEFT),
                    'hommes_inscrits' => rand(100, 300),
                    'femmes_inscrits' => rand(100, 300),
                    'est_ouvert' => true,
                ]);
            }
        }
    }
}
