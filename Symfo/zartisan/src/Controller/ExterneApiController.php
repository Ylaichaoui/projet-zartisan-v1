<?php

namespace App\Controller;

use App\Manager\ApiSireneManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ExterneApiController extends AbstractController
{
    private $apiSireneManager;

    public function __construct(ApiSireneManager $apiSireneManager)
    {
        $this->apiSireneManager = $apiSireneManager;
    }

    /**
     * @Route("/api/sirene", name="sirene")
     */
    public function ApiIndexSirene()
    {
        $sirene = $this->apiSireneManager; 
        // TODO Manually add siret for add data on bdd ! need to be link with mail & pasword !    
        //$sirene->setMovieDataApi(57210489100013);
    }
}
