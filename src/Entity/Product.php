<?php

namespace App\Entity;

use DateTime;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation as Serializer;
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
     * @Assert\DateTime
     * @var string A "Y-m-d H:i:s" formatted value
     */
    private $discountEndDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime
     * @var string A "Y-m-d H:i:s" formatted value
     */
    private $discountBeginDate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     * @Assert\DateTime
     * @var string A "Y-m-d H:i:s" formatted value
     */
    private $createdAt;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $discount;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $quantity;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\OrderLine", mappedBy="product", orphanRemoval=true)
     */
    private $orderLines;


    /**
     * @var User
     *
     *@ORM\ManyToOne(targetEntity="App\Entity\User")
     *@ORM\JoinColumn(name="seller", referencedColumnName="id" ,nullable=true )

     */
    private $seller;

    /**
     * @var Category
     *
     *@ORM\ManyToOne(targetEntity="App\Entity\Category")
     *@ORM\JoinColumn(nullable=true )
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
        $this->createdAt = new DateTime();
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

    public function getDiscountEndDate()
    {
        return $this->discountEndDate;
    }

    public function setDiscountEndDate(?DateTimeInterface $discountEndDate): Product
    {
        $this->discountEndDate = $discountEndDate;

        return $this;
    }

    public function getDiscountBeginDate()
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

    public function getDiscount(): ?Float
    {
        return $this->discount;
    }

    public function setDiscount(?Float $discount): Product
    {
        $this->discount = $discount;

        return $this;
    }

    public function getQuantity(): ?Float
    {
        return $this->quantity;
    }

    public function setQuantity(?Float $quantity): Product
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * @return Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param Category $category
     * @return Product
     */
    public function setCategory(Category $category): Product
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return User
     */
    public function getSeller()
    {
        return $this->seller;
    }

    /**
     * @param User $seller
     * @return Product
     */
    public function setSeller(User $seller): Product
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
