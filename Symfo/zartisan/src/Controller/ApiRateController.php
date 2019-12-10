<?php

namespace App\Controller;

use App\Entity\Rate;
use App\Repository\RateRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("api/v1/rate", name="api_rate_")
*/
class ApiRateController extends AbstractController
{
    /**
     * @Route("/add", name="add")
     * user add rate for an artisan
     */
    public function add(Request $request, UserRepository $userRepository, EntityManagerInterface $em, RateRepository $rateRepository)
    {   
        if ($request->getContent()) {

            // search email user and id artisan in the request
            $userPro = $userRepository->find($request->request->get('artisanid'));
            $userAuthor = $userRepository->isFoundMail($request->request->get('email'));
            $value = $request->request->get('rate');
            $rateId = $request->request->get('id');

            if ($userAuthor != null) 
            {
  
                $user = $userAuthor->getId();
                            
                if ($rateId == null) {
                    $rate = new Rate();
                    $rate->setValue($value);
                    $rate->setUserAuthor($userAuthor);
                    $rate->setUserPro($userPro);
                    $em->persist($rate);
                }else {
                    $rate = $rateRepository->find($request->request->get('id'));
                    $rate->setValue($value);
                    $rate->setUserAuthor($userAuthor);
                    $rate->setUserPro($userPro);
                }
            
                $userAverageRate = $userPro->getAverageRate();
                
                $userAverageRate = $rateRepository->findByUserPro($userPro);

                $sum = 0;
                foreach($userAverageRate as $indexrate ) {
                    // Need to get value on array of array
                    $sum += $indexrate["value"];
                }

                // get int of sum value round to 0 decimal
                $note = intval(round($sum / count($userAverageRate),0));
                $userPro->setAverageRate($note);
                $em->flush();

                return $this->json($note, 200);
            } else {
                return $this->json(['error' => 'unexpected information for add request'], 404);
            }
        } else {
            return $this->json(['error' => 'unexpected information for edit request'], 304);
        }   
    }
}
