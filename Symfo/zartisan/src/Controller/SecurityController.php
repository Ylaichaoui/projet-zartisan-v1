<?php

namespace App\Controller;

use App\Controller\ExterneApiController;
use App\Entity\User;
use App\Manager\SecurityManager;
use App\Repository\UserRepository;
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

    public function __construct(ExterneApiController $externeApiController, SecurityManager $securityManager)
    {
        $this->externeApiController = $externeApiController;
        $this->securityManager = $securityManager;
    }

    /**
     * @Route("/register/artisan", name="app_register_artisan")
     */
    public function registerArtisan(Request $request, UserPasswordEncoderInterface $passwordEncoder, 
    UserRepository $userRepository): Response
    {
        if ($request->getContent()) {

            // Look if exist email
            $error = $this->securityManager->securityEmail($request->get('email'));
            if(isset($error)){
                return $this->json(['error' => $error], 409);
            }
            if($userRepository->isFoundMail($request->get('email'))){
                return $this->json(['error' => 'Email already exist'], 409);
            }

            $error = $this->securityManager->securitySiret($request->get('siret'));
            if(isset($error)){
                return $this->json(['error' => $error], 409);
            }
            // Look if exist siret
            if($userRepository->isFound($request->get('siret'))){
                return $this->json(['error' => 'Siret already exist'], 409);
            }
            $user = new User();

            $user->setEmail($request->get('email'));
            $error = $this->securityManager->securityPassword($request->get('password'),6,255);
            if(isset($error)){
                return $this->json(['error' => $error], 409);
            }
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $request->get('password')
                )
            );
            $user->setSiret($request->get('siret'));
            $user->setRoles(["ROLE_ARTISAN"]);
            $user->setIsConfirmMail(false);
            $user->setIsStatus(true);
            $user->setIsVerified(false);
            $user->setIsReported(false);
        
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // Get  & save information to register in DB from externals api
            $this->externeApiController->ApiIndexSirene($user->getSiret());

            return $this->json($user , 200, [], ['groups' => 'user_artisan_single']);
        }
        return $this->json(['error' => 'unexpected information for artisan register request'], 304);
    }

    /**
     * @Route("/register/user", name="app_register_user")
     */
    public function registerUser(Request $request, UserPasswordEncoderInterface $passwordEncoder, SerializerInterface $serializer, 
    UserRepository $userRepository): Response
    {
        if ($request->getContent()) {

            $error = $this->securityManager->securityEmail($request->get('email'));
            if(isset($error)){
                return $this->json(['error' => $error], 409);
            }
            // Look if exist email
            if($userRepository->isFoundMail($request->get('email'))){
                return $this->json(['error' => 'Email already exist'], 409);
            }
            $user = new User();

            $user->setEmail($request->get('email'));
            $error = $this->securityManager->securityPassword($request->get('password'),6,255);
            if(isset($error)){
                return $this->json(['error' => $error], 409);
            }
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $request->get('password')
                )
            );
            $user->setIsConfirmMail(false);
            $user->setRoles(["ROLE_USER"]);
            $user->setIsStatus(true);
            $user->setIsVerified(false);
            $user->setIsReported(false);

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // Serialize data to dont have circle
            return $this->json($user , 200, [], ['groups' => 'user_user_single']);
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
