<?php
namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     */
    public function index()
    {
        return $this->render('main/index.html.twig');
    }

    /**
    * @Route("/v1/checkMail", name="api_mail_check")
    */
    public function mailCheck(UserRepository $userRepository, Request $request)
    {
        if ($content = $request->getContent()) {

            $parametersAsArray = json_decode($content, true);

            $user = $userRepository->isFoundMail($parametersAsArray['email']);

            if($user != NULL){
                if($parametersAsArray['return'] === "TRUE"){
                    return $this->json($user , 200, [],['groups' => 'user_artisan_single']);
                }
                return $this->json(['success' => 'user found for this email'], 200, []);
            }
        }
        return $this->json(['error' => 'no user for this email'], 304, []);
    }
}