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
     * @ORM\Column(type="string", length=80)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=80)
     */
    private $firstname;

    /**
     * @ORM\Column(type="integer")
     */
    private $zipcode;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    /**
     * @ORM\ManyToOne(targetEntity=Company::class, inversedBy="customers")
     */
    private $company;

    /**
     * @ORM\OneToMany(targetEntity=Rqst::class, mappedBy="customer", orphanRemoval=true)
     */
    private $rqsts;

    /**
     * @ORM\OneToOne(targetEntity=User::class, mappedBy="customer", cascade={"persist", "remove"})
     */
    private $user;

    public function __construct()
    {
        $this->rqsts = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getZipcode(): ?int
    {
        return $this->zipcode;
    }

    public function setZipcode(int $zipcode): self
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): self
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return Collection|Rqst[]
     */
    public function getRqsts(): Collection
    {
        return $this->rqsts;
    }

    public function addRqst(Rqst $rqst): self
    {
        if (!$this->rqsts->contains($rqst)) {
            $this->rqsts[] = $rqst;
            $rqst->setCustomer($this);
        }

        return $this;
    }

    public function removeRqst(Rqst $rqst): self
    {
        if ($this->rqsts->removeElement($rqst)) {
            // set the owning side to null (unless already changed)
            if ($rqst->getCustomer() === $this) {
                $rqst->setCustomer(null);
            }
        }

        return $this;
    }
    public function __toString()
    {
        return $this->name;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        // set the owning side of the relation if necessary
        if ($user->getCustomer() !== $this) {
            $user->setCustomer($this);
        }

        $this->user = $user;

        return $this;
    }
}
