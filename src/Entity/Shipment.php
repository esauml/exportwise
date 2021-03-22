<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Shipment
 *
 * @ORM\Table(name="Shipment", indexes={@ORM\Index(name="fk_shipment_acceptance_order", columns={"acceptance_order_id"})})
 * @ORM\Entity
 */
class Shipment
{
    /**
     * @var int
     *
     * @ORM\Column(name="shipment_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $shipmentId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="posting_date", type="datetime", nullable=false)
     */
    private $postingDate;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="arrive_date", type="datetime", nullable=true)
     */
    private $arriveDate;

    /**
     * @var float
     *
     * @ORM\Column(name="comision", type="float", precision=10, scale=0, nullable=false)
     */
    private $comision;

    /**
     * @var float
     *
     * @ORM\Column(name="total", type="float", precision=10, scale=0, nullable=false)
     */
    private $total;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer", nullable=false)
     */
    private $status = '0';

    /**
     * @var \AcceptanceOrder
     *
     * @ORM\ManyToOne(targetEntity="AcceptanceOrder")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="acceptance_order_id", referencedColumnName="acceptance_order_id")
     * })
     */
    private $acceptanceOrder;


}
