<?php

namespace App\Controller;

use App\Services\FoldersUser;
use App\Manager\SecurityManager;
use App\Repository\RateRepository;
use App\Repository\UserRepository;
use App\Services\FileLogoCreate;
use App\Services\FileTablePictures;
use App\Repository\AdviceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("v1/artisan", name="api_artisan_")
 */
class ApiArtisanController extends AbstractController
{

    /**
     * @Route("/edit", name="edit")
     */
    public function edit(
        UserRepository $userRepository,
        Request $request,
        EntityManagerInterface $em,
        FoldersUser $foldersUser,
        FileLogoCreate $fileLogoCreate,
        FileTablePictures $fileTablePictures,
        SecurityManager $securityManager
    ) {
        if ($request->get('email')) {

            // if good format email
            $error = $securityManager->securityEmail($request->get('email'));
            if (isset($error)) {
                return $this->json(['error' => $error], 409);
            }

            // verify if  email is in the BDD
            $userEmail = $request->get('email');

            // if email don't find
            if (!$userRepository->isFoundMail($request->get('email'))) {
                return $this->json(['error' => 'Email not exist'], 404);
            }
            $user = $userRepository->isFoundMail($userEmail);

            // verify if folder exist
            $userRole = 'ARTISAN';
            $foldersUser->isFolder($userEmail, $userRole);  // verification if folder exist

            // if picture is uploaded
            $picture64 = ($request->get('picture'));
            $image = substr("$picture64", 0, 6);
            if ($image != "assets") {
                $file = $fileLogoCreate->createPicture($picture64, $userEmail);   // inject avatar in file logo
                $user->setPicture($file);
            }

            // // if pictureFolder is uploaded 
            // $pictureFolder64 = ($request->get('pictureFolder'));
            // $counter = count($pictureFolder64);

            // if ($counter != 0) {
            // $file = $fileTablePictures->createTablePictures($pictureFolder64, $userEmail);   // inject pictures in file compagny
            //     if ($file == 409) {
            //         return $this->json(['error' => 'Vous devez uploader un fichier de type png, jpg, jpeg'], 409);
            //  //$user->setPictureFolder([$file]);
            //     }
            // }


            $user->setCompanyDescription($request->get('companyDescription'));

            $user->setPhone($request->get('phone'));
            // TODO : Add this in register after set company
            // $user->setPictureFolder($user->getCompany());
            // if ($request->get('picture')) {
            //     $user->setPicture($file);
            // }

            $user->setUpdatedAt(new \DateTime());

            $em->persist($user);
            $em->flush();
            return $this->json($user, 200, [], ['groups' => 'user_artisan_single']);
        }
        return $this->json(['error' => 'unexpected information for edit request'], 304, []);
    }

    /**
     * @Route("/list", name="all")
     */
    public function all(UserRepository $userRepository)
    {
        $users = $userRepository->findAll();

        $arrayUsers = [];

        foreach ($users as $user) {
            $arrayUsers[] = [
                'id' => $user->getId(),
                'email' => $user->getEmail(),
                'url' => $this->generateUrl('api_artisan_single', [
                    'id' => $user->getId()
                ], UrlGeneratorInterface::ABSOLUTE_URL)
            ];
        }
        return $this->json($arrayUsers, 200, []);
    }


    /**
     * @Route("/recherche", name="recherche")
     */
    public function searchByRate(UserRepository $userRepository, Request $request)
    {
        $arrayUsers = [];
        if ($request->get('idJob')) {

            $job = $request->get('idJob');
            $region = $request->get('nameRegion');

            $arrayUsers = $userRepository->searchOrderRate($job, $region);

            return $this->json($arrayUsers, 200, [], ['groups' => 'user_artisan_search']);
        }
        return $this->json(['error' => 'unexpected information for edit request'], 304, []);
    }


    /**
     * @Route("/single", name="single")
     */
    public function single(
        Request $request,
        AdviceRepository $adviceRepository,
        RateRepository $rateRepository,
        UserRepository $userRepository,
        SecurityManager $securityManager
    ) {
        if ($request->get('email')) {

            // if good format email
            $error = $securityManager->securityEmail($request->get('email'));
            if (isset($error)) {
                return $this->json(['error' => $error], 409);
            }

            // verify if  email is in the BDD
            $userEmail = $request->get('email');

            // if email don't find
            if (!$userRepository->isFoundMail($request->get('email'))) {
                return $this->json(['error' => 'Email not exist'], 404);
            }

            $user = $userRepository->isFoundMail($request->get('email'));
            $advices = $adviceRepository->isFoundAdvice($user->getId());

            return $this->json([$user, $advices], 200, [], ['groups' => 'user_artisan_advice']);
        }
        return $this->json(['error' => 'no request'], 304, []);
    }
}
