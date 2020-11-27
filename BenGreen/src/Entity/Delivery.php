<?php

namespace App\Entity;

use App\Repository\DeliveryRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeliveryRepository::class)
 */
class Delivery
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $deliveryDate;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2, nullable=true)
     */
    private $deliveryQuantity;

    /**
     * @ORM\ManyToOne(targetEntity=Orderdetail::class, inversedBy="deliveries")
     */
    private $orderdetail;

    /**
     * @ORM\ManyToOne(targetEntity=Customers::class, inversedBy="deliveries")
     */
    private $customers;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDeliveryDate(): ?\DateTimeInterface
    {
        return $this->deliveryDate;
    }

    public function setDeliveryDate(?\DateTimeInterface $deliveryDate): self
    {
        $this->deliveryDate = $deliveryDate;

        return $this;
    }

    public function getDeliveryQuantity(): ?string
    {
        return $this->deliveryQuantity;
    }

    public function setDeliveryQuantity(?string $deliveryQuantity): self
    {
        $this->deliveryQuantity = $deliveryQuantity;

        return $this;
    }

    public function getOrderdetail(): ?Orderdetail
    {
        return $this->orderdetail;
    }

    public function setOrderdetail(?Orderdetail $orderdetail): self
    {
        $this->orderdetail = $orderdetail;

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
}
