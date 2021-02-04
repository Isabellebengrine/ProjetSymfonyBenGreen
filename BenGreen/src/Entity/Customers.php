<?php

namespace App\Entity;

use App\Repository\CustomersRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomersRepository::class)
 */
class Customers
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $customersName;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $customersAddress;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $customersZipcode;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $customersCity;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $customersPhone;

    /**
     * @ORM\ManyToOne(targetEntity=Employee::class, inversedBy="customers")
     */
    private $employee;

    /**
     * @ORM\ManyToOne(targetEntity=Categorietva::class, inversedBy="customers")
     *
     */
    private $categorietva;

    /**
     * @ORM\OneToMany(targetEntity=Totalorder::class, mappedBy="customers", orphanRemoval=true)
     */
    private $totalorders;

    /**
     * @ORM\OneToMany(targetEntity=Delivery::class, mappedBy="customers")
     */
    private $deliveries;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="customer", cascade={"persist", "remove"})
     */
    private $user;

    public function __construct()
    {
        $this->totalorders = new ArrayCollection();
        $this->deliveries = new ArrayCollection();
    }



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCustomersName(): ?string
    {
        return $this->customersName;
    }

    public function setCustomersName(string $customersName): self
    {
        $this->customersName = $customersName;

        return $this;
    }

    public function getCustomersAddress(): ?string
    {
        return $this->customersAddress;
    }

    public function setCustomersAddress(?string $customersAddress): self
    {
        $this->customersAddress = $customersAddress;

        return $this;
    }

    public function getCustomersZipcode(): ?string
    {
        return $this->customersZipcode;
    }

    public function setCustomersZipcode(?string $customersZipcode): self
    {
        $this->customersZipcode = $customersZipcode;

        return $this;
    }

    public function getCustomersCity(): ?string
    {
        return $this->customersCity;
    }

    public function setCustomersCity(?string $customersCity): self
    {
        $this->customersCity = $customersCity;

        return $this;
    }

    public function getCustomersPhone(): ?string
    {
        return $this->customersPhone;
    }

    public function setCustomersPhone(?string $customersPhone): self
    {
        $this->customersPhone = $customersPhone;

        return $this;
    }

    public function getEmployee(): ?Employee
    {
        return $this->employee;
    }

    public function setEmployee(?Employee $employee): self
    {
        $this->employee = $employee;

        return $this;
    }

    public function getCategorietva(): ?Categorietva
    {
        return $this->categorietva;
    }

    public function setCategorietva(?Categorietva $categorietva): self
    {
        $this->categorietva = $categorietva;

        return $this;
    }

    /**
     * @return Collection|Totalorder[]
     */
    public function getTotalorders(): Collection
    {
        return $this->totalorders;
    }

    public function addTotalorder(Totalorder $totalorder): self
    {
        if (!$this->totalorders->contains($totalorder)) {
            $this->totalorders[] = $totalorder;
            $totalorder->setCustomers($this);
        }

        return $this;
    }

    public function removeTotalorder(Totalorder $totalorder): self
    {
        if ($this->totalorders->removeElement($totalorder)) {
            // set the owning side to null (unless already changed)
            if ($totalorder->getCustomers() === $this) {
                $totalorder->setCustomers(null);
            }
        }

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
            $delivery->setCustomers($this);
        }

        return $this;
    }

    public function removeDelivery(Delivery $delivery): self
    {
        if ($this->deliveries->removeElement($delivery)) {
            // set the owning side to null (unless already changed)
            if ($delivery->getCustomers() === $this) {
                $delivery->setCustomers(null);
            }
        }

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        // set (or unset) the owning side of the relation if necessary
        $newCustomer = null === $user ? null : $this;
        if ($user->getCustomer() !== $newCustomer) {
            $user->setCustomer($newCustomer);
        }

        return $this;
    }


}
