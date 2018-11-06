<?php
/**
 * Created by PhpStorm.
 * User: mahdy
 * Date: 11/6/18
 * Time: 10:45 AM
 */

namespace App\Event;


use App\Entity\UserPreferences;
use App\Mailer\Mailer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class UserSubscriber implements EventSubscriberInterface
{
    /**
     * @var Mailer
     */
    private $mailer;
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;
    /**
     * @var string
     */
    private $defaultLocale;

    public function __construct(Mailer $mailer, EntityManagerInterface $entityManager, string $defaultLocale)
    {
        $this->mailer = $mailer;
        $this->entityManager = $entityManager;
        $this->defaultLocale = $defaultLocale;
    }

    public static function getSubscribedEvents()
    {
        return [
            UserRegisterEvent::NAME => 'onUserRegister'
        ];
    }

    public function onUserRegister(UserRegisterEvent $registerEvent)
    {
        $preferences = new UserPreferences();
        $preferences->setLocale($this->defaultLocale);
        $this->entityManager->persist($preferences);

        $registerEvent->getRegisteredUser()->setPreferences($preferences);

        $this->entityManager->flush();

        $this->mailer->sendConfirmationEmail($registerEvent->getRegisteredUser());
    }
}