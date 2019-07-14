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
     * One Delivery has One Order.
     * @ORM\OneToOne(targetEntity="App\Entity\Order", inversedBy="delivery")
     * @ORM\JoinColumn(name="`order`", referencedColumnName="id")
     */
    private $order;

    /**
     * @ORM\Column(name="adress",type="text", nullable= true)
     */
    private $address;

    /**
     * @ORM\Column(name="coordinate_x",type="float")
     */
    private $coordinateX;

    /**
     * @ORM\Column(name="coordinate_y",type="float")
     */
    private $coordinateY;

    /**
     * @ORM\Column(name="created_at",type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="validated_at", type="datetime", nullable=true)
     */
    private $deliveredAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): Delivery
    {
        $this->status = $status;

        return $this;
    }

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

    /**
     * @return mixed
     */
    public function getDeliveredAt()
    {
        return $this->deliveredAt;
    }

    /**
     * @param mixed $deliveredAt
     * @return Delivery
     */
    public function setDeliveredAt($deliveredAt): Delivery
    {
        $this->deliveredAt = $deliveredAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     * @return Delivery
     */
    public function setCreatedAt($createdAt): Delivery
    {
        $this->createdAt = $createdAt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     * @return Delivery
     */
    public function setAddress($address): Delivery
    {
        $this->address = $address;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCoordinateX()
    {
        return $this->coordinateX;
    }

    /**
     * @param mixed $coordinateX
     * @return Delivery
     */
    public function setCoordinateX($coordinateX): Delivery
    {
        $this->coordinateX = $coordinateX;
        return $this;

    }

    /**
     * @return mixed
     */
    public function getCoordinateY()
    {
        return $this->coordinateY;
    }

    /**
     * @param mixed $coordinateY
     * @return Delivery
     */
    public function setCoordinateY($coordinateY): Delivery
    {
        $this->coordinateY = $coordinateY;
        return $this;
    }
}
