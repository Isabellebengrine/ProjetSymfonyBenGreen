<?php

namespace App\Entity;

use App\Repository\RubriqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RubriqueRepository::class)
 */
class Rubrique
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
    private $rubriqueName;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $rubriquePicture;

    /**
     * @ORM\ManyToOne(targetEntity=Rubrique::class)
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity=Products::class, mappedBy="rubrique", orphanRemoval=true)
     */
    private $products;

    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRubriqueName(): ?string
    {
        return $this->rubriqueName;
    }

    public function setRubriqueName(?string $rubriqueName): self
    {
        $this->rubriqueName = $rubriqueName;

        return $this;
    }

    public function getRubriquePicture(): ?string
    {
        return $this->rubriquePicture;
    }

    public function setRubriquePicture(?string $rubriquePicture): self
    {
        $this->rubriquePicture = $rubriquePicture;

        return $this;
    }

    public function getParent(): ?self
    {
        return $this->parent;
    }

    public function setParent(?self $parent): self
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * @return Collection|Products[]
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    public function addProduct(Products $product): self
    {
        if (!$this->products->contains($product)) {
            $this->products[] = $product;
            $product->setRubrique($this);
        }

        return $this;
    }

    public function removeProduct(Products $product): self
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getRubrique() === $this) {
                $product->setRubrique(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->rubriqueName;
    }
}
