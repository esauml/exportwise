<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * PurchaseOrder
 *
 * @ORM\Table(name="Purchase_Order", indexes={@ORM\Index(name="fk_purchase_order_seller", columns={"seller_id"}), @ORM\Index(name="fk_purchase_order_buyer_id", columns={"buyer_id"})})
 * @ORM\Entity
 */
class PurchaseOrder
{
    /**
     * @var int
     *
     * @ORM\Column(name="purchase_order_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $purchaseOrderId;

    /**
     * @var int
     *
     * @ORM\Column(name="date_done", type="integer", nullable=false)
     */
    private $dateDone;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status = '0';

    /**
     * @var \Buyer
     *
     * @ORM\ManyToOne(targetEntity="Buyer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="buyer_id", referencedColumnName="buyer_id")
     * })
     */
    private $buyer;

    /**
     * @var \Seller
     *
     * @ORM\ManyToOne(targetEntity="Seller")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="seller_id", referencedColumnName="seller_id")
     * })
     */
    private $seller;

    /**
     * @ORM\OneToMany(targetEntity=DetailPurchaseOrder::class, mappedBy="purchaseOrder")
     */
    private $detailPurchaseOrders;

    public function __construct()
    {
        $this->detailPurchaseOrders = new ArrayCollection();
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
