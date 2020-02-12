<?php

namespace App\Controller;

use App\Repository\UserRepository;
use App\Manager\SecurityManager;
use DateInterval;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class MailController extends AbstractController
{
    // Set private data for send mail mail 
    //private $baseUrl = "http://ec2-52-90-234-146.compute-1.amazonaws.com/back/confirmation";
    private $baseUrl = "http://127.0.1.1:8010";
    private $securityManager;
    private $em;
    private $userRepository;
    private $mailer;

    public function __construct(SecurityManager $securityManager, EntityManagerInterface $em, UserRepository $userRepository, \Swift_Mailer $mailer)
    {
        $this->securityManager = $securityManager;
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->mailer = $mailer;
    }

    /**
     * @Route("api/v1/checkMail", name="api_mail_check")
     */
    public function mailCheck(Request $request)
    {
        if ($request->get('email')) {
            $error = $this->securityManager->securityEmail($request->get('email'));
            if (isset($error)) {
                return $this->json(['error' => $error], 409);
            }
            $user = $this->userRepository->isFoundMail($request->get('email'));

            if ($request->get('return') === "TRUE") {
                return $this->json($user, 200, [], ['groups' => 'user_user_single']);
            }

            if ($user != null) {
                return $this->json(['success' => 'user found for this email'], 200, []);
            }

            return $this->json(['error' => 'no user for this email'], 304, []);
        }
        return $this->json(['error' => 'no request'], 304, []);
    }

    // Generate random token for valid mail
    function setToken($taille = 0)
    {
        $alpha = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return substr(str_shuffle(str_repeat($alpha, $taille)), 0, $taille);
    }

    /**
     * @Route("/confirmMail", name="mail_confirm")
     */
    public function sendMailValidation(Request $request)
    {
        if ($request->get('email')) {
            $error = $this->securityManager->securityEmail($request->get('email'));
            if (isset($error)) {
                return $this->json(['error' => $error], 409);
            }
            $user = $this->userRepository->isFoundMail($request->get('email'));

            // Generate random token
            $token = $this->setToken(60);
            // if token already exist, generate a new one
            while ($this->userRepository->isFoundMailToken($token) != NULL) {
                $token = $this->setToken(60);
            }
            // Send what action do
            $use = "mailconfirm";

            $user->setMailToken($token);
            $user->setEmailCreatedAt(new \DateTime());
            $this->em->persist($user);
            $this->em->flush();

            $message = (new \Swift_Message('Zartisan: Confirmation d\'email'))
                ->setFrom('staff@zartisan.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/confirmMailSend.html.twig',
                        ['name' => $user->getEmail(), 'token' => $token, 'use' => $use, "baseUrl" => $this->baseUrl]
                    ),
                    'text/html'
                );

            if (!$this->mailer->send($message)) {
                return $this->json(['error' => 'mail not send'], 304, []);
            } else {
                return $this->json(['success' => 'mail send'], 200, []);
            }
        }
        return $this->json(['error' => 'no request'], 304, []);
    }

    /**
     * @Route("/resetPassMail", name="api_reset_pass")
     */
    public function sendResetPass(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        if ($request->get('email')) {

            $error = $this->securityManager->securityEmail($request->get('email'));
            if ($error) {
                return $this->json(['error' => $error], 409);
            }
            $user = $this->userRepository->isFoundMail($request->get('email'));

            if (!$request->get('password')) {
                return $this->json(['error' => 'password not valid'], 304, []);
            }

            $error = $this->securityManager->securityPassword($request->get('password'), 6, 255);
            if ($error) {
                return $this->json(['error' => $error], 409);
            }
            $password = $passwordEncoder->encodePassword($user, $request->get('password'));
            // Generate random token 
            $token = $this->setToken(60);
            // if token already exist, generate a new one
            while ($this->userRepository->isFoundPassToken($token) != NULL) {
                $token = $this->setToken(60);
            }
            // Send what action do
            $use = "passreset";

            $user->setPassToken($token);
            $user->setPassCreatedAt(new \DateTime());
            $this->em->persist($user);
            $this->em->flush();

            $message = (new \Swift_Message('Zartisan: Réinitialisation du mot de passe'))
                ->setFrom('staff@zartisan.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/passMailSend.html.twig',
                        ['name' => $user->getEmail(), 'token' => $token, 'password' => $password, 'use' => $use, "baseUrl" => $this->baseUrl]
                    ),
                    'text/html'
                );

            if (!$this->mailer->send($message)) {
                return $this->json(['error' => 'mail not send'], 304, []);
            } else {
                return $this->json(['success' => 'mail send'], 200, []);
            }
        }
        return $this->json(['error' => 'no request'], 304, []);
    }


    /**
     * @Route("/confirmation", name="api_confirm_route")
     */
    public function comfirmRoute(Request $request)
    {
        if ($request->query->get('use')) {
            // If url return get where use = mailconfirm
            if ($request->query->get('use') == "mailconfirm") {
                $user = $this->userRepository->isFoundMailToken($request->query->get('token'));
                if ($user != null) {
                    // Create verification from date when create request
                    $db_createMailToken = $user->getEmailCreatedAt();
                    $db_compareMailToken = $db_createMailToken->add(new DateInterval('P3D'));
                    $now_datetime = new DateTime();
                    // TODO Wait front integration to activate
                    if ($db_compareMailToken < $now_datetime) {
                        //$user->setMailToken(NULL);
                        //return $this->json(['error' => 'Mail was modify more than 3 days ago'], 404, []);
                    }
                    $user->setIsConfirmMail(true);
                    $user->setMailToken(null);
                    if (in_array('ROLE_UNDEFINED_USER', $user->getRoles())) {
                        $roles[] = 'ROLE_USER';
                    }
                    if (in_array('ROLE_UNDEFINED_ARTISAN', $user->getRoles())) {
                        $roles[] = 'ROLE_ARTISAN';
                    }
                    $user->setRoles($roles);
                    $this->em->persist($user);
                    $this->em->flush();
                    return $this->redirect($this->generateUrl('main'));
                }
                return $this->json(['error' => 'No user for this token'], 304, []);
            }
            // If url return get where use = passreset
            if ($request->query->get('use') == "passreset") {
                if ($request->query->get('password') != NULL) {
                    $user = $this->userRepository->isFoundPassToken($request->query->get('token'));
                    if ($user != NULL) {
                        // Create verification from date when create request
                        $db_createPassToken = $user->getPassCreatedAt();
                        $db_comparePassToken = $db_createPassToken->add(new DateInterval('P3D'));
                        $now_datetime = new DateTime();
                        // TODO Wait front integration to activate
                        if ($db_comparePassToken < $now_datetime) {
                            //$user->setPassToken(NULL);
                            //return $this->json(['error' => 'Password was modify more than 3 days ago'], 404, []);
                        }
                        // Patch sometime some + are replace by void caractere
                        $password = str_replace(" ", "+", $request->query->get('password'));
                        $user->setPassword($password);
                        $user->setPassToken(NULL);
                        $this->em->persist($user);
                        $this->em->flush();
                        return $this->redirect($this->generateUrl('app_logout'));
                    }
                    return $this->json(['error' => 'No user for this token'], 304, []);
                }
                return $this->json(['error' => 'Password try to be modify by wrong way'], 404, []);
            }
        }
        return $this->json(['error' => 'No querry on this request'], 304, []);
    }
}
