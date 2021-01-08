<?php

namespace App\Entity;

use App\Repository\RqstRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RqstRepository::class)
 */
class Rqst
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
     * @ORM\OneToOne(targetEntity=Tickets::class, mappedBy="rqst", cascade={"persist", "remove"})
     */
    private $tickets;

    /**
     * @ORM\Column(type="string")
     */
    private $status = 'Nouvelle';

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="rqsts")
     */
    private $user;

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

    public function getTickets(): ?Tickets
    {
        return $this->tickets;
    }

    public function setTickets(?Tickets $tickets): self
    {
        // unset the owning side of the relation if necessary
        if ($tickets === null && $this->tickets !== null) {
            $this->tickets->setRqst(null);
        }

        // set the owning side of the relation if necessary
        if ($tickets !== null && $tickets->getRqst() !== $this) {
            $tickets->setRqst($this);
        }

        $this->tickets = $tickets;

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
    public function __toString()
    {
        return $this->object;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }
}
