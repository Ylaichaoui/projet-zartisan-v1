<?php

namespace App\Controller;

use App\Controller\ApiRegionController;
use App\Manager\SecurityManager;
use App\Repository\UserRepository;
use App\Services\FileLogoCreate;
use App\Services\FoldersUser;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;


/**
 * @Route("api/v1/user", name="api_user_")
 */
class ApiUserController extends AbstractController
{

    /**
     * @Route("/edit", name="edit")
     * modification profil user
     */
    public function edit(
        Request $request,
        UserRepository $userRepository,
        EntityManagerInterface $em,
        FoldersUser $foldersUser,
        FileLogoCreate $fileLogoCreate,
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
            $user = $userRepository->isFoundMail($request->get($userEmail));

            // verify if folder existgit statu
            $foldersUser->isFolder($userEmail);  // verification if folder exist

            // if picture is uploaded
            $picture64 = ($request->get('picture'));
            $image = substr("$picture64", 0, 6);
            if ($image != "assets") {
                $file = $fileLogoCreate->createPicture($picture64, $userEmail);   // inject avatar in file logo
                $user->setPicture($file);
            }

            $apiRegionController = new ApiRegionController();
            $region = $apiRegionController->getRegionFromCode($request->get('postalCode'));

            // search in the BDD id and email and role and status and confirmail
            $userRole = $user->getRoles();
            $userStatus = $user->getIsStatus();

            // if role  == user and user is enable
            if ($userRole[0] == "ROLE_USER" && $userStatus == 'true') {
                $user->setEmail($request->get('email'));
                $user->setFirstname($request->get('firstname'));
                $user->setLastname($request->get('lastname'));
                $user->setBirthday($request->get('birthday'));
                $user->setAdressSupp($request->get('adressSupp'));
                $user->setSpecialDistribution($request->get('specialDistribution'));
                $user->setExtNumberWay($request->get('extNumberWay'));
                $user->setNumberWay($request->get('numberWay'));
                $user->setTypeWay($request->get('typeWay'));
                $user->setWay($request->get('way'));
                $user->setPostalCode($request->get('postalCode'));
                $user->setRegion($region);
                $user->setCity($request->get('city'));
                $user->setPhone($request->get('phone'));
                $user->setNickname($request->get('nickname'));
                $user->setUpdatedAt(new \DateTime());

                $em->flush();
                return $this->json($user, 200, [], ['groups' => 'user_user_single']);
            } else {
                return $this->json(['error' => 'unexpected information for edit request'], 404);
            }
        } else {
            return $this->json(['error' => 'unexpected information for edit request'], 304);
        }
    }

    /**
     * @Route("/delete", name="delete")
     * Disable user, keep the datas
     */
    public function delete(
        EntityManagerInterface $em,
        Request $request,
        UserRepository $userRepository,
        SecurityManager $securityManager
    ) {
        // if request is ok
        if ($request->get('email')) {

            // if good format email
            $error = $securityManager->securityEmail($request->get('email'));
            if (isset($error)) {
                return $this->json(['error' => $error], 409);
            }

            // verify if  email is in the BDD
            $user = $userRepository->isFoundMail($request->get('email'));

            // if email don't find
            if (!$userRepository->isFoundMail($request->get('email'))) {
                return $this->json(['error' => 'Email not exist'], 404);
            }

            // si user existe on modifie la base de données
            if ($user != null) {
                $user->setIsStatus(false);
                $em->flush();
                return $this->json(['success' => 'utilisatuer disable'], 200);
            } else {
                return $this->json(['error' => 'unexpected information for edit request'], 404);
            }
        } else {
            return $this->json(['error' => 'unexpected information for edit request'], 304);
        }
    }

    /**
     * @Route("/list", name="all")
     * list all users ROLE_USER and enabled
     */
    public function all(UserRepository $userRepository)
    {
        // list all users  ROLE_USER and enabled
        $users = $userRepository->findAllUser();

        $arrayUsers = [];

        foreach ($users as $individual) {
            $arrayUsers[] = [
                'id' => $individual->getId(),
                'email' => $individual->getEmail(),
                'role' => $individual->getRoles(),
                'url' => $this->generateUrl('api_user_single', [
                    'id' => $individual->getId()
                ], UrlGeneratorInterface::ABSOLUTE_URL)
            ];
        }

        return $this->json($arrayUsers, 200);
    }

    /**
     * @Route("/single", name="single")
     * list a user
     */
    public function single(Request $request, UserRepository $userRepository, SecurityManager $securityManager)
    {
        if ($request->get('email')) {

            // if good format email
            $error = $securityManager->securityEmail($request->get('email'));
            if (isset($error)) {
                return $this->json(['error' => $error], 409);
            }

            // verify if  email is in the BDD
            $user = $userRepository->isFoundMail($request->get('email'));

            // if email don't find
            if (!$userRepository->isFoundMail($request->get('email'))) {
                return $this->json(['error' => 'Email not exist'], 404);
            }

            // if  user exist we return user
            if ($user != null) {
                return $this->json($user, 200, [], ['groups' => 'user_user_single']);
            } else {
                return $this->json(['error' => 'user not found'], 404);
            }
        } else {
            return $this->json(['error' => 'unexpected information for edit request'], 304);
        }
    }
}
