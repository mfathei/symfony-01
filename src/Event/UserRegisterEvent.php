<?php
/**
 * Created by PhpStorm.
 * User: mahdy
 * Date: 11/6/18
 * Time: 10:36 AM
 */

namespace App\Event;


use App\Entity\User;
use Symfony\Component\EventDispatcher\Event;

class UserRegisterEvent extends Event
{
    const NAME = 'user.register';

    /**
     * @var User $registeredUser
     */
    private $registeredUser;

    public function __construct(User $registeredUser)
    {
        $this->registeredUser = $registeredUser;
    }

    /**
     * @return User
     */
    public function getRegisteredUser(): User
    {
        return $this->registeredUser;
    }
}