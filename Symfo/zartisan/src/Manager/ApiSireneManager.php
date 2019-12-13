<?php

namespace App\Manager;

use App\Controller\ApiRegionController;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;

use App\Manager\ApiCompanyManager;
use App\Manager\ApiNomenclaturesManager;


class ApiSireneManager
{
    private $apiData;
    private $siret;

    private $userRepository;
    private $apiCompanyManager;
    private $apiNomenclaturesManager;

    private $apiVersion = "3";
    private $apiBearer = "5a8c90c5-48d4-3966-b476-6f90dbdb966c";

    private $em;

    public function __construct(EntityManagerInterface $em, UserRepository $userRepository, 
    ApiCompanyManager $apiCompanyManager, ApiNomenclaturesManager $apiNomenclaturesManager)
    {
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->apiCompanyManager = $apiCompanyManager;
        $this->apiNomenclaturesManager = $apiNomenclaturesManager;
    }

    public function requestSireneApi($optSiret = 0)
    {  
        // Make Hearder for request to api
        $opts = array(
            'http'=>array(
            'method'=>"GET",
            'header'=>"authorization: Bearer ".$this->apiBearer,
            "content-type: application/json"
            )
        );
        
        $context = stream_context_create($opts);
        
        // Connection to api with header + siret request
        if($optSiret != 0){
            // add the @ parameter to prevent bad request answer for test siret
            $result = @file_get_contents("https://api.insee.fr/entreprises/sirene/V".$this->apiVersion."/siret/".$optSiret, false, $context);
            if($result == FALSE){
                return FALSE;
            }
            return TRUE;
        }else{
            $file = file_get_contents("https://api.insee.fr/entreprises/sirene/V".$this->apiVersion."/siret/".$this->siret, false, $context);
            $results = json_decode($file,true); 
            return $results;
        }
    }

    public function getCompagnyFromApi()
    {
        if(isset ($this->apiData["etablissement"]["uniteLegale"]["denominationUniteLegale"])){
            $company = $this->apiData["etablissement"]["uniteLegale"]["denominationUniteLegale"];
        }else{
            $company = NULL;
        }
        return $company;
    }

    public function getNafFromApi()
    {
        if(isset ($this->apiData["etablissement"]["uniteLegale"]["activitePrincipaleUniteLegale"])){
            $naf = $this->apiData["etablissement"]["uniteLegale"]["activitePrincipaleUniteLegale"];
        }else{
            $naf = NULL;
        }
        return $naf;
    }

    public function getNafEncodeFromApi()
    {
        if(isset ($this->apiData["etablissement"]["uniteLegale"]["nomenclatureActivitePrincipaleUniteLegale"])){
            $nafEncode = $this->apiData["etablissement"]["uniteLegale"]["nomenclatureActivitePrincipaleUniteLegale"];
        }else{
            $nafEncode = NULL;
        }
        return $nafEncode;
    }

    public function getCompAdresseFromApi()
    {
        if(isset ($this->apiData["etablissement"]["adresseEtablissement"]["complementAdresseEtablissement"])){
            $compAdresse = $this->apiData["etablissement"]["adresseEtablissement"]["complementAdresseEtablissement"];
        }else{
            $compAdresse = NULL;
        }
        return $compAdresse;
    }

    public function getNVoieFromApi()
    {
        if(isset ($this->apiData["etablissement"]["adresseEtablissement"]["numeroVoieEtablissement"])){
            $indexRepVoie = $this->apiData["etablissement"]["adresseEtablissement"]["numeroVoieEtablissement"];
        }else{
            $indexRepVoie = NULL;
        }
        return $indexRepVoie;
    }

    public function getExtVoieFromApi()
    {
        if(isset ($this->apiData["etablissement"]["adresseEtablissement"]["indiceRepetitionEtablissement"])){
            $indexRepVoie = $this->apiData["etablissement"]["adresseEtablissement"]["indiceRepetitionEtablissement"];
        }else{
            $indexRepVoie = NULL;
        }
        return $indexRepVoie;
    }

    public function getTypeVoieFromApi()
    {
        if(isset ($this->apiData["etablissement"]["adresseEtablissement"]["typeVoieEtablissement"])){
            $typeVoie = $this->apiData["etablissement"]["adresseEtablissement"]["typeVoieEtablissement"];
        }else{
            $typeVoie = NULL;
        }
        return $typeVoie;
    }

    public function getLibVoieFromApi()
    {
        if(isset ($this->apiData["etablissement"]["adresseEtablissement"]["libelleVoieEtablissement"])){
            $libVoie = $this->apiData["etablissement"]["adresseEtablissement"]["libelleVoieEtablissement"];
        }else{
            $libVoie = NULL;
        }
        return $libVoie;
    }

    public function getPostalcodeFromApi()
    {
        if(isset ($this->apiData["etablissement"]["adresseEtablissement"]["codePostalEtablissement"])){
            $postalCode = $this->apiData["etablissement"]["adresseEtablissement"]["codePostalEtablissement"];
        }else{
            $postalCode = NULL;
        }
        return $postalCode;
    }

    public function getCommuneFromApi()
    {
        if(isset ($this->apiData["etablissement"]["adresseEtablissement"]["libelleCommuneEtablissement"])){
            $commune = $this->apiData["etablissement"]["adresseEtablissement"]["libelleCommuneEtablissement"];
        }else{
            $commune = NULL;
        }
        return $commune;
    }

    public function getSpcDistribFromApi()
    {
        if(isset ($this->apiData["etablissement"]["adresseEtablissement"]["distributionSpecialeEtablissement"])){
            $spcDistrib = $this->apiData["etablissement"]["adresseEtablissement"]["distributionSpecialeEtablissement"];
        }else{
            $spcDistrib = NULL;
        }
        return $spcDistrib;
    }

    public function setSireneDataApi($siret)
    {
        $this->siret = $siret;
        $this->apiData = $this->requestSireneApi();
        // Test on UserRepository if siret already exist
        if($this->userRepository->isFound($this->siret) != NULL){
            // Get the user where is register with this siret
            $user = $this->userRepository->isFound($this->siret);
            // Save all data from api
            
            $user->setCompany($this->getCompagnyFromApi());
            $user->setNaf($this->getNafFromApi());
            $user->setAdressSupp($this->getCompAdresseFromApi());
            $user->setNumberWay($this->getNVoieFromApi());
            $user->setExtNumberWay($this->getExtVoieFromApi());
            $user->setTypeWay($this->getTypeVoieFromApi());
            $user->setWay($this->getLibVoieFromApi());
            $user->setPostalCode($this->getPostalcodeFromApi());

            // Get Postalcode to request controller to register region
            $apiRegionController = new ApiRegionController();
            $region = $apiRegionController->getRegionFromCode($user->getPostalCode());
            $user->setRegion($region);

            $user->setCity($this->getCommuneFromApi());
            $user->setSpecialDistribution($this->getSpcDistribFromApi());
            
            // TODO : Change api service or buy some credit for presentation day
            // Connection to ApiCompagnyManager to get info for user (phone + mail)
            // The api fonctionnality work fully but the cost of api service is really expensive
            // 
            // $this->apiCompanyManager->setCompanyDataApi($user);

            // Connection to ApiNomenclaturesManager to reister job & category
            $this->apiNomenclaturesManager->setNomenclaturesDataApi($user);

            $this->em->persist($user);
            $this->em->flush();
            return $user;
        }
        // TODO Return a formated JSON with status code for error
        return $this->apiData;
    }
}