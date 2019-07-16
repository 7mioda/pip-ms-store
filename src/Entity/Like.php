<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LikeRepository")
 */
class Like
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * One User have many Likes
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(name="user", referencedColumnName="id", nullable=true)
     */
    private $user;

    /**
     * One post have many Likes
     * @ORM\ManyToOne(targetEntity="App\Entity\Post")
     * @ORM\JoinColumn(name="post", referencedColumnName="id", nullable=true)
     */
    private $post;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?int
    {
        return $this->user;
    }

    public function setUser(?string $user): Like
    {
        $this->user = $user;

        return $this;
    }

    public function getPost(): ?int
    {
        return $this->post;
    }

    public function setPost(?int $post): Like
    {
        $this->post = $post;

        return $this;
    }
}
