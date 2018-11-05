<?php

namespace App\Controller;

use App\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Security("is_granted('ROLE_USER')")
 * @Route("/following")
 */
class FollowingController extends AbstractController
{
    /**
     * @Route("/follow/{id}", name="following_follow")
     */
    public function follow(User $userToFollow)
    {
        /** @var User $user */
        $user = $this->getUser();
        if($user->getId() !== $userToFollow->getId()) {
            $user->getFollowing()->add($userToFollow);

            $this->getDoctrine()->getManager()->flush();
        }
        return $this->redirectToRoute('user_micro_posts', ['username' => $userToFollow->getUsername()]);
    }

    /**
     * @Route("/unfollow/{id}", name="following_unfollow")
     */
    public function unfollow(User $userToUnfollow)
    {
        /** @var User $user */
        $user = $this->getUser();
        if ($user->getId() !== $userToUnfollow->getId()) {
            $user->getFollowing()->removeElement($userToUnfollow);

            $this->getDoctrine()->getManager()->flush();
        }
        return $this->redirectToRoute('user_micro_posts', ['username' => $userToUnfollow->getUsername()]);
    }
}
