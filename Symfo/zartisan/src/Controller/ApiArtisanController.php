<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
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
        if ($request->getContent()) {
            
            $job = $request->get('idJob');
            $region = $request->get('nameRegion');

            $arrayUsers = $userRepository->search($job,$region);

            return $this->json($arrayUsers, 200, [],['groups' => 'user_artisan_search']);
        }
        return $this->json(['error' => 'unexpected information for edit request'], 304, []);
    }
    
    /**
     * @Route("/edit", name="edit")
     */
    public function edit(UserRepository $userRepository, Request $request, EntityManagerInterface $em)
    {
        if ($request->getContent()) {

            $userId = $request->get('id');
            $user = $userRepository->find($userId);

            if($request->get('companyDescription')){
                $user->setCompanyDescription($request->get('companyDescription'));
            }

            // TODO : Add this in register after set company
            // $user->setPictureFolder($user->getCompany());
            if ($request->get('picture')) {
                $user->setPicture($request->get('picture'));
            }

            $user->setUpdatedAt(new \DateTime());

            $em->persist($user);
            $em->flush();
            return $this->json($user, 200, []);
        }
        return $this->json(['error' => 'unexpected information for edit request'], 304, []);
    }
    
    /**
     * @Route("/single", name="single")
     */
    public function single(Request $request, UserRepository $userRepository)
    {
        if ($request->getContent()) {
            
            if ($request->get('email')) {
                $user = $userRepository->isFoundMail($request->get('email'));
                
                if ($user == NULL) {

                    return $this->json(['error' => 'no user register'], 304, []);

                }

                return $this->json($user , 200, [], ['groups' => 'user_artisan_single']);
            }
            return $this->json(['error' => 'no email found'], 304, []);
        }
        return $this->json(['error' => 'no request'], 304, []);
    }


}
