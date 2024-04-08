<?php

use Symfony\Component\VarDumper\VarDumper;

function getDelta($annee1, $annee2, $code_cours_eau)
{
    $content = json_decode(file_get_contents('../data/' . $code_cours_eau . '.json'), true);

    $delta = 0;

    $tabMesuresAnnee1 = array();
    $tabMesuresAnnee2 = array();

    $tabMoyenne = array();

    // ajout des valeurs dans des tableau pour les trier ensuite
    foreach ($content as $data) {
        if (substr($data["date_mesure_temp"], 0, -6) == $annee1) {
            $tabMesuresAnnee1[] = [
                "resultat" => $data["resultat"],
                "mois" => intval(explode("-", $data["date_mesure_temp"])[1])
            ];
        }

        if (substr($data["date_mesure_temp"], 0, -6) == $annee2) {
            $tabMesuresAnnee2[] = [
                "resultat" => $data["resultat"],
                "mois" => intval(explode("-", $data["date_mesure_temp"])[1])
            ];
        }
    }

    $lenghtMin = min(sizeof($tabMesuresAnnee1), sizeof($tabMesuresAnnee2));
    $iTab1 = 0;
    $iTab2 = 0;

    // boucle pour récuperer les valeurs uniquement des même mois pour avoir des valeurs cohérente
    while ($iTab1 < $lenghtMin - 1 && $iTab2 < $lenghtMin - 1) {
        if ($tabMesuresAnnee1[$iTab1]["mois"] == $tabMesuresAnnee2[$iTab2]["mois"]) {
            $tabMoyenne[] = ($tabMesuresAnnee2[$iTab2]["resultat"] - $tabMesuresAnnee1[$iTab1]["resultat"]);
            $iTab1++;
            $iTab2++;
        }

        if ($tabMesuresAnnee1[$iTab1]["mois"] < $tabMesuresAnnee2[$iTab2]["mois"]) {
            $iTab1++;
        }

        if ($tabMesuresAnnee1[$iTab1]["mois"] > $tabMesuresAnnee2[$iTab2]["mois"]) {
            $iTab2++;
        }
    }

    foreach ($tabMoyenne as $key => $value) {
        $delta += $value;
    }

    $nbValeurs = sizeof($tabMoyenne);

    if ($nbValeurs == 0)
        return 999;

    return $delta /= $nbValeurs;
}

$tab11 = [
    "----0010",
    "F---0100",
    "F24-0400",
    "F4--0210",
    "F4380600",
    "F44-0400",
    "F4480600",
    "F45-0400",
    "F46-0400",
    "F46-0420",
    "F48-0400",
    "F65-0400",
    "F70-0400",
    "H---0100",
    "H2269000",
    "H2280600",
    "H30-0400"
];

// Tableau contenant les codes de cours d'eau
$tab24 = [
    "----0000",
    "F41-0400",
    "H41-0410",
    "K---0090",
    "K4194000",
    "K42-0300",
    "K43-0310",
    "K44-0300",
    "K56-0300",
    "K6--0240",
    "K6--0250",
    "K63-0300",
    "K65-0310",
    "K65-0320",
    "K6814000",
    "K7--0260",
    "L---0060",
    "L---0070",
    "L46-0300",
    "L5--0190",
    "L63-0300",
    "M1--0160",
    "M1--0161",
    "M10-0300",
    "M1034000"
];

// Tableau contenant les codes de cours d'eau pour la région 27
$tab27 = [
    "----0000",
    "----0010",
    "F04-0400",
    "F0406000",
    "F3--0200",
    "F31-0400",
    "F3110600",
    "F32-0400",
    "F3350600",
    "F3531000",
    "K---0080",
    "K1--0180",
    "K10-0300",
    "K12-0310",
    "K13-0300",
    "K16-0300",
    "K17-0310",
    "K1764000",
    "K19-0300",
    "K4094000",
    "U---0000",
    "U13-0400",
    "U2--0200",
    "U2210500",
    "U2310520"
];

// Tableau contenant les codes de cours d'eau pour la région 28
$tab28 = [
    "----0010",
    "G2--0200",
    "G7--0200",
    "H3109000",
    "H32-0400",
    "H3239000",
    "H3249000",
    "H4--0200",
    "H43-0400",
    "H5040600",
    "H5130600",
    "H61-0400",
    "H6110600",
    "I0--0200",
    "I13-0400",
    "I14-0400",
    "I21-0400",
    "I2129000",
    "I23-0400",
    "I24-0400",
    "I4310600",
    "I52-0400",
    "I63-0400",
    "I7--0200",
    "I71-0400"
];

// Tableau contenant les codes de cours d'eau pour la région 32
$tab32 = [
    "D0--022-",
    "D0130700",
    "D0200600",
    "E1280600",
    "E1560600",
    "E1760600",
    "E1820700",
    "E2--0110",
    "E3--0120",
    "E3660600",
    "E4030570",
    "E4100600",
    "E5100570",
    "E5400650",
    "E5500570",
    "E6---140",
    "E6--009-",
    "E6380600",
    "E6400600",
    "E6420650",
    "E6450800",
    "E6490830",
    "F61-0400",
    "H---0100",
    "H0010600"
];


// Tableau contenant les codes de cours d'eau pour la région 44
$tab44 = [
    "----0010",
    "A---0000",
    "A---0030",
    "A---0060",
    "A02-0200",
    "A0260340",
    "A11-0200",
    "A12-0200",
    "A14-0200",
    "A15-0200",
    "A2--0100",
    "A2--0110",
    "A2020300",
    "A2220660",
    "A25-0200",
    "A2550630",
    "A26-0200",
    "A29-0200",
    "A3--0100",
    "A3--0110",
    "A32-0200",
    "A34-0200",
    "A36-0210",
    "A38-0200",
    "A4170300"
];

