<?php
/**
 * Created by PhpStorm.
 * User: mahdy
 * Date: 11/4/18
 * Time: 12:12 PM
 */

namespace App\Controller;

use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController
{
    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

    /**
     * @Route("/login", name="security_login")
     */
    public function login(AuthenticationUtils $authenticationUtils)
    {
        return new Response($this->twig->render('security/login.html.twig',
            [
                'last_username' => $authenticationUtils->getLastUsername(),
                'error' => $authenticationUtils->getLastAuthenticationError()
            ]
        ));
    }

    /**
     * @Route("/logout", name="security_logout")
     */
    public function logout()
    {

    }

    /**
     * @Route("/confirm/{token}", name="security_confirm")
     */
    public function confirm(string $token, UserRepository $userRepository, EntityManagerInterface $em)
    {
        $user = $userRepository->findOneBy([
            'confirmationToken' => $token
        ]);

        if (null !== $user) {
            $user->setConfirmationToken('');
            $user->setEnabled(true);

            $em->flush();
        }

        return new Response($this->twig->render('security/confirmation.html.twig', [
            'user' => $user
        ]));
    }
}