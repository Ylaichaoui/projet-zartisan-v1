<?php

namespace App\Controller;

use App\Controller\ExterneApiController;
use App\Controller\MailController;
use App\Entity\User;
use App\Manager\SecurityManager;
use App\Repository\UserRepository;
use App\Services\FoldersUser;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Serializer\SerializerInterface;

class SecurityController extends AbstractController
{
    private $externeApiController;
    private $securityManager;
    private $mailController;

    public function __construct(ExterneApiController $externeApiController, SecurityManager $securityManager, MailController $mailController)
    {
        $this->externeApiController = $externeApiController;
        $this->securityManager = $securityManager;
        $this->mailController = $mailController;
    }

    /**
     * @Route("/register/artisan", name="app_register_artisan")
     */
    public function registerArtisan(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        UserRepository $userRepository,
        FoldersUser $foldersUser
    ): Response {
        if ($request->get('email')) {

            // Look if exist email
            $error = $this->securityManager->securityEmail($request->get('email'));

            if (isset($error)) {
                return $this->json(['error' => $error], 409);
            }
            if ($userRepository->isFoundMail($request->get('email'))) {
                return $this->json(['error' => 'Email already exist'], 409);
            }

            $error = $this->securityManager->securitySiret($request->get('siret'));
            if (isset($error)) {
                return $this->json(['error' => $error], 409);
            }
            // Look if exist siret
            if ($userRepository->isFound($request->get('siret'))) {
                return $this->json(['error' => 'Siret already exist'], 409);
            }
            $user = new User();

            $user->setEmail($request->get('email'));
            $error = $this->securityManager->securityPassword($request->get('password'), 6, 255);
            if (isset($error)) {
                return $this->json(['error' => $error], 409);
            }
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $request->get('password')
                )
            );
            $user->setSiret($request->get('siret'));

            // TODO Add undefined role artisan if mail not validate
            $user->setRoles(["ROLE_ARTISAN"]);
            //$user->setRoles(["ROLE_UNDEFINED_ARTISAN"]);
            $user->setIsConfirmMail(false);
            $user->setPicture("assets/images_default/craftsmen-1020156_640.jpg");
            $user->setIsStatus(true);
            $user->setIsVerified(false);
            $user->setIsReported(false);


            $userRole = 'ARTISAN';
            $email = $user->setEmail($request->get('email'));
            $foldersUser->isFolder($email, $userRole);


            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // Get  & save information to register in DB from externals api
            $this->externeApiController->ApiIndexSirene($user->getSiret());

            $request = Request::create(
                '/Manual-request',
                'POST',
                ['email' => $user->getEmail()]
            );

            // normaly is possible to send mail automatictly to artisan but desactivated for demo
            // cause of not send mail to real personne            $userRole = 'USER';
            //$foldersUser->isFolder($userEmail, $userRole);  // verification if folder exist
            // TODO
            // $this->mailController->sendMailValidation($request);

            return $this->json($user, 200, [], ['groups' => 'user_artisan_single']);
        }
        return $this->json(['error' => 'unexpected information for artisan register request'], 304);
    }

    /**
     * @Route("/register/user", name="app_register_user")
     */
    public function registerUser(
        Request $request,
        UserPasswordEncoderInterface $passwordEncoder,
        SerializerInterface $serializer,
        UserRepository $userRepository,
        FoldersUser $foldersUser
    ): Response {
        if ($request->get('email')) {

            $error = $this->securityManager->securityEmail($request->get('email'));
            if (isset($error)) {
                return $this->json(['error' => $error], 409);
            }
            // Look if exist email
            if ($userRepository->isFoundMail($request->get('email'))) {
                return $this->json(['error' => 'Email already exist'], 409);
            }
            $user = new User();

            $user->setEmail($request->get('email'));
            $error = $this->securityManager->securityPassword($request->get('password'), 6, 255);
            if (isset($error)) {
                return $this->json(['error' => $error], 409);
            }
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $request->get('password')
                )
            );
            $user->setIsConfirmMail(false);
            $user->setPicture("assets/images_default/user-1633249_640.png");
            $user->setRoles(["ROLE_UNDEFINED_USER"]);
            $user->setIsStatus(true);
            $user->setFirstname("unknown");
            $user->setIsVerified(false);
            $user->setIsReported(false);

            $foldersUser->isFolder($user->setEmail($request->get('email')));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            $request = Request::create(
                '/Manual-request',
                'POST',
                ['email' => $user->getEmail()]
            );

            // It send mail auto to new user to confirm his email
            $this->mailController->sendMailValidation($request);

            // Serialize data to dont have circle
            return $this->json($user, 200, [], ['groups' => 'user_user_single']);
        }
        return $this->json(['error' => 'unexpected information for user register request'], 304);
    }

    // TODO : DELETE WHEN FRONT READY
    /**
     * @Route("/login", name="app_login")
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        //if ($this->getUser()) {
        //return $this->redirectToRoute('main');
        //}

        $error = $authenticationUtils->getLastAuthenticationError();

        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/logout", name="app_logout")
     */
    public function logout()
    {
        throw new \Exception('This method can be blank - it will be intercepted by the logout key on your firewall');
    }
}
