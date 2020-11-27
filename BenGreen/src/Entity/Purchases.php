<?php

namespace App\Entity;

use App\Repository\PurchasesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PurchasesRepository::class)
 */
class Purchases
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $purchasesSuppliersref;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $purchasesDate;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     */
    private $purchasesPrice;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $purchasesQuantity;

    /**
     * @ORM\ManyToOne(targetEntity=Suppliers::class, inversedBy="purchases")
     * @ORM\JoinColumn(nullable=false)
     */
    private $suppliers;

    /**
     * @ORM\ManyToOne(targetEntity=Products::class, inversedBy="purchases")
     * @ORM\JoinColumn(nullable=false)
     */
    private $products;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPurchasesSuppliersref(): ?string
    {
        return $this->purchasesSuppliersref;
    }

    public function setPurchasesSuppliersref(?string $purchasesSuppliersref): self
    {
        $this->purchasesSuppliersref = $purchasesSuppliersref;

        return $this;
    }

    public function getPurchasesDate(): ?\DateTimeInterface
    {
        return $this->purchasesDate;
    }

    public function setPurchasesDate(?\DateTimeInterface $purchasesDate): self
    {
        $this->purchasesDate = $purchasesDate;

        return $this;
    }

    public function getPurchasesPrice(): ?string
    {
        return $this->purchasesPrice;
    }

    public function setPurchasesPrice(?string $purchasesPrice): self
    {
        $this->purchasesPrice = $purchasesPrice;

        return $this;
    }

    public function getPurchasesQuantity(): ?int
    {
        return $this->purchasesQuantity;
    }

    public function setPurchasesQuantity(?int $purchasesQuantity): self
    {
        $this->purchasesQuantity = $purchasesQuantity;

        return $this;
    }

    public function getSuppliers(): ?Suppliers
    {
        return $this->suppliers;
    }

    public function setSuppliers(?Suppliers $suppliers): self
    {
        $this->suppliers = $suppliers;

        return $this;
    }

    public function getProducts(): ?Products
    {
        return $this->products;
    }

    public function setProducts(?Products $products): self
    {
        $this->products = $products;

        return $this;
    }
}
