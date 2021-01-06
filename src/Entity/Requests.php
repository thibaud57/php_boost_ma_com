<?php

namespace App\Entity;

use App\Repository\RequestsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RequestsRepository::class)
 */
class Requests
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
    private $object;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="array")
     */
    private $status = ['ouverte', 'en cours', 'en attente', 'fermée'];

    /**
     * @ORM\ManyToOne(targetEntity=Customers::class, inversedBy="requests")
     */
    private $customer;

    /**
     * @ORM\OneToOne(targetEntity=Tickets::class, mappedBy="request", cascade={"persist", "remove"})
     */
    private $tickets;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getObject(): ?string
    {
        return $this->object;
    }

    public function setObject(string $object): self
    {
        $this->object = $object;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getStatus(): ?array
    {
        return $this->status;
    }

    public function setStatus(array $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getCustomer(): ?Customers
    {
        return $this->customer;
    }

    public function setCustomer(?Customers $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getTickets(): ?Tickets
    {
        return $this->tickets;
    }

    public function setTickets(?Tickets $tickets): self
    {
        // unset the owning side of the relation if necessary
        if ($tickets === null && $this->tickets !== null) {
            $this->tickets->setRequest(null);
        }

        // set the owning side of the relation if necessary
        if ($tickets !== null && $tickets->getRequest() !== $this) {
            $tickets->setRequest($this);
        }

        $this->tickets = $tickets;

        return $this;
    }
}
