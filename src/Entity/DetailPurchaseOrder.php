<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetailPurchaseOrder
 *
 * @ORM\Table(name="Detail_Purchase_Order", indexes={@ORM\Index(name="fk_detail_pruchase_order_product", columns={"product_id"}), @ORM\Index(name="fk_detail_purchase_order_purchase_order", columns={"purchase_order_id"})})
 * @ORM\Entity
 */
class DetailPurchaseOrder
{
    /**
     * @var int
     *
     * @ORM\Column(name="detail_purchase_order_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $detailPurchaseOrderId;

    /**
     * @var float
     *
     * @ORM\Column(name="quantity", type="float", precision=10, scale=0, nullable=false)
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="unit", type="string", length=10, nullable=false)
     */
    private $unit;

    /**
     * @var \Product
     *
     * @ORM\ManyToOne(targetEntity="Product")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="product_id", referencedColumnName="product_id")
     * })
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=PurchaseOrder::class, inversedBy="detailPurchaseOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $purchaseOrder;

    public function getPurchaseOrder(): ?PurchaseOrder
    {
        return $this->purchaseOrder;
    }

    public function setPurchaseOrder(?PurchaseOrder $purchaseOrder): self
    {
        $this->purchaseOrder = $purchaseOrder;

        return $this;
    }


}
