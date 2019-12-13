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

    public function ApiIndexSirene($siret)
    {
        $this->apiSireneManager->setSireneDataApi($siret);
        return;
    }

    /**
     * @Route("sirene/test/{id}", name="sirene")
     */
    public function ApiTestSirene($id)
    {
        return $this->json(['return' => $this->apiSireneManager->requestSireneApi($id)], 200);
    }
}
