<?php

namespace App\Controller;

use App\Entity\User;

use App\Repository\UserRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/api/v1/artisan", name="api_artisan_")
*/
class ApiArtisanController extends AbstractController
{
    /**
     * @Route("/list", name="all")
     */
    public function all(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        $arrayUsers = [];
        
        foreach($users as $user){
            $arrayUsers[] = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'url' => $this->generateUrl('api_artisan_single', [
                    'id' => $user->getId()
                ], UrlGeneratorInterface::ABSOLUTE_URL)
            ];
        }
        return $this->json($arrayUsers , 200, []);
    }

    /**
     * @Route("/{id}", name="single")
     */
    public function single(User $user, SerializerInterface $serializer)
    {
        $data = $serializer->serialize($user, 'json', ['groups' => 'user_artisan_single']);

        return $this->json($data , 200, [], ['groups' => 'user_artisan_single']);
    }
}
