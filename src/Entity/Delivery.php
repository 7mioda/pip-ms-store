<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DeliveryRepository")
 */
class Delivery
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $parcour;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $timeValidUser;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getParcour(): ?string
    {
        return $this->parcour;
    }

    public function setParcour(?string $parcour): self
    {
        $this->parcour = $parcour;

        return $this;
    }

    public function getTimeValidUser(): ?\DateTimeInterface
    {
        return $this->timeValidUser;
    }

    public function setTimeValidUser(?\DateTimeInterface $timeValidUser): self
    {
        $this->timeValidUser = $timeValidUser;

        return $this;
    }
    /**
     * One Delivery has One Order.
     * @ORM\OneToOne(targetEntity="App\Entity\Order", inversedBy="delivery")
     * @ORM\JoinColumn(name="order", referencedColumnName="id")
     */
    private $order;

    /**
     * @return mixed
     */
    public function getOrder()
    {
        return $this->order;
    }

    /**
     * @param mixed $order
     */
    public function setOrder($order): void
    {
        $this->order = $order;
    }
}
