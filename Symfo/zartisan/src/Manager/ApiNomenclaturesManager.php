<?php

namespace App\Manager;

use App\Entity\Category;
use App\Entity\Job;
use App\Repository\CategoryRepository;
use App\Repository\JobRepository;
use Doctrine\ORM\EntityManagerInterface;

class ApiNomenclaturesManager
{
    private $apiData;
    private $naf;
    private $apiCategorieTable;

    private $apiVersion = "1";
    private $apiBearer = "5a8c90c5-48d4-3966-b476-6f90dbdb966c";

    private $em;

    public function __construct(EntityManagerInterface $em, JobRepository $jobRepository, 
    ApiCategorieTable $apiCategorieTable, CategoryRepository $categoryRepository)
    {
        $this->em = $em;
        $this->jobRepository = $jobRepository;
        $this->apiCategorieTable = $apiCategorieTable;
        $this->categoryRepository = $categoryRepository;
    }

    public function requestNomenclaturesApi()
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

        // Connection to api with header + naf request
        $file = file_get_contents("https://api.insee.fr/metadonnees/nomenclatures/v".$this->apiVersion."/codes/nafr2/sousClasse/".$this->naf, false, $context);
        $results = json_decode($file,true); 
        return $results;
    }

    public function getJobFromApi()
    {
        if(isset ($this->apiData["intitule"])){
            $job = $this->apiData["intitule"];
        }else{
            $job = NULL;
        }
        return $job;
    }

    public function setNomenclaturesDataApi($user)
    {
        $this->naf = $user->getNaf();
        $this->apiData = $this->requestNomenclaturesApi();

        $job = $this->jobRepository->isFound($this->getJobFromApi());
        if($job == NULL){
            // If job not in database, create a new job entry & add data
            $job = new Job();
            $job->setName($this->getJobFromApi());

            $output = explode(".", $user->getNaf());
            $categoryName = $this->apiCategorieTable->getCategorie($output[0]);
            $categoryExist = $this->categoryRepository->isFound($categoryName);
            if ($categoryExist == NULL){
                // If category not in database, create a new category entry & add data
                $category = new Category();
                $category->setName($categoryName);
                $this->em->persist($category);
                $this->em->flush();
            }else{
               $category = $categoryExist; 
            }

            $job->setCategory($category);
            $this->em->persist($job);
            $this->em->flush();
        }

        $user->setJob($job);
        return $user;
    }
}