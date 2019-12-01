<?php

namespace App\Controller;

use App\Entity\User;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
* @Route("/api/v1/artisan", name="api_artisan_")
*/
class ApiArtisanController extends AbstractController
{
    /**
     * @Route("/{id}", name="single")
     */
    public function single(User $user)
    {
        return $this->json($user, 200, [], ['groups' => 'artisan_single']);
    }
}
