<?php
/**
 * Created by PhpStorm.
 * User: mahdy
 * Date: 11/7/18
 * Time: 8:26 AM
 */

namespace App\Tests\Mailer;


use App\Entity\User;
use App\Mailer\Mailer;
use PHPUnit\Framework\TestCase;

class MailerTest extends TestCase
{
    public function testSendConfirmationEmail()
    {
        $user = new User();
        $user->setEmail('john-doe@example.com');

        $swiftMailerMock = $this->getMockBuilder(\Swift_Mailer::class)
            ->disableOriginalConstructor()
            ->getMock();

        $twigEnvironmentMock = $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();

        $mailer = new Mailer($swiftMailerMock, $twigEnvironmentMock, 'me@domain.com');
        $mailer->sendConfirmationEmail($user);
    }
}