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

        $swiftMailerMock->expects($this->once())->method('send')
            ->with($this->callback(function ($subject) {
                $msg = (string)$subject;
//                dump($msg);

                return strpos($msg, 'Subject: Welcome to micro-post app') !== false
                    && strpos($msg, 'To: john-doe@example.com') !== false
                    && strpos($msg, 'From: me@domain.com') !== false
                    && strpos($msg, 'This is a message body.') !== false;
            }));

        $twigEnvironmentMock = $this->getMockBuilder(\Twig_Environment::class)
            ->disableOriginalConstructor()
            ->getMock();

        $twigEnvironmentMock->expects($this->once())->method('render')
            ->with('email/registration.html.twig', [
                'user' => $user
            ])->willReturn('This is a message body.');

        $mailer = new Mailer($swiftMailerMock, $twigEnvironmentMock, 'me@domain.com');
        $mailer->sendConfirmationEmail($user);
    }
}