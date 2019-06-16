<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    public function __construct()
    {
        $this->flashSales = new ArrayCollection();
    }
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
     * @ORM\Column(type="blob", nullable=true)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $statut;

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
     * @ORM\Column(type="integer", nullable=true)
     */
    private $discount;

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

    public function setImage($image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): self
    {
        $this->statut = $statut;

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

    public function getDiscountEndDate(): ?\DateTimeInterface
    {
        return $this->discountEndDate;
    }

    public function setDiscountEndDate(?\DateTimeInterface $discountEndDate): self
    {
        $this->discountEndDate = $discountEndDate;

        return $this;
    }

    public function getDiscountBeginDate(): ?\DateTimeInterface
    {
        return $this->discountBeginDate;
    }

    public function setDiscountBeginDate(?\DateTimeInterface $discountBeginDate): self
    {
        $this->discountBeginDate = $discountBeginDate;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
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
     * @var int
     *
     *@ORM\ManyToOne(targetEntity="App\Entity\Category")
     *@ORM\JoinColumn(name="category", referencedColumnName="id" ,onDelete="CASCADE",nullable=true )

     */
    private $category;

    /**
     * @return int
     */
    public function getCategory(): int
    {
        return $this->category;
    }

    /**
     * @param int $category
     */
    public function setCategory(int $category): void
    {
        $this->category = $category;
    }

    /**
     * @var int
     *
     *@ORM\ManyToOne(targetEntity="App\Entity\User")
     *@ORM\JoinColumn(name="seller", referencedColumnName="id" ,onDelete="CASCADE",nullable=true )

     */
    private $seller;

    /**
     * @return int
     */
    public function getSeller(): int
    {
        return $this->seller;
    }

    /**
     * @param int $seller
     */
    public function setSeller(int $seller): void
    {
        $this->seller = $seller;
    }

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderLine", mappedBy="product", orphanRemoval=true)
     */
    private $orderLines;

    /**
     * @return mixed
     */
    public function getOrderLines()
    {
        return $this->orderLines;
    }

    /**
     * @param mixed $orderLines
     */
    public function setOrderLines($orderLines): void
    {
        $this->orderLines = $orderLines;
    }
    /**
     * Many Products have Many FlashSales.
     * @ORM\ManyToMany(targetEntity="App\Entity\FlashSale", inversedBy="products")
     * @ORM\JoinTable(name="flashSales")
     */
    private $flashSales;


    public function getFlashSales(): Collection
    {
        return $this->flashSales;
    }
    public function addFlashSale(FlashSale $flashSale): self
    {
        if (!$this->flashSales->contains($flashSale)) {
            $this->flashSales[] = $flashSale;
            $flashSale->addProduct($this);
        }
        return $this;
    }
    public function removeFlashSale(FlashSale $flashSale): self
    {
        if ($this->flashSales->contains($flashSale)) {
            $this->flashSales->removeElement($flashSale);
            $flashSale->removeProduct($this);
        }
        return $this;
    }
}
