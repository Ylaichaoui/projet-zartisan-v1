<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
* @Route("v1/region", name="api_region_")
*/
class ApiRegionController extends AbstractController
{
    private $regions = [
        '75' => "Île-de-France",
        '77' => "Île-de-France",
        '78' => "Île-de-France",
        '91' => "Île-de-France",
        '92' => "Île-de-France",
        '93' => "Île-de-France",
        '94' => "Île-de-France",
        '95' => "Île-de-France",
        '51' => "Grand Est",  
        '08' => "Grand Est",  
        '10' => "Grand Est",
        '52' => "Grand Est",
        '80' => "Hauts-de-France",
        '02' => "Hauts-de-France",
        '60' => "Hauts-de-France",
        '76' => "Normandie",
        '27' => "Normandie",
        '45' => "Centre-Val de Loire",
        '18' => "Centre-Val de Loire",
        '28' => "Centre-Val de Loire",
        '36' => "Centre-Val de Loire",
        '37' => "Centre-Val de Loire",
        '41' => "Centre-Val de Loire",
        '14' => "Normandie",
        '50' => "Normandie",
        '61' => "Normandie",  
        '21' => "Bourgogne-Franche-Comté",  
        '58' => "Bourgogne-Franche-Comté",
        '71' => "Bourgogne-Franche-Comté",
        '89' => "Bourgogne-Franche-Comté",
        '59' => "Hauts-de-France",
        '62' => "Hauts-de-France",
        '57' => "Grand Est",
        '54' => "Grand Est",
        '55' => "Grand Est",
        '88' => "Grand Est",  
        '67' => "Grand Est",
        '68' => "Grand Est",
        '25' => "Bourgogne-Franche-Comté",
        '39' => "Bourgogne-Franche-Comté",
        '70' => "Bourgogne-Franche-Comté",
        '90' => "Bourgogne-Franche-Comté",  
        '44' => "Pays de la Loire",  
        '49' => "Pays de la Loire",  
        '53' => "Pays de la Loire",
        '72' => "Pays de la Loire",
        '85' => "Pays de la Loire",	
        '35' => "Bretagne",
        '22' => "Bretagne",
        '29' => "Bretagne",
        '56' => "Bretagne",
        '86' => "Nouvelle-Aquitaine",
        '16' => "Nouvelle-Aquitaine",
        '17' => "Nouvelle-Aquitaine",
        '79' => "Nouvelle-Aquitaine",
        '33' => "Nouvelle-Aquitaine",
        '24' => "Nouvelle-Aquitaine",
        '40' => "Nouvelle-Aquitaine",
        '47' => "Nouvelle-Aquitaine",
        '64' => "Nouvelle-Aquitaine",  
        '31' => "Occitanie",  
        '09' => "Occitanie",
        '12' => "Occitanie",
        '32' => "Occitanie",
        '46' => "Occitanie",
        '65' => "Occitanie",
        '81' => "Occitanie",
        '82' => "Occitanie",
        '87' => "Nouvelle-Aquitaine",
        '19' => "Nouvelle-Aquitaine",
        '23' => "Nouvelle-Aquitaine",  
        '69' => "Auvergne-Rhône-Alpes",
        '01' => "Auvergne-Rhône-Alpes",
        '07' => "Auvergne-Rhône-Alpes",
        '26' => "Auvergne-Rhône-Alpes",
        '38' => "Auvergne-Rhône-Alpes",
        '42' => "Auvergne-Rhône-Alpes",  
        '73' => "Auvergne-Rhône-Alpes",  
        '74' => "Auvergne-Rhône-Alpes",
        '63' => "Auvergne-Rhône-Alpes",
        '03' => "Auvergne-Rhône-Alpes",
        '15' => "Auvergne-Rhône-Alpes",
        '43' => "Auvergne-Rhône-Alpes",
        '34' => "Occitanie",
        '11' => "Occitanie",
        '30' => "Occitanie",
        '48' => "Occitanie",
        '66' => "Occitanie", 
        '13' => "Provence-Alpes-Côte d'Azur",
        '04' => "Provence-Alpes-Côte d'Azur",
        '05' => "Provence-Alpes-Côte d'Azur",
        '06' => "Provence-Alpes-Côte d'Azur",
        '83' => "Provence-Alpes-Côte d'Azur",
        '84' => "Provence-Alpes-Côte d'Azur",    
        '20' => "Corse",
        '0' => "DOM-TOM"];

    /**
     * @Route("/list", name="list")
     */
    public function getRegionList()
    {
        // Return a json of unique value from region array
        return $this->json(array_unique($this->regions) , 200, []);
    }

    public function getRegionFromCode($postalCode)
    {
        $postalCode = intval(substr($postalCode, 0, 2));
        if(!is_numeric($postalCode)){
            return NULL;
        }
        if(isset($this->regions[$postalCode])){
            return $this->regions[$postalCode];
        }else{
            return "DOM-TOM";
        }
    }
}
