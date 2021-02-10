<?php

namespace App\Entity;

use App\Repository\SuppliersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=SuppliersRepository::class)
 */
class Suppliers
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex("/^[a-zA-Z.\s]+$/")
     * @Assert\NotBlank()
     */
    private $suppliersName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $suppliersAddress;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $suppliersZipcode;

    /**
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    private $suppliersCity;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $suppliersPhone;

    /**
     * @ORM\ManyToOne(targetEntity=Supplierstype::class, inversedBy="suppliers")
     * @ORM\JoinColumn(nullable=false)
     */
    private $supplierstype;

    /**
     * @ORM\OneToMany(targetEntity=Purchases::class, mappedBy="suppliers", orphanRemoval=true)
     */
    private $purchases;

    public function __construct()
    {
        $this->purchases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSuppliersName(): ?string
    {
        return $this->suppliersName;
    }

    public function setSuppliersName(string $suppliersName): self
    {
        $this->suppliersName = $suppliersName;

        return $this;
    }

    public function getSuppliersAddress(): ?string
    {
        return $this->suppliersAddress;
    }

    public function setSuppliersAddress(?string $suppliersAddress): self
    {
        $this->suppliersAddress = $suppliersAddress;

        return $this;
    }

    public function getSuppliersZipcode(): ?string
    {
        return $this->suppliersZipcode;
    }

    public function setSuppliersZipcode(?string $suppliersZipcode): self
    {
        $this->suppliersZipcode = $suppliersZipcode;

        return $this;
    }

    public function getSuppliersCity(): ?string
    {
        return $this->suppliersCity;
    }

    public function setSuppliersCity(?string $suppliersCity): self
    {
        $this->suppliersCity = $suppliersCity;

        return $this;
    }

    public function getSuppliersPhone(): ?string
    {
        return $this->suppliersPhone;
    }

    public function setSuppliersPhone(?string $suppliersPhone): self
    {
        $this->suppliersPhone = $suppliersPhone;

        return $this;
    }

    public function getSupplierstype(): ?Supplierstype
    {
        return $this->supplierstype;
    }

    public function setSupplierstype(?Supplierstype $supplierstype): self
    {
        $this->supplierstype = $supplierstype;

        return $this;
    }

    /**
     * @return Collection|Purchases[]
     */
    public function getPurchases(): Collection
    {
        return $this->purchases;
    }

    public function addPurchase(Purchases $purchase): self
    {
        if (!$this->purchases->contains($purchase)) {
            $this->purchases[] = $purchase;
            $purchase->setSuppliers($this);
        }

        return $this;
    }

    public function removePurchase(Purchases $purchase): self
    {
        if ($this->purchases->removeElement($purchase)) {
            // set the owning side to null (unless already changed)
            if ($purchase->getSuppliers() === $this) {
                $purchase->setSuppliers(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->suppliersName;
    }
}
