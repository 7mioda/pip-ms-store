<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProfileRepository")
 */
class Profile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="blob", nullable=true)
     */
    private $photo;

    /**
     * @ORM\Column(type="time", nullable=true)
     */
    private $sessionExpiration;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $banner;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPhoto()
    {
        return $this->photo;
    }

    public function setPhoto($photo): self
    {
        $this->photo = $photo;

        return $this;
    }

    public function getSessionExpiration(): ?\DateTimeInterface
    {
        return $this->sessionExpiration;
    }

    public function setSessionExpiration(?\DateTimeInterface $sessionExpiration): self
    {
        $this->sessionExpiration = $sessionExpiration;

        return $this;
    }

    public function getBanner(): ?bool
    {
        return $this->banner;
    }

    public function setBanner(?bool $banner): self
    {
        $this->banner = $banner;

        return $this;
    }

    /**
     * One profile has One user.
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="profile")
     * @ORM\JoinColumn(name="user", referencedColumnName="id")
     */
    private $user;

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user): void
    {
        $this->user = $user;
    }
}
