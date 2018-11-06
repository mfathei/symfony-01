<?php
/**
 * Created by PhpStorm.
 * User: mahdy
 * Date: 11/6/18
 * Time: 10:45 AM
 */

namespace App\Event;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var \Twig_Environment
     */
    private $twig;

    public function __construct(\Swift_Mailer $mailer, \Twig_Environment $twig)
    {
        $this->mailer = $mailer;
        $this->twig = $twig;
    }

    public static function getSubscribedEvents()
    {
        return [
            UserRegisterEvent::NAME => 'onUserRegister'
        ];
    }

    public function onUserRegister(UserRegisterEvent $registerEvent)
    {
        $body = $this->twig->render('email/registration.html.twig', [
            'user' => $registerEvent->getRegisteredUser()
        ]);

        $msg = new \Swift_Message();
        $msg->setSubject('Welcome to micro-post app')
            ->setFrom('mahdy@domain.com')
            ->setTo($registerEvent->getRegisteredUser()->getEmail())
            ->setBody($body, 'text/html');

        $this->mailer->send($msg);
    }
}