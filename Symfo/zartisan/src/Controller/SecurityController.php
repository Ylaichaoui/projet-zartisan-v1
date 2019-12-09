<?php

namespace App\Controller;

use App\Controller\ExterneApiController;
use App\Entity\User;
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

    public function __construct(ExterneApiController $externeApiController)
    {
        $this->externeApiController = $externeApiController;
    }

    /**
     * @Route("/register/artisan", name="app_register_artisan")
     */
    public function registerArtisan(Request $request, UserPasswordEncoderInterface $passwordEncoder, 
    UserRepository $userRepository): Response
    {
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);

            // Look if exist email
            if($userRepository->isFoundMail($parametersAsArray['email'])){
                return $this->json(['error' => 'Email already exist'], 409, []);
            }
            // Look if exist siret
            if($userRepository->isFound($parametersAsArray['siret'])){
                return $this->json(['error' => 'Siret already exist'], 409, []);
            }
            $user = new User();

            $user->setEmail($parametersAsArray['email']);
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $parametersAsArray['password']
                )
            );
            $user->setSiret($parametersAsArray['siret']);
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
        return $this->json(['error' => 'unexpected information for artisan register request'], 304, []);
    }

    /**
     * @Route("/register/user", name="app_register_user")
     */
    public function registerUser(Request $request, UserPasswordEncoderInterface $passwordEncoder, SerializerInterface $serializer, 
    UserRepository $userRepository): Response
    {
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);

            // Look if exist siret
            if($userRepository->isFoundMail($parametersAsArray['email'])){
                return $this->json(['error' => 'Email already exist'], 409, []);
            }
            $user = new User();

            $user->setEmail($parametersAsArray['email']);
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $parametersAsArray['password']
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
        return $this->json(['error' => 'unexpected information for user register request'], 304, []);
    }

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
