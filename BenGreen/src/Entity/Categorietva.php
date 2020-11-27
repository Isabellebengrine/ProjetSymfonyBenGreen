<?php

namespace App\Entity;

use App\Repository\CategorietvaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CategorietvaRepository::class)
 */
class Categorietva
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=2)
     */
    private $categorietvaCoefficient;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $categorietvaNom;

    /**
     * @ORM\OneToMany(targetEntity=Customers::class, mappedBy="categorietva")
     */
    private $customers;

    public function __construct()
    {
        $this->customers = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCategorietvaCoefficient(): ?string
    {
        return $this->categorietvaCoefficient;
    }

    public function setCategorietvaCoefficient(string $categorietvaCoefficient): self
    {
        $this->categorietvaCoefficient = $categorietvaCoefficient;

        return $this;
    }

    public function getCategorietvaNom(): ?string
    {
        return $this->categorietvaNom;
    }

    public function setCategorietvaNom(?string $categorietvaNom): self
    {
        $this->categorietvaNom = $categorietvaNom;

        return $this;
    }

    /**
     * @return Collection|Customers[]
     */
    public function getCustomers(): Collection
    {
        return $this->customers;
    }

    public function addCustomer(Customers $customer): self
    {
        if (!$this->customers->contains($customer)) {
            $this->customers[] = $customer;
            $customer->setCategorietva($this);
        }

        return $this;
    }

    public function removeCustomer(Customers $customer): self
    {
        if ($this->customers->removeElement($customer)) {
            // set the owning side to null (unless already changed)
            if ($customer->getCategorietva() === $this) {
                $customer->setCategorietva(null);
            }
        }

        return $this;
    }

}
