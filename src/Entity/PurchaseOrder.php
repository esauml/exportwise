<?php

namespace App\Entity;

use App\Repository\PurchaseOrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=PurchaseOrderRepository::class)
 */
class PurchaseOrder
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Buyer::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $buyer;

    /**
     * @ORM\ManyToOne(targetEntity=Seller::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $seller;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date_done;

    /**
     * @ORM\Column(type="smallint")
     */
    private $status;

    /**
     * @ORM\OneToMany(targetEntity=DetailPurchaseOrder::class, mappedBy="purchaseOrder")
     */
    private $detailPurchaseOrders;

    public function __construct()
    {
        $this->detailPurchaseOrders = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBuyerId(): ?Buyer
    {
        return $this->buyer;
    }

    public function setBuyerId(?Buyer $buyer): self
    {
        $this->buyer = $buyer;

        return $this;
    }

    public function getSellerId(): ?Seller
    {
        return $this->seller;
    }

    public function setSellerId(?Seller $seller): self
    {
        $this->seller = $seller;

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
     * @return Collection|DetailPurchaseOrder[]
     */
    public function getDetailPurchaseOrders(): Collection
    {
        return $this->detailPurchaseOrders;
    }

    public function addDetailPurchaseOrder(DetailPurchaseOrder $detailPurchaseOrder): self
    {
        if (!$this->detailPurchaseOrders->contains($detailPurchaseOrder)) {
            $this->detailPurchaseOrders[] = $detailPurchaseOrder;
            $detailPurchaseOrder->setPurchaseOrder($this);
        }

        return $this;
    }

    public function removeDetailPurchaseOrder(DetailPurchaseOrder $detailPurchaseOrder): self
    {
        if ($this->detailPurchaseOrders->removeElement($detailPurchaseOrder)) {
            // set the owning side to null (unless already changed)
            if ($detailPurchaseOrder->getPurchaseOrder() === $this) {
                $detailPurchaseOrder->setPurchaseOrder(null);
            }
        }

        return $this;
    }
}
