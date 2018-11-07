<?php
/**
 * Created by PhpStorm.
 * User: mahdy
 * Date: 11/6/18
 * Time: 12:12 PM
 */

namespace App\Mailer;


use App\Entity\User;

class Mailer
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var \Twig_Environment
     */
    private $twig;
    /**
     * @var string
     */
    private $emailFrom;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig, string $emailFrom)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
        $this->emailFrom = $emailFrom;
    }

    public function sendConfirmationEmail(User $user)
    {
        $body = $this->twig->render('email/registration.html.twig', [
            'user' => $user
        ]);

        $msg = new \Swift_Message();
        $msg->setSubject('Welcome to micro-post app')
            ->setFrom($this->emailFrom)
            ->setTo($user->getEmail())
            ->setBody($body, 'text/html');

        /**
         * Send
         */
        $this->mailer->send($msg);
    }
}