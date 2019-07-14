<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints\Date;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FlashSaleRepository")
 */
class FlashSale
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $beginDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $endDate;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * Many flashSales have Many products.
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", inversedBy="flashSales")
     * @ORM\JoinTable(name="products")
     */
    private $products;

    /**
     * @ORM\Column(name="created_at",type="datetime")
     */
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTime();
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): FlashSale
    {
        $this->description = $description;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): FlashSale
    {
        $this->name = $name;

        return $this;
    }

    public function getBeginDate(): ?DateTimeInterface
    {
        return $this->beginDate;
    }

    public function setBeginDate(?DateTimeInterface $beginDate): FlashSale
    {
        $this->beginDate = $beginDate;

        return $this;
    }

    public function getEndDate(): ?DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(?DateTimeInterface $endDate): FlashSale
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): FlashSale
    {
        $this->image = $image;

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

    public function getProducts(): ArrayCollection
    {
        return $this->products;
    }

    public function addProduct(Product $product): FlashSale
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->addFlashSale($this);
        }
        return $this;
    }
    public function removeProduct(Product $product): FlashSale
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
            $product->removeFlashSale($this);
        }
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
     * @return FlashSale
     */
    public function setCreatedAt($createdAt): FlashSale
    {
        $this->createdAt = $createdAt;
        return $this;

    }

}
