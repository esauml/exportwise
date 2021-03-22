<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * AcceptanceOrder
 *
 * @ORM\Table(name="Acceptance_Order", indexes={@ORM\Index(name="fk_acceptance_2", columns={"buyer_id"}), @ORM\Index(name="purchase_order_id", columns={"purchase_order_id"}), @ORM\Index(name="fk_acceptance_1", columns={"seller_id"})})
 * @ORM\Entity
 */
class AcceptanceOrder
{
    /**
     * @var int
     *
     * @ORM\Column(name="acceptance_order_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $acceptanceOrderId;

    /**
     * @var float
     *
     * @ORM\Column(name="subtotal", type="float", precision=7, scale=2, nullable=false)
     */
    private $subtotal;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="expected_arrive", type="date", nullable=false)
     */
    private $expectedArrive;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_done", type="date", nullable=false)
     */
    private $dateDone;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status;

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
     * @var \Buyer
     *
     * @ORM\ManyToOne(targetEntity="Buyer")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="buyer_id", referencedColumnName="buyer_id")
     * })
     */
    private $buyer;

    /**
     * @var \PurchaseOrder
     *
     * @ORM\ManyToOne(targetEntity="PurchaseOrder")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="purchase_order_id", referencedColumnName="purchase_order_id")
     * })
     */
    private $purchaseOrder;

    /**
     * @ORM\OneToMany(targetEntity=DetailAcceptanceOrder::class, mappedBy="acceptanceOrder")
     */
    private $detailAcceptanceOrders;

    public function __construct()
    {
        $this->detailAcceptanceOrders = new ArrayCollection();
    }

    /**
     * @return Collection|DetailAcceptanceOrder[]
     */
    public function getDetailAcceptanceOrders(): Collection
    {
        return $this->detailAcceptanceOrders;
    }

    public function addDetailAcceptanceOrder(DetailAcceptanceOrder $detailAcceptanceOrder): self
    {
        if (!$this->detailAcceptanceOrders->contains($detailAcceptanceOrder)) {
            $this->detailAcceptanceOrders[] = $detailAcceptanceOrder;
            $detailAcceptanceOrder->setAcceptanceOrder($this);
        }

        return $this;
    }

    public function removeDetailAcceptanceOrder(DetailAcceptanceOrder $detailAcceptanceOrder): self
    {
        if ($this->detailAcceptanceOrders->removeElement($detailAcceptanceOrder)) {
            // set the owning side to null (unless already changed)
            if ($detailAcceptanceOrder->getAcceptanceOrder() === $this) {
                $detailAcceptanceOrder->setAcceptanceOrder(null);
            }
        }

        return $this;
    }


}
