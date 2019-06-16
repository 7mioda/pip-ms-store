<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FlashSaleRepository")
 */
class FlashSale
{
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $BeginDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBeginDate(): ?\DateTimeInterface
    {
        return $this->BeginDate;
    }

    public function setBeginDate(?\DateTimeInterface $BeginDate): self
    {
        $this->BeginDate = $BeginDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeInterface $endDate): self
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(?float $price): self
    {
        $this->price = $price;

        return $this;
    }
    /**
     * Many flashSales have Many products.
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", inversedBy="flashSales")
     * @ORM\JoinTable(name="products")
     */
    private $products;

    public function getProducts(): Collection
    {
        return $this->products;
    }
    public function addProduct(Product $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addFlashSale($this);
        }
        return $this;
    }
    public function removeProduct(Product $product): self
    {
        if ($this->articles->contains($product)) {
            $this->articles->removeElement($product);
            $product->removeFlashSale($this);
        }
        return $this;
    }

}
