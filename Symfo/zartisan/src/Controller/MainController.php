<?php
namespace App\Controller;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use PHPMailer\PHPMailer\PHPMailer;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

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

    // Generate random token for valid mail
    function mail_validate($taille = 0){
        $alpha = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
        return substr(str_shuffle(str_repeat($alpha,$taille)),0,$taille);
    }

    /**
    * @Route("/v1/confirmMail", name="api_mail_confirm")
    */
    public function sendMailValidation(UserRepository $userRepository, Request $request, EntityManagerInterface $em)
    { 
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
            $user = $userRepository->isFoundMail($parametersAsArray['email']);
            
            // Generate random token 
            $token = $this->mail_validate(60);
            
            $user->setMailToken($token);
            $em->persist($user);
            $em->flush();
            

            $mail = new PHPMailer(true);
            $mail->IsMail(); 
            // Parameter le Mailer for use smtp SMTP 
            $mail->SMTPDebug = 2;
            $mail->CharSet = 'UTF-8';
            $mail->Host = 'smtp.ionos.fr'; // Set SMTP Server
            $mail->SMTPAuth = true; // Activate SMTP Auth
            $mail->SMTPSecure = 'ssl'; // Allow SSL
            $mail->Port = 465;
            $mail->setFrom('Staff@Zartisan.com', 'Staff@Zartisan.com'); // Edit send user info
            $mail->addAddress($user->getEmail(), $user->getEmail()); // Add receive
            $mail->addReplyTo('Staff@Zartisan.com', 'No reply'); // Author email
            $mail->isHTML(true); // Set format HTML
            $mail->Subject = 'Confirmation d\'email';
            $use = "mailreset";
            $mail->Body = "<p>Afin de valider votre compte, merci de bien vouloir cliquer sur ce lien : \n\n</p> <a href='https://www.checkmylife.net/confirm.php?token=$token&use=$use'>Cliquer ici réinitialiser le mot de passe</a>";
            $mail->AltBody = "Afin de valider votre compte, merci de bien vouloir cliquer sur ce lien \n\n https://www.checkmylife.net/confirm.php?token=".$token."&use=".$use;
            if(!$mail->Send()){
                return $this->json(['error' => 'mail not send'], 304, []);
            }else{
                return $this->json(['success' => 'mail send'], 200, []);
            }
        } 
    }

    /**
    * @Route("/v1/resetPass", name="api_reset_pass")
    */
    public function sendResetPass(UserRepository $userRepository, Request $request, EntityManagerInterface $em)
    {
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);
            $user = $userRepository->isFoundMail($parametersAsArray['email']);

            // Generate random token
            $token = $this->mail_validate(60);
            $user->setMailToken($token);
            $em->persist($user);
            $em->flush();

            $mail = new PHPMailer(true);
            $mail->IsMail();
            // Parameter le Mailer for use smtp SMTP
            $mail->SMTPDebug = 2;
            $mail->CharSet = 'UTF-8';
            $mail->Host = 'smtp.ionos.fr'; // Set SMTP Server
            $mail->SMTPAuth = true; // Activate SMTP Auth
            $mail->SMTPSecure = 'ssl'; // Allow SSL
            $mail->Port = 465;
            $mail->setFrom('Staff@Zartisan.com', 'Staff@Zartisan.com'); // Edit send user info
            $mail->addAddress($user->getEmail(), $user->getEmail()); // Add receive
            $mail->addReplyTo('Staff@Zartisan.com', 'No reply'); // Author email
            $mail->isHTML(true); // Set format HTML
            $mail->Subject = 'Réinitialisation de votre mot de passe';
            $use = "passreset";
            $mail->Body = "<p>Suite a votre demande de réinitialisation de mot de passe : \n\n</p> <a href='https://www.checkmylife.net/confirm.php?token=$token&use=$use'>Cliquer ici réinitialiser le mot de passe</a>";
            $mail->AltBody = "Suite a votre demande de réinitialisation de mot de passe : \n\n https://www.checkmylife.net/confirm.php?token=".$token."&use=".$use;
            if (!$mail->Send()) {
                return $this->json(['error' => 'mail not send'], 304, []);
            } else {
                return $this->json(['success' => 'mail send'], 200, []);
            }
        }
    }

        
    /**
    * @Route("/Confirmation", name="api_confirm_route")
    */
    public function comfirmRoute(UserRepository $userRepository, UserPasswordEncoderInterface $passwordEncoder, Request $request, EntityManagerInterface $em)
    {
        if ($content = $request->getContent()) {
            $parametersAsArray = json_decode($content, true);

            $user = $userRepository->isFoundToken($parametersAsArray['token']);
            if($user != NULL){
                if ($parametersAsArray['use'] == "mailconfirm") {
                    $user->setIsConfirmMail(TRUE);
                    $user->setMailToken(NULL);
                    $em->persist($user);
                    $em->flush();
                    return $this->redirect($this->generateUrl('main'));
                }
                if ($parametersAsArray['use'] == "passreset") {
                    $user->setPassword(
                        $passwordEncoder->encodePassword(
                            $user,
                            $parametersAsArray['password']
                        )
                    );
                    $user->setMailToken(NULL);
                    $em->persist($user);
                    $em->flush();
                    return $this->redirect($this->generateUrl('logout'));
                }
            }
            return $this->json(['error' => 'no'], 304, []);
        }
        return $this->json(['error' => 'no'], 304, []);
    }
}