<?php
namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MailController extends AbstractController
{
    // Set private data for send mail mail 
    private $baseUrl = "http://localhost:8001/confirmation";

    /**
    * @Route("api/v1/checkMail", name="api_mail_check")
    */
    public function mailCheck(UserRepository $userRepository, Request $request)
    {
        if ($request->getContent()) {
            $user = $userRepository->isFoundMail($request->request->get('email'));

            if ($user != null) {
                return $this->json(['success' => 'user found for this email'], 200, []);
            }

            return $this->json(['error' => 'no user for this email'], 304, []);
        }
        return $this->json(['error' => 'no request'], 304, []);
    }

    // Generate random token for valid mail
    function setToken($taille = 0){
        $alpha = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return substr(str_shuffle(str_repeat($alpha,$taille)),0,$taille);
    }

    /**
    * @Route("/confirmMail", name="mail_confirm")
    */
    public function sendMailValidation(UserRepository $userRepository, Request $request, EntityManagerInterface $em
    , \Swift_Mailer $mailer)
    { 
        if ($request->getContent()) {
            $user = $userRepository->isFoundMail($request->request->get('email'));
            
            // Generate random token 
            $token = $this->setToken(60);
            // Send what action do
            $use = "mailconfirm";
            
            $user->setMailToken($token);
            $em->persist($user);
            $em->flush();
            
            $message = (new \Swift_Message('Zartisan: Confirmation d\'email'))
                ->setFrom('staff@zartisan.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/confirmMailSend.html.twig',
                        ['name' => $user->getEmail(), 'token' => $token, 'use' => $use , "baseUrl" => $this->baseUrl ]
                    ),
                    'text/html'
                );

            if(!$mailer->send($message)){
                return $this->json(['error' => 'mail not send'], 304, []);
            }else{
                return $this->json(['success' => 'mail send'], 200, []);
            }
        }
        return $this->json(['error' => 'no request'], 304, []);
    }

    /**
    * @Route("/resetPassMail", name="api_reset_pass")
    */
    public function sendResetPass(UserRepository $userRepository, Request $request, EntityManagerInterface $em
    , \Swift_Mailer $mailer, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($request->getContent()) {
            $user = $userRepository->isFoundMail($request->request->get('email'));
            
            if($request->request->get('password')){
                return $this->json(['error' => 'password not valid'], 304, []);
            }

            $password = $passwordEncoder->encodePassword($user, $request->request->get('password'));
            // Generate random token 
            $token = $this->setToken(60);
            // Send what action do
            $use = "passreset";
            
            $user->setMailToken($token);
            $em->persist($user);
            $em->flush();
            
            $message = (new \Swift_Message('Zartisan: Réinitialisation du mot de passe'))
                ->setFrom('staff@zartisan.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/passMailSend.html.twig',
                        ['name' => $user->getEmail(), 'token' => $token, 'password' => $password, 'use' => $use, "baseUrl" => $this->baseUrl ]
                    ),
                    'text/html'
                );

            if(!$mailer->send($message)){
                return $this->json(['error' => 'mail not send'], 304, []);
            }else{
                return $this->json(['success' => 'mail send'], 200, []);
            }
        }
        return $this->json(['error' => 'no request'], 304, []);
    }

        
    /**
    * @Route("/confirmation", name="api_confirm_route")
    */
    public function comfirmRoute(UserRepository $userRepository
    , Request $request, EntityManagerInterface $em)
    {
        if ($request->getContent()) {
            $user = $userRepository->isFoundToken($request->query->get('token'));
            if($user != NULL){
                // If url return get where use = mailconfirm
                if ($request->query->get('use') == "mailconfirm") {
                    $user->setIsConfirmMail(TRUE);
                    $user->setMailToken(NULL);
                    $em->persist($user);
                    $em->flush();
                    return $this->redirect($this->generateUrl('main'));
                }
                // If url return get where use = passreset
                if ($request->query->get('use') == "passreset") {
                    if($request->query->get('password') != NULL){
                        // Patch sometime some + are replace by void caractere
                        $password = str_replace(" ", "+" ,$request->query->get('password'));
                        $user->setPassword($password);
                        $user->setMailToken(NULL);
                        $em->persist($user);
                        $em->flush();
                        return $this->redirect($this->generateUrl('app_logout'));
                    }
                    return $this->json(['error' => 'Password try to be modify by wrong way'], 404, []);
                }
            }
            return $this->json(['error' => 'No user for this token'], 304, []);
        }
        return $this->json(['error' => 'No querry on this request'], 304, []);
    }
}