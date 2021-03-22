<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Seller
 *
 * @ORM\Table(name="Seller", indexes={@ORM\Index(name="enterprise_id", columns={"enterprise_id"})})
 * @ORM\Entity
 */
class Seller
{
    /**
     * @var int
     *
     * @ORM\Column(name="seller_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $sellerId;

    /**
     * @var string
     *
     * @ORM\Column(name="contact_name", type="string", length=30, nullable=false)
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
