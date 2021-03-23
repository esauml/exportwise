<?php

namespace App\Entity;

use App\Repository\AcceptanceOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AcceptanceOrderRepository::class)
 */
class AcceptanceOrder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Enterprise::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $seller;

    /**
     * @ORM\ManyToOne(targetEntity=Enterprise::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $buyer;

    /**
     * @ORM\ManyToOne(targetEntity=PurchaseOrder::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $purchaseOrder;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $subtotal;

    /**
     * @ORM\Column(type="date", nullable=true)
     */
    private $expected_arrive_date;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_done;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=DetailAcceptanceOrder::class, mappedBy="acceptanceOrder")
     */
    private $detailAcceptanceOrders;

    public function __construct()
    {
        $this->detailAcceptanceOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSeller(): ?Enterprise
    {
        return $this->seller;
    }

    public function setSeller(?Enterprise $seller): self
    {
        $this->seller = $seller;

        return $this;
    }

    public function getBuyer(): ?Enterprise
    {
        return $this->buyer;
    }

    public function setBuyer(?Enterprise $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }

    public function getPurchaseOrder(): ?PurchaseOrder
    {
        return $this->purchaseOrder;
    }

    public function setPurchaseOrder(?PurchaseOrder $purchaseOrder): self
    {
        $this->purchaseOrder = $purchaseOrder;

        return $this;
    }

    public function getSubtotal(): ?float
    {
        return $this->subtotal;
    }

    public function setSubtotal(?float $subtotal): self
    {
        $this->subtotal = $subtotal;

        return $this;
    }

    public function getExpectedArriveDate(): ?\DateTimeInterface
    {
        return $this->expected_arrive_date;
    }

    public function setExpectedArriveDate(
        ?\DateTimeInterface $expected_arrive_date
    ): self {
        $this->expected_arrive_date = $expected_arrive_date;

        return $this;
    }

    public function getDateDone(): ?\DateTimeInterface
    {
        return $this->date_done;
    }

    public function setDateDone(\DateTimeInterface $date_done): self
    {
        $this->date_done = $date_done;

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

    /**
     * @return Collection|DetailAcceptanceOrder[]
     */
    public function getDetailAcceptanceOrders(): Collection
    {
        return $this->detailAcceptanceOrders;
    }

    public function addDetailAcceptanceOrder(
        DetailAcceptanceOrder $detailAcceptanceOrder
    ): self {
        if (!$this->detailAcceptanceOrders->contains($detailAcceptanceOrder)) {
            $this->detailAcceptanceOrders[] = $detailAcceptanceOrder;
            $detailAcceptanceOrder->setAcceptanceOrder($this);
        }

        return $this;
    }

    public function removeDetailAcceptanceOrder(
        DetailAcceptanceOrder $detailAcceptanceOrder
    ): self {
        if (
            $this->detailAcceptanceOrders->removeElement($detailAcceptanceOrder)
        ) {
            // set the owning side to null (unless already changed)
            if ($detailAcceptanceOrder->getAcceptanceOrder() === $this) {
                $detailAcceptanceOrder->setAcceptanceOrder(null);
            }
        }

        return $this;
    }
}
