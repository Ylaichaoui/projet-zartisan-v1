<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("/v1/artisan", name="api_artisan_")
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
     * @Route("/recherche", name="recherche")
     */
    public function search(UserRepository $userRepository, Request $request)
    {
        $arrayUsers = [];
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);

            $job = $parametersAsArray['job'];
            $region = $parametersAsArray['region'];

            $arrayUsers = $userRepository->search($job,$region);
            
            return $this->json($arrayUsers , 200, [],['groups' => 'user_artisan_single']);
        }
        return $this->json(['error' => 'unexpected information for edit request'], 304, []);
    }

    /**
     * @Route("/edit", name="edit")
     */
    public function edit(UserRepository $userRepository, Request $request, EntityManagerInterface $em)
    {
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);

            $userId = $parametersAsArray['id'];
            $user = $userRepository->find($userId);

            $user->setCompanyDescription($parametersAsArray['companyDescription']);
            // TODO : Add this in register after set company
            // $user->setPictureFolder($user->getCompany());
            $user->setPicture($parametersAsArray['picture']);
            $user->setUpdatedAt(new \DateTime());

            $em->persist($user);
            $em->flush();
            return $this->json($user, 200, []);
        }
        return $this->json(['error' => 'unexpected information for edit request'], 304, []);
    }
    
    /**
     * @Route("/{id}", name="single")
     */
    public function single(User $user, SerializerInterface $serializer)
    {
        return $this->json($user , 200, [], ['groups' => 'user_artisan_single']);
    }

}
