<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DetailAcceptanceOrder
 *
 * @ORM\Table(name="Detail_Acceptance_Order", indexes={@ORM\Index(name="product_id", columns={"product_id"}), @ORM\Index(name="acceptance_order_id", columns={"acceptance_order_id"})})
 * @ORM\Entity
 */
class DetailAcceptanceOrder
{
    /**
     * @var int
     *
     * @ORM\Column(name="detail_acceptance_order", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $detailAcceptanceOrder;

    /**
     * @var float
     *
     * @ORM\Column(name="quantity", type="float", precision=7, scale=2, nullable=false)
     */
    private $quantity;

    /**
     * @var string
     *
     * @ORM\Column(name="unit", type="string", length=5, nullable=false)
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
     * @ORM\ManyToOne(targetEntity=AcceptanceOrder::class, inversedBy="detailAcceptanceOrders")
     * @ORM\JoinColumn(nullable=false)
     */
    private $acceptanceOrder;

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
