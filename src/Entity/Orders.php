<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrdersRepository")
 */
class Orders
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $placedby;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ordered;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $orderPrice;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $status;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $address;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getPlacedby(): ?string
    {
        return $this->placedby;
    }

    public function setPlacedby(string $placedby): self
    {
        $this->placedby = $placedby;

        return $this;
    }

    public function getOrdered(): ?string
    {
        return $this->ordered;
    }

    public function setOrdered(string $ordered): self
    {
        $this->ordered = $ordered;

        return $this;
    }

    public function getOrderPrice(): ?string
    {
        return $this->orderPrice;
    }

    public function setOrderPrice(string $orderPrice): self
    {
        $this->orderPrice = $orderPrice;

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

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }
}
