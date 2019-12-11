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
     * @Route("api/sirene", name="sirene")
     */
    public function ApiIndexSirene($siret)
    {
        $sirene = $this->apiSireneManager;

        $sirene->setSireneDataApi($siret);

        return;
    }
}
