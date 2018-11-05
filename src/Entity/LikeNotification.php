<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LikeNotificationRepository")
 */
class LikeNotification extends Notification
{
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\MicroPost")
     */
    private $microPost;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     */
    private $likedBy;

    /**
     * @return MicroPost
     */
    public function getMicroPost()
    {
        return $this->microPost;
    }

    /**
     * @param MicroPost $microPost
     */
    public function setMicroPost($microPost): void
    {
        $this->microPost = $microPost;
    }

    /**
     * @return User
     */
    public function getLikedBy()
    {
        return $this->likedBy;
    }

    /**
     * @param User $likedBy
     */
    public function setLikedBy($likedBy): void
    {
        $this->likedBy = $likedBy;
    }
}
