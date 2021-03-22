<?php

namespace App\Entity;

use App\Repository\DetailAcceptanceOrderRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DetailAcceptanceOrderRepository::class)
 */
class DetailAcceptanceOrder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $product;

    /**
     * @ORM\Column(type="float")
     */
    private $quantity;

    /**
     * @ORM\Column(type="string", length=10)
     */
    private $unit;

    /**
     * @ORM\ManyToOne(targetEntity=AcceptanceOrder::class, inversedBy="detailAcceptanceOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $acceptanceOrder;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    public function getQuantity(): ?float
    {
        return $this->quantity;
    }

    public function setQuantity(float $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getUnit(): ?string
    {
        return $this->unit;
    }

    public function setUnit(string $unit): self
    {
        $this->unit = $unit;

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
