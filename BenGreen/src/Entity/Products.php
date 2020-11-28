<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductsRepository::class)
 */
class Products
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     * @Assert\Length (min=4, max=50)
     */
    private $productsName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Length (min=4, max=255)
     */
    private $productsDescription;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $productsStock;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $productsPicture;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $productsStatus;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     */
    private $productsPrice;

    /**
     * @ORM\OneToMany(targetEntity=Orderdetail::class, mappedBy="products", orphanRemoval=true)
     */
    private $orderdetails;

    /**
     * @ORM\OneToMany(targetEntity=Purchases::class, mappedBy="products", orphanRemoval=true)
     */
    private $purchases;

    /**
     * @ORM\ManyToOne(targetEntity=Rubrique::class, inversedBy="products")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rubrique;

    public function __construct()
    {
        $this->orderdetails = new ArrayCollection();
        $this->purchases = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProductsName(): ?string
    {
        return $this->productsName;
    }

    public function setProductsName(string $productsName): self
    {
        $this->productsName = $productsName;

        return $this;
    }

    public function getProductsDescription(): ?string
    {
        return $this->productsDescription;
    }

    public function setProductsDescription(?string $productsDescription): self
    {
        $this->productsDescription = $productsDescription;

        return $this;
    }

    public function getProductsStock(): ?int
    {
        return $this->productsStock;
    }

    public function setProductsStock(?int $productsStock): self
    {
        $this->productsStock = $productsStock;

        return $this;
    }

    public function getProductsPicture(): ?string
    {
        return $this->productsPicture;
    }

    public function setProductsPicture(?string $productsPicture): self
    {
        $this->productsPicture = $productsPicture;

        return $this;
    }

    public function getProductsStatus(): ?bool
    {
        return $this->productsStatus;
    }

    public function setProductsStatus(?bool $productsStatus): self
    {
        $this->productsStatus = $productsStatus;

        return $this;
    }

    public function getProductsPrice(): ?string
    {
        return $this->productsPrice;
    }

    public function setProductsPrice(?string $productsPrice): self
    {
        $this->productsPrice = $productsPrice;

        return $this;
    }

    /**
     * @return Collection|Orderdetail[]
     */
    public function getOrderdetails(): Collection
    {
        return $this->orderdetails;
    }

    public function addOrderdetail(Orderdetail $orderdetail): self
    {
        if (!$this->orderdetails->contains($orderdetail)) {
            $this->orderdetails[] = $orderdetail;
            $orderdetail->setProducts($this);
        }

        return $this;
    }

    public function removeOrderdetail(Orderdetail $orderdetail): self
    {
        if ($this->orderdetails->removeElement($orderdetail)) {
            // set the owning side to null (unless already changed)
            if ($orderdetail->getProducts() === $this) {
                $orderdetail->setProducts(null);
            }
        }

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
            $purchase->setProducts($this);
        }

        return $this;
    }

    public function removePurchase(Purchases $purchase): self
    {
        if ($this->purchases->removeElement($purchase)) {
            // set the owning side to null (unless already changed)
            if ($purchase->getProducts() === $this) {
                $purchase->setProducts(null);
            }
        }

        return $this;
    }

    public function getRubrique(): ?Rubrique
    {
        return $this->rubrique;
    }

    public function setRubrique(?Rubrique $rubrique): self
    {
        $this->rubrique = $rubrique;

        return $this;
    }
}
