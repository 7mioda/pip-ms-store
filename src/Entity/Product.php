<?php

namespace App\Entity;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $status;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $discountEndDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $discountBeginDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $discount;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderLine", mappedBy="product", orphanRemoval=true)
     */
    private $orderLines;


    /**
     * @var int
     *
     *@ORM\ManyToOne(targetEntity="App\Entity\User")
     *@ORM\JoinColumn(name="seller", referencedColumnName="id" ,nullable=true )

     */
    private $seller;

    /**
     * @var int
     *
     *@ORM\ManyToOne(targetEntity="App\Entity\Category")
     *@ORM\JoinColumn(name="category", referencedColumnName="id" ,nullable=true )
     */
    private $category;

    /**
     * Many Products have Many FlashSales.
     * @ORM\ManyToMany(targetEntity="App\Entity\FlashSale", inversedBy="products")
     * @ORM\JoinTable(name="flashSales")
     */
    private $flashSales;

    public function __construct()
    {
        $this->flashSales = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage($image): Product
    {
        $this->image = $image;

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): Product
    {
        $this->status = $status;

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

    public function getDiscountEndDate(): ?DateTimeInterface
    {
        return $this->discountEndDate;
    }

    public function setDiscountEndDate(?DateTimeInterface $discountEndDate): Product
    {
        $this->discountEndDate = $discountEndDate;

        return $this;
    }

    public function getDiscountBeginDate(): ?DateTimeInterface
    {
        return $this->discountBeginDate;
    }

    public function setDiscountBeginDate(?DateTimeInterface $discountBeginDate): Product
    {
        $this->discountBeginDate = $discountBeginDate;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeInterface $createdAt): Product
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDiscount(): ?int
    {
        return $this->discount;
    }

    public function setDiscount(?int $discount): self
    {
        $this->discount = $discount;

        return $this;
    }

    /**
     * @return int
     */
    public function getCategory(): int
    {
        return $this->category;
    }

    /**
     * @param int $category
     * @return Product
     */
    public function setCategory(int $category): Product
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return int
     */
    public function getSeller(): int
    {
        return $this->seller;
    }

    /**
     * @param int $seller
     * @return Product
     */
    public function setSeller(int $seller): Product
    {
        $this->seller = $seller;

        return $this;
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
     * @return Product
     */
    public function setOrderLines($orderLines): Product
    {
        $this->orderLines = $orderLines;

        return $this;
    }

    public function getFlashSales(): ArrayCollection
    {
        return $this->flashSales;
    }
    public function addFlashSale(FlashSale $flashSale): Product
    {
        if (!$this->flashSales->contains($flashSale)) {
            $this->flashSales[] = $flashSale;
            $flashSale->addProduct($this);
        }
        return $this;
    }
    public function removeFlashSale(FlashSale $flashSale): Product
    {
        if ($this->flashSales->contains($flashSale)) {
            $this->flashSales->removeElement($flashSale);
            $flashSale->removeProduct($this);
        }
        return $this;
    }
}
