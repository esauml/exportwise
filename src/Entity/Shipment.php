<?php

namespace App\Entity;

use App\Repository\ShipmentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ShipmentRepository::class)
 */
class Shipment
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
    private $posting_date;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $arrive_date;

    /**
     * @ORM\Column(type="float")
     */
    private $comision;

    /**
     * @ORM\Column(type="float")
     */
    private $total;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\ManyToOne(targetEntity=AcceptanceOrder::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $acceptanceOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPostingDate(): ?\DateTimeInterface
    {
        return $this->posting_date;
    }

    public function setPostingDate(\DateTimeInterface $posting_date): self
    {
        $this->posting_date = $posting_date;

        return $this;
    }

    public function getArriveDate(): ?\DateTimeInterface
    {
        return $this->arrive_date;
    }

    public function setArriveDate(?\DateTimeInterface $arrive_date): self
    {
        $this->arrive_date = $arrive_date;

        return $this;
    }

    public function getComision(): ?float
    {
        return $this->comision;
    }

    public function setComision(float $comision): self
    {
        $this->comision = $comision;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    public function getAcceptanceOrder(): ?AcceptanceOrder
    {
        return $this->acceptanceOrder;
    }

    public function setAcceptanceOrder(?AcceptanceOrder $acceptanceOrder): self
    {
        $this->acceptanceOrder = $acceptanceOrder;

        return $this;
    }
}
