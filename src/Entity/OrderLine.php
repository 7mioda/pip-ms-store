<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderLineRepository")
 */
class OrderLine
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;


    /**
     * Many OrderLines have one order. This is the owning side.
     * @ORM\ManyToOne(targetEntity="App\Entity\Order", inversedBy="orderLines")
     * @ORM\JoinColumn(name="order", referencedColumnName="id")
     */
    private $order;

    /**
     *
     *
     *@ORM\ManyToOne(targetEntity="App\Entity\Product")
     *@ORM\JoinColumn(name="product", referencedColumnName="id")

     */
    private $product;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): OrderLine
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): OrderLine
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return OrderLine
     */
    public function setProduct(Product $product): OrderLine
    {
        $this->product = $product;

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
     * @return OrderLine
     */
    public function setOrder($order): OrderLine
    {
        $this->order = $order;

        return $this;
    }
}
