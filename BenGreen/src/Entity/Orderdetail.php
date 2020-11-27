<?php

namespace App\Entity;

use App\Repository\OrderdetailRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=OrderdetailRepository::class)
 */
class Orderdetail
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2)
     */
    private $orderdetailPrice;

    /**
     * @ORM\Column(type="decimal", precision=4, scale=2)
     */
    private $orderdetailQuantity;

    /**
     * @ORM\ManyToOne(targetEntity=Totalorder::class, inversedBy="orderdetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $totalorder;

    /**
     * @ORM\ManyToOne(targetEntity=Products::class, inversedBy="orderdetails")
     * @ORM\JoinColumn(nullable=false)
     */
    private $products;

    /**
     * @ORM\OneToMany(targetEntity=Delivery::class, mappedBy="orderdetail")
     */
    private $deliveries;

    public function __construct()
    {
        $this->deliveries = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderdetailPrice(): ?int
    {
        return $this->orderdetailPrice;
    }

    public function setOrderdetailPrice(int $orderdetailPrice): self
    {
        $this->orderdetailPrice = $orderdetailPrice;

        return $this;
    }

    public function getOrderdetailQuantity(): ?int
    {
        return $this->orderdetailQuantity;
    }

    public function setOrderdetailQuantity(int $orderdetailQuantity): self
    {
        $this->orderdetailQuantity = $orderdetailQuantity;

        return $this;
    }

    public function getTotalorder(): ?Totalorder
    {
        return $this->totalorder;
    }

    public function setTotalorder(?Totalorder $totalorder): self
    {
        $this->totalorder = $totalorder;

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

    /**
     * @return Collection|Delivery[]
     */
    public function getDeliveries(): Collection
    {
        return $this->deliveries;
    }

    public function addDelivery(Delivery $delivery): self
    {
        if (!$this->deliveries->contains($delivery)) {
            $this->deliveries[] = $delivery;
            $delivery->setOrderdetail($this);
        }

        return $this;
    }

    public function removeDelivery(Delivery $delivery): self
    {
        if ($this->deliveries->removeElement($delivery)) {
            // set the owning side to null (unless already changed)
            if ($delivery->getOrderdetail() === $this) {
                $delivery->setOrderdetail(null);
            }
        }

        return $this;
    }
}