// Tableau contenant les codes de cours d'eau pour la région 52
$tab52 = [
    "----0000",
    "J78-0300",
    "J79-0300",
    "L8--0210",
    "L92-0300",
    "M---0060",
    "M---0090",
    "M0--0150",
    "M0124000",
    "M02-0300",
    "M05-0300",
    "M0574000",
    "M06-0300",
    "M1--0160",
    "M12-0300",
    "M1215500",
    "M1254000",
    "M14-0300",
    "M3--0180",
    "M31-0300",
    "M32-0310",
    "M33-0300",
    "M4--0190",
    "M5--0200",
    "M6354000"
];

// Tableau contenant les codes de cours d'eau pour la région 53
$tab53 = [
    "J---0060",
    "J0--0150",
    "J0--0160",
    "J0144000",
    "J0216200",
    "J1--0170",
    "J1114000",
    "J13-0300",
    "J2034000",
    "J22-0300",
    "J2314000",
    "J3--0180",
    "J34-0300",
    "J3514000",
    "J3624000",
    "J3834900",
    "J4--0200",
    "J4124000",
    "J4224000",
    "J48-0300",
    "J5--0210",
    "J5--0220",
    "J5524000",
    "J56-0300",
    "J7114000"
];

// Tableau contenant les codes de cours d'eau pour la région 75
$tab75 = [
    "K---0090",
    "K51-0300",
    "L---0060",
    "L---0070",
    "L0--0150",
    "L00-0300",
    "L01-0300",
    "L1324000",
    "L2--0160",
    "L22-0300",
    "L2404000",
    "L3024000",
    "L31-0300",
    "L4--0170",
    "L45-0300",
    "L5--0180",
    "L5134000",
    "L56-0300",
    "L8--0210",
    "L82-0300",
    "L8334000",
    "N---0060",
    "O---0000",
    "O---0150",
    "O6--0290"
];

// Tableau contenant les codes de cours d'eau pour la région 76
$tab76 = [
    "K---0080",
    "K21-0300",
    "O---0000",
    "O---0100",
    "O---0150",
    "O00-0400",
    "O02-0400",
    "O03-0400",
    "O0390690",
    "O06-0400",
    "O07-0400",
    "O0760500",
    "O09-0400",
    "O1--0250",
    "O1--0290",
    "O1270500",
    "O14-0430",
    "O18-0400",
    "O2--0330",
    "O2320500",
    "O2650500",
    "O30-0400",
    "O30-0430",
    "O3050580",
    "O31-0400"
];

// Tableau contenant les codes de cours d'eau pour la région 84
$tab84 = [
    "----0000",
    "K---0080",
    "K---0090",
    "K0454000",
    "K05-0300",
    "K06-0310",
    "K06-0330",
    "K08-0300",
    "K1--0150",
    "K14-0300",
    "K1414000",
    "K15-0300",
    "K2--0190",
    "K2036000",
    "K22-0300",
    "K22-0310",
    "K23-0300",
    "K25-0300",
    "K2514000",
    "K2654000",
    "K2674000",
    "K27-0300",
    "K27-0310",
    "K3--0200",
    "K30-0310"
];

// Tableau contenant les codes de cours d'eau pour la région 93
$tab93 = [
    "V---0000",
    "V6--0200",
    "V6030500",
    "V6150500",
    "W2--0200",
    "W2010500",
    "W2210500",
    "W27-0400",
    "X---0000",
    "X0000500",
    "X02-0400",
    "X0240500",
    "X04-0400",
    "X0500540",
    "X10-0400",
    "X1050500",
    "X1100500",
    "X1220500",
    "X14-0400",
    "X2--0200",
    "X2300500",
    "X27-0400",
    "X3010560",
    "X34-0400",
    "Y4--0200"
];


$tab94 = [
    "Y7--0200",
    "Y7020560",
    "Y71-0400",
    "Y7110500",
    "Y7410520",
    "Y7610560",
    "Y78-0400",
    "Y7910520",
    "Y81-0400",
    "Y8110500",
    "Y83-0400",
    "Y84-0400",
    "Y86-0400",
    "Y9--0200",
    "Y9000540",
    "Y94-0400",
    "Y9500500",
    "Y9510500"
];


$tabNom = [
    "tab11",
    "tab24",
    "tab27",
    "tab28",
    "tab32",
    "tab44",
    "tab52",
    "tab53",
    "tab75",
    "tab76",
    "tab84",
    "tab93",
    "tab94"
];


$annee1 = isset($_POST['annee1']) ? $_POST['annee1'] : null;
$annee2 = isset($_POST['annee2']) ? $_POST['annee2'] : null;

if ($annee1 == null || $annee2 == null) {
    echo "error";
} else {
    $tabDelta = array();

    //echo "Evolution de " . $annee1 . " à " . $annee2 . "\n";;

    foreach ($tabNom as $key => $nom) {
        $deltaMoyen = 0;
        $nb = 0;
        foreach ($$nom as $key => $code_cours_eau) {
            $delta = getDelta($annee1, $annee2, $code_cours_eau);
            //echo "code_cours_eau : " . $code_cours_eau . "delta : " . $delta . "\n";
            if ($delta != 999) {
                $nb++;
                $deltaMoyen += $delta;
            }
        }

        $delta = $deltaMoyen / $nb;

        $tabDelta[] = [
            substr($nom, 3),
            $delta
        ];

        //echo "region " . substr($nom, 3) . " -> delta moyen : " . $delta . "\n";
    }

    echo json_encode($tabDelta);
    //var_dump($tabDelta);

    //echo '----- Fin du script -----' . "\n";
}
