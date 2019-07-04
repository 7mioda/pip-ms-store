<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategoryRepository")
 */
class Category
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
     * @ORM\ManyToMany(targetEntity="App\Entity\Product", mappedBy="categories", fetch="EXTRA_LAZY")
     */
    private $products;

    /**
     * Constructor
     */
    public function __construct() {
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

    public function setDescription(?string $description): Category
    {
        $this->description = $description;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): Category
    {
        $this->name = $name;

        return $this;
    }

    public function setProducts($products): Category
    {
        $this->products = $products;
        return $this;
    }

    public function getProducts(): ArrayCollection
    {
        return $this->products;
    }

    public function addProduct(Product $product): Category
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
        }
        return $this;
    }
    public function removeProduct(Product $product): Category
    {
        if ($this->products->contains($product)) {
            $this->products->removeElement($product);
        }
        return $this;
    }
}
