<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 * @ORM\Table(name="`order`")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="created_at",type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="validated_at", type="datetime", nullable=true)
     */
    private $validatedAt;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $totalPrice;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $note;


    /**
     * @ORM\OneToMany(targetEntity="OrderLine", mappedBy="order", cascade={"remove"})
     */
    private $orderLines;

    /**
     * Many Orders have one user. This is the owning side.
     * @ORM\ManyToOne(targetEntity="App\Entity\User")
     * @ORM\JoinColumn(nullable=false)
     */
    private $user;

    /**
     * One Order has One Delivery.
     * @ORM\OneToOne(targetEntity="App\Entity\Delivery", mappedBy="order")
     */
    private $delivery;


    public function __construct() {
        $this->orderLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): Order
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function setValidatedAt($validatedAt)
    {
        $this->validatedAt = $validatedAt;

        return $this;
    }

    public function getValidatedAt()
    {
        return $this->validatedAt;
    }

    public function getTotalPrice(): ?float
    {
        return $this->totalPrice;
    }

    public function setTotalPrice(?float $totalPrice): Order
    {
        $this->$totalPrice = $totalPrice;

        return $this;
    }

    public function getNote(): ?string
    {
        return $this->note;
    }

    public function setNote(?string $note): self
    {
        $this->note = $note;

        return $this;
    }

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

    /**
     * @return mixed
     */
    public function getOrderLines()
    {
        return $this->orderLines;
    }

    /**
     * @param mixed $orderLines
     * @return Order
     */
    public function setOrderLines($orderLines): Order
    {
        $this->orderLines = $orderLines;

        return $this;
    }

    /**
     * @param OrderLine $orderLine
     * @return $this
     */
    public function addOrderLine(OrderLine $orderLine): Order
    {
        if (!$this->orderLines->contains($orderLine)) {
            $this->orderLines[] = $orderLine;
        }
        return $this;
    }

    public function removeOrderLine(OrderLine $orderLine)
    {
        if (!$this->orderLines->contains($orderLine)) {
            $this->orderLines->removeElement($orderLine);
        }
        return $this;
    }


    /**
     * @return mixed
     */
    public function getDelivery()
    {
        return $this->delivery;
    }

    /**
     * @param mixed $delivery
     */
    public function setDelivery($delivery): void
    {
        $this->delivery = $delivery;
    }
}
