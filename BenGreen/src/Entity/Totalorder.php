<?php

namespace App\Entity;

use App\Repository\TotalorderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TotalorderRepository::class)
 */
class Totalorder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $totalorderDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updatedAt;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $totalorderBilladdress;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $totalorderDeliveryaddress;

    /**
     * @ORM\Column(type="decimal", precision=8, scale=2, nullable=true)
     */
    private $totalorderDiscount;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $totalorderInvoicenb;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $totalorderInvoicedate;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $totalorderDeadline;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status = self::STATUS_CART;

    /**
     * An order that is in progress, not placed yet.
     *
     * @var string
     */
    const STATUS_CART = 'cart';

    /**
     * @ORM\ManyToOne(targetEntity=Customers::class, inversedBy="totalorders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $customers;

    /**
     * @ORM\OneToMany(targetEntity=Orderdetail::class, mappedBy="totalorder", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $orderdetails;

    public function __construct()
    {
        $this->orderdetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTotalorderDate(): ?\DateTimeInterface
    {
        return $this->totalorderDate;
    }

    public function setTotalorderDate(\DateTimeInterface $totalorderDate): self
    {
        $this->totalorderDate = $totalorderDate;

        return $this;
    }


    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getTotalorderBilladdress(): ?string
    {
        return $this->totalorderBilladdress;
    }

    public function setTotalorderBilladdress(?string $totalorderBilladdress): self
    {
        $this->totalorderBilladdress = $totalorderBilladdress;

        return $this;
    }

    public function getTotalorderDeliveryaddress(): ?string
    {
        return $this->totalorderDeliveryaddress;
    }

    public function setTotalorderDeliveryaddress(?string $totalorderDeliveryaddress): self
    {
        $this->totalorderDeliveryaddress = $totalorderDeliveryaddress;

        return $this;
    }

    public function getTotalorderDiscount(): ?string
    {
        return $this->totalorderDiscount;
    }

    public function setTotalorderDiscount(?string $totalorderDiscount): self
    {
        $this->totalorderDiscount = $totalorderDiscount;

        return $this;
    }

    public function getTotalorderInvoicenb(): ?int
    {
        return $this->totalorderInvoicenb;
    }

    public function setTotalorderInvoicenb(?int $totalorderInvoicenb): self
    {
        $this->totalorderInvoicenb = $totalorderInvoicenb;

        return $this;
    }

    public function getTotalorderInvoicedate(): ?\DateTimeInterface
    {
        return $this->totalorderInvoicedate;
    }

    public function setTotalorderInvoicedate(?\DateTimeInterface $totalorderInvoicedate): self
    {
        $this->totalorderInvoicedate = $totalorderInvoicedate;

        return $this;
    }

    public function getTotalorderDeadline(): ?\DateTimeInterface
    {
        return $this->totalorderDeadline;
    }

    public function setTotalorderDeadline(?\DateTimeInterface $totalorderDeadline): self
    {
        $this->totalorderDeadline = $totalorderDeadline;

        return $this;
    }

    public function getCustomers(): ?Customers
    {
        return $this->customers;
    }

    public function setCustomers(?Customers $customers): self
    {
        $this->customers = $customers;

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
        foreach ($this->getOrderdetails() as $existingItem) {
            //if the item already exists, update the quantity :
            if($existingItem->equals($orderdetail)) {
                $existingItem->setOrderdetailQuantity(
                    $existingItem->getOrderdetailQuantity() + $orderdetail->getOrderdetailQuantity()
                );
                return $this;
            }
        }

        if (!$this->orderdetails->contains($orderdetail)) {
            $this->orderdetails[] = $orderdetail;
            $orderdetail->setTotalorder($this);
        }

        return $this;
    }

    public function removeOrderdetail(Orderdetail $orderdetail): self
    {
        if ($this->orderdetails->removeElement($orderdetail)) {
            // set the owning side to null (unless already changed)
            if ($orderdetail->getTotalorder() === $this) {
                $orderdetail->setTotalorder(null);
            }
        }

        return $this;
    }

    /**
     * Removes all items from the order.
     *
     * @return $this
     */
    public function removeOrderdetails(): self
    {
        foreach ($this->getOrderdetails() as $orderdetail) {
            $this->removeOrderdetail($orderdetail);
        }

        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Calculates the order total using the getTotal() method from Orderdetail entity :
     *
     * @return float
     */
    public function getTotal(): float
    {
        $total = 0;

        foreach ($this->getOrderdetails() as $item) {
            $total += $item->getTotal();
        }

        return $total;
    }

    public function __toString()
    {
        return "Commande n° " . $this->id;
    }

}
