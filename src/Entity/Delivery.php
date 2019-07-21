<?php

namespace App\Entity;

use DateTime;
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
     * @ORM\Column(type="string", length=255, options= {"default": "PACKAGING"})
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
     * @ORM\Column(name="coordinate_lat",type="float")
     */
    private $coordinateLat;

    /**
     * @ORM\Column(name="coordinate_lng",type="float")
     */
    private $coordinateLng;

    /**
     * @ORM\Column(name="created_at",type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(name="validated_at", type="datetime", nullable=true)
     */
    private $deliveredAt;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

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
    public function getCoordinateLat()
    {
        return $this->coordinateLat;
    }

    /**
     * @param mixed $coordinateLat
     * @return Delivery
     */
    public function setCoordinateLat($coordinateLat): Delivery
    {
        $this->coordinateLat = $coordinateLat;
        return $this;

    }

    /**
     * @return mixed
     */
    public function getCoordinateLng()
    {
        return $this->coordinateLng;
    }

    /**
     * @param $coordinateLng
     * @return Delivery
     */
    public function setCoordinateLng($coordinateLng): Delivery
    {
        $this->coordinateLng = $coordinateLng;
        return $this;
    }
}
