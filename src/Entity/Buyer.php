<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Buyer
 *
 * @ORM\Table(name="Buyer", indexes={@ORM\Index(name="fk_buyer_enterprise", columns={"enterprise_id"})})
 * @ORM\Entity
 */
class Buyer
{
    /**
     * @var int
     *
     * @ORM\Column(name="buyer_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $buyerId;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_name", type="string", length=50, nullable=false)
     */
    private $contactName;

    /**
     * @var \Enterprise
     *
     * @ORM\ManyToOne(targetEntity="Enterprise")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="enterprise_id", referencedColumnName="enterprise_id")
     * })
     */
    private $enterprise;


}
