<?php

namespace App\Controller;


use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;


/**
* @Route("/v1/user", name="api_user_")
*/
class ApiUserController extends AbstractController
{
    /**
     * @Route("/list", name="all")
     * 
     * list all users ROLE_USER and enabled
     */
    public function all(UserRepository $userRepository)
    {
        // list all users  ROLE_USER and enabled
        $users = $userRepository->findAllUser();
        
        $arrayUsers = [];

        foreach($users as $individual){
            $arrayUsers[] = [
                'id' => $individual->getId(),
                'email' => $individual->getEmail(),
                'role' => $individual->getRoles(),
                'url' => $this->generateUrl('api_user_single', [
                    'id' => $individual->getId()
                ], UrlGeneratorInterface::ABSOLUTE_URL)
            ];
        }

        return $this->json($arrayUsers , 200);
    }

    /**
     * @Route("/{id}", name="single")
     * 
     * list a user 
     */
    public function single(User $user, SerializerInterface $serializer, Request $request, UserRepository $userRepository)
    {
        if ($request->getContent()) {
            $userId = $request->request->get('id');

            $user = $userRepository->find($userId);

            // si user existe on injecte les modifications
            if ($user != null) {
                $data = $serializer->serialize($user, 'json', ['groups' => 'user_user_single']);
                return $this->json($data, 200, [], ['groups' => 'user_user_single']);

            }else{
                return $this->json(['error' => 'unexpected information for edit request'], 404);
            }

        }else {
            return $this->json(['error' => 'unexpected information for edit request'], 304);
        }
    }

    /**
     * @Route("/edit/{id}", name="edit")
     * 
     * modification profil user
     */
    public function edit(User $user, Request $request, EntityManagerInterface $em, UserRepository $userRepository)
    {

       
        // si la requete est ok
        if ($request->getContent()) {
            $userId = $request->request->get('id');
            $user = $userRepository->find($userId);

            // si user existe on injecte les modifications
            if ($user != null) 
                { 
                    $email = $request->request->get('email');
                    $firstname = $request->get('firstname');
                    $lastname = $request->get('lastname');
                    $birthday = $request->get('birthday');
                    $adressSupp = $request->get('adressSupp');
                    $specialDistribution = $request->get('specialDistribution');
                    $extNumberWay = $request->get('extNumberWay');
                    $numberWay = $request->get('numberWay');
                    $typeWay = $request->get('typeWay');
                    $way= $request->get('way');
                    $postalCode = $request->get('postalCode');
                    $city = $request->get('city');
                    $phone = $request->get('phone');
                    $picture = $request->get('picture');
                    $nickname = $request->get('nickname');
                    
                    if ($email != $user->getEmail()) {
                        $user->setEmail($email);
                    }
                    if ($firstname != $user->getFirstname()) {
                        $user->setFirstname($firstname);
                    }
                    if ($lastname != $user->getLastname()) {
                        $user->setLastname($lastname);
                    }
                    if ($birthday != $user->getBirthday()) {
                        $user->setBirthday($birthday);
                    }
                    if ($adressSupp != $user->getAdressSupp()) {
                        $user->setAdressSupp($adressSupp);
                    }
                    if ($specialDistribution != $user->getSpecialDistribution()) {
                        $user->setSpecialDistribution($specialDistribution);
                    }
                    if ($extNumberWay != $user->getExtNumberWay()) {
                        $user->setExtNumberWay($extNumberWay);
                    }
                    if ($numberWay != $user->getNumberWay()) {
                        $user->setNumberWay($numberWay);
                    }
                    if ($typeWay != $user->getTypeWay()) {
                        $user->setTypeWay($typeWay);
                    }
                    if ($way != $user->getWay()) {
                        $user->setWay($way);
                    }
                    if ($postalCode != $user->getPostalCode()) {
                        $user->setPostalCode($postalCode);
                    }
                    if ($city != $user->getCity()) {
                        $user->setCity($city);
                    }
                    if ($phone != $user->getPhone()) {
                        $user->setPhone($phone);
                    }
                    if ($picture != $user->getPicture()) {
                        $user->setPicture($picture);
                    }
                    if ($nickname != $user->getNickname()) {
                        http://localhost/
                    {
                        $user->setNickname($nickname);
                    }

                        $user->setUpdatedAt(new \DateTime());
                    }
                
                    $em->flush();
                    return $this->json($user, 200);
                }else {
                    return $this->json(['error' => 'unexpected information for edit request'], 404);
            }
        }else {
            return $this->json(['error' => 'unexpected information for edit request'], 304);
        }
        
    }
    /**
     * @Route("/delete/{id}", name="delete")
     */
    public function delete(User $user, EntityManagerInterface $em)
    {
        // disable user but don't delete data
        $user->setIsStatus(false);
        $em->persist($user);
        $em->flush(); 
        return $this->json($user, 200);
    }


}
