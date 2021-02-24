<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationFormType;
use App\Form\UserType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManager;
use Doctrine\Persistence\ObjectManager;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;

class RegistrationController extends AbstractController
{
    /**
     * @Route("/register", name="app_register")
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, GuardAuthenticatorHandler $guardHandler, UserAuthenticator $authenticator, MailerInterface $mailer): Response
    {
        //to build the form :
        $user = new User();
        $form = $this->createForm(RegistrationFormType::class, $user);

        //to handle the submit :
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password
            $user->setPassword(
                $passwordEncoder->encodePassword(
                    $user,
                    $form->get('plainPassword')->getData()
                )
            );
            //to make user active by default :
            $user->setIsActive(true);

            //to save the User :
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            // send an email to confirm the registration :
            $mail = $user->getEmail();

            $email = (new TemplatedEmail())
                ->from('contact@bengreen.org')
                ->to($mail)
                ->subject('Confirmation d\'inscription')
                ->htmlTemplate('emails/conf_inscription.html.twig')
                ->context([
                    'username' => $user->getFirstname(),
                ])
            ;
            $mailer->send($email);

            // maybe set a "flash" success message for the user
            $this->addFlash('success', 'Votre compte a bien été enregistré.');

            return $guardHandler->authenticateUserAndHandleSuccess(
                $user,
                $request,
                $authenticator,
                'main' // firewall name in security.yaml
            );
        }

        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
}
