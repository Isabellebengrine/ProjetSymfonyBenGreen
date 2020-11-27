<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EmployeeRepository::class)
 */
class Employee
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
    private $employeeName;

    /**
     * @ORM\OneToMany(targetEntity=Customers::class, mappedBy="employee")
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

    public function getEmployeeName(): ?string
    {
        return $this->employeeName;
    }

    public function setEmployeeName(string $employeeName): self
    {
        $this->employeeName = $employeeName;

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
            $customer->setEmployee($this);
        }

        return $this;
    }

    public function removeCustomer(Customers $customer): self
    {
        if ($this->customers->removeElement($customer)) {
            // set the owning side to null (unless already changed)
            if ($customer->getEmployee() === $this) {
                $customer->setEmployee(null);
            }
        }

        return $this;
    }
}
