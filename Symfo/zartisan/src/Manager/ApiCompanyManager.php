<?php

namespace App\Manager;

use Doctrine\ORM\EntityManagerInterface;

class ApiCompanyManager
{
    private $apiData;
    private $siret;

    private $apiVersion = "2";
    private $apiKey = "omlc1n3j5qnami8834njf21vevst0lvctk3cmtl6smpcc613hib";
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function requestCompanyApi()
    {  
        // Make Hearder for request to api
        $opts = array(
            'http'=>array(
            'method'=>"GET",
            "content-type: application/json"
            )
        );
        
        $context = stream_context_create($opts);
        
        // Connection to api with header + apiKey + siret request
        $file = file_get_contents("https://societeinfo.com/app/rest/api/v".$this->apiVersion."/company.json/".$this->siret."?key=".$this->apiKey, false, $context);
        $results = json_decode($file,true); 
        return $results;
    }

    public function getFirstnameFromApi()
    {
        if(isset ($this->apiData["result"]["contacts"]["main_corporate_officier"]) && isset ($this->apiData["result"]["contacts"]["main_corporate_officier"]["firstName"])){
            $firstname = $this->apiData["result"]["contacts"]["main_corporate_officier"]["firstName"];
        }else{
            $firstname = "unknown";
        }
        return $firstname;
    }

    public function getLastnameFromApi()
    {
        if(isset ($this->apiData["result"]["contacts"]["main_corporate_officier"]) && isset ($this->apiData["result"]["contacts"]["main_corporate_officier"]["lastName"])){
            $lastname = $this->apiData["result"]["contacts"]["main_corporate_officier"]["lastName"];
        }else{
            $lastname = "unknown";
        }
        return $lastname;
    }

    public function getPhoneFromApi()
    {
        if(isset ($this->apiData["result"]["contacts"]["phones"][0])){
            $phone = $this->apiData["result"]["contacts"]["phones"][0];
        }else{
            $phone = NULL;
        }
        return $phone;
    }

    public function getBirthdayFromApi()
    {
        if(isset ($this->apiData["result"]["contacts"]["main_corporate_officier"]["birth_date"])){
            $birthday = $this->apiData["result"]["contacts"]["main_corporate_officier"]["birth_date"];
        }else{
            $birthday = NULL;
        }
        return $birthday;
    }



    public function setCompanyDataApi($user)
    {
        $this->siret = $user->getSiret();
        $this->apiData = $this->requestCompanyApi();
        if ($this->apiData["success"]== true) {
            // Save all data from api
            $user->setFirstname($this->getFirstnameFromApi());
            $user->setLastname($this->getLastnameFromApi());
            $phone = $this->getPhoneFromApi();
            if($phone != NULL){
                $user->setPhone($phone["value"]);
            }
            if($this->getBirthdayFromApi() != NULL){
                $user->setBirthday(\DateTime::createFromFormat('Y-m-d', $this->getBirthdayFromApi()));
            }
            $this->em->persist($user);
            $this->em->flush();
        }
        return $user;
    }
}