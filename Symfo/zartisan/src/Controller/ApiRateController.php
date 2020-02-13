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

        if ($request->get('id')) {
            // search email user and id artisan in the request
            $userPro = $userRepository->find($request->get('id'));  //récupère artisan  en BDD
            $userAuthor = $userRepository->isFoundMail($request->get('email')); //récupère user  en BDD         
            $value = $request->get('value'); // recupère note donnée

            // checked if artisan has a rate         
            $rate = $rateRepository->isFoundRateByUser($userPro, $userAuthor);

            // if rate exist, recovery id of rate
            if ($rate != null) {
                $rateId = $rate[0]->getId();
            }


            if ($userAuthor != null) {
                // if rate is null for artisan 
                if ($rate == null) {
                    $rate = new Rate();
                    $rate->setValue($value);
                    $rate->setUserAuthor($userAuthor);
                    $rate->setUserPro($userPro);
                    $em->persist($rate);
                } else {
                    $rate = $rateRepository->find($rateId);
                    $rate->setValue($value);
                    $rate->setUserAuthor($userAuthor);
                    $rate->setUserPro($userPro);
                }
                $em->flush();

                // recovery average rate for artisan
                $userAverageRate = $userPro->getAverageRate();

                // recovery all rates of the artisan 
                $userAverageRate = $rateRepository->findByUserPro($userPro);

                $sum = 0;
                foreach ($userAverageRate as $indexrate) {
                    // Need to get value on array of array
                    $sum += $indexrate["value"];
                }

                // get int of sum value round to 0 decimal
                $note = intval(round($sum / count($userAverageRate), 0));
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

    /**
     * @Route("/single", name="single")
     * list a user
     */
    public function single(Request $request, RateRepository $rateRepository)
    {
        if ($request->get('id')) {

            $rate = $rateRepository->find($request->get('id'));

            if ($rate != null) {
                return $this->json($rate, 200, [], ['groups' => 'rate_value']);
            } else {
                return $this->json(['error' => 'rate not found'], 404);
            }
        } else {
            return $this->json(['error' => 'unexpected information for edit request'], 304);
        }
    }
}
