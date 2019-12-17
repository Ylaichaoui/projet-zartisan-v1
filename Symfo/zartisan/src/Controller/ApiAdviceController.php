<?php

namespace App\Controller;

use App\Entity\Advice;
use App\Repository\UserRepository;
use App\Repository\AdviceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
* @Route("api/v1/advice", name="api_advice_")
*/
class ApiAdviceController extends AbstractController
{

    /**
     * @Route("/add", name="_add")
     * user add advice for an artisan
     */
   public function add(Request $request, UserRepository $userRepository, EntityManagerInterface $em)
    {   
        if ($request->get('artisanId')) {

            // search id and email in the request
            $userPro = $userRepository->find($request->get('artisanId'));
            $userAuthor = $userRepository->isFoundMail($request->get('email'));
           
            if ($userAuthor != null) 
            {
                $advice = new Advice();
                $body = $request->get('body');
                $advice->setBody($body);
                $advice->setIsStatus(true);
                $advice->setUserAuthor($userAuthor);
                $advice->setUserPro($userPro);
                $advice->setisReported(false);
                $em->persist($advice);
                $em->flush();
               
                return $this->json($advice, 200, [], ['groups' => 'user_advice']);
            } else {
                return $this->json(['error' => 'unexpected information for add request'], 404);
            }
        } else {
            return $this->json(['error' => 'unexpected information for edit request'], 304);
        }   
    } 

    /**
     * @Route("/report", name="_report")
     */
    public function report(Request $request, EntityManagerInterface $em, AdviceRepository $adviceRepository)
    {   
        if ($request->get('id')) {

            $advice = $adviceRepository->find($request->get('id'));
           
            if ($advice != null) 
            {
                $advice->setIsReported('true');
                $em->persist($advice);
                $em->flush();
               
                return $this->json($advice, 200, [], ['groups' => 'user_advice']);
            } else {
                return $this->json(['error' => 'no advice selected'], 304);
            }
        } else {
            return $this->json(['error' => 'unexpected information for report request'], 404);
        }   
    }

}