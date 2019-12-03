<?php

namespace App\Manager;

class ApiCategorieTable{
    
    // TODO possible to do a short description of the work but need to be not small cause of duplication
    // exemple "Fabrication de boissons" & "Fabrication de textiles" cannot just "Fabrication"
    // A ... U need sort category
    // TODO need another relation many to one to another table for easyer search
    private $category = [
        1 => "Culture et production animale",
        2 => "Sylviculture",
        3 => "Pêche et aquaculture",
        5 => "Extraction de houille",
        6 => "Extraction d'hydrocarbures",
        7 => "Extraction de minerais",
        8 => "Autres industries extractives",
        9 => "Soutien aux industries extractives",
        10 => "Industries alimentaires",
        11 => "Fabrication de boissons",
        12 => "Fabrication à base de tabac",
        13 => "Fabrication de textiles",
        14 => "Industrie de l'habillement",
        15 => "Industrie du cuir et de la chaussure",
        16 => "Travail du bois",
        17 => "Industrie du papier et du carton",
        18 => "Imprimerie et reproduction",
        19 => "Cokéfaction et raffinage",
        20 => "Industrie chimique",
        21 => "Industrie pharmaceutique",
        22 => "Fabrication en caoutchouc et en plastique",
        23 => "Fabrication minérale non métalliques",
        24 => "Métallurgie",
        25 => "Produits métalliques",
        26 => "Produits informatiques",
        27 => "Equipements électriques",
        28 => "Machines et équipements n.c.a.",
        29 => "Industrie automobile",
        30 => "Matériels de transport",
        31 => "Fabrication de meubles",
        32 => "Autres industries manufacturières",
        33 => "Réparation machines et d'équipements",
        35 => "Production d'énergie",
        36 => "Traitement d'eau",
        37 => "Traitement des eaux usées",
        38 => "Traitement des déchets",
        39 => "Dépollution et déchets",
        41 => "Construction de bâtiments",
        42 => "Génie civil",
        43 => "Construction spécialisés",
        45 => "Automobiles et motocycles",
        46 => "Commerce de gros",
        47 => "Commerce de détail",
        49 => "Transports terrestres",
        50 => "Transports par eau",
        51 => "Transports aériens",
        52 => "Entreposage en transports",
        53 => "Poste et courrier",
        55 => "Hébergement",
        56 => "Restauration",
        58 => "Édition",
        59 => "Production vidéo",
        60 => "Programmation et diffusion",
        61 => "Télécommunications",
        62 => "Informatiques",
        63 => "Services d'information",
        64 => "Services financiers",
        65 => "Assurance",
        66 => "Auxiliaires de financiers et d'assurance",
        68 => "Immobilier",
        69 => "Juridique & Comptable",
        70 => "Conseil de gestion",
        71 => "Architecture",
        72 => "R&D scientifique",
        73 => "Publicité",
        74 => "Activités scientifiques et techniques",
        75 => "Vétérinaires",
        77 => "Location",
        78 => "Emploi",
        79 => "Voyage",
        80 => "Sécurité",
        81 => "Bâtiment et aménagement paysager",
        82 => "Soutien aux entreprises",
        84 => "Administration",
        85 => "Enseignement",
        86 => "Santé humaine",
        87 => "Hébergement médico-social",
        88 => "Action sociale",
        90 => "Activités Artistiques",
        91 => "Archivage culturelles",
        92 => "Jeux de hasard",
        93 => "Sport",
        94 => "Organisations associatives",
        95 => "Réparation de biens personnels",
        96 => "Autres services personnels",
        97 => "Ménages",
        98 => "Services pour usage propre",
        99 => "Extraterritoriale"
    ];

    public function getCategorie(int $number){
        return $this->category[$number];
    }

    public function getAllCategorie(){
        return $this->category;
    }
}