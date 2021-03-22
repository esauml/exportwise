<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Enterprise
 *
 * @ORM\Table(name="Enterprise", uniqueConstraints={@ORM\UniqueConstraint(name="email", columns={"email"})})
 * @ORM\Entity
 */
class Enterprise
{
    /**
     * @var int
     *
     * @ORM\Column(name="enterprise_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $enterpriseId;

    /**
     * @var string
     *
     * @ORM\Column(name="company_name", type="string", length=40, nullable=false)
     */
    private $companyName;

    /**
     * @var string|null
     *
     * @ORM\Column(name="logo", type="text", length=65535, nullable=true)
     */
    private $logo = '';

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=45, nullable=false)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="phone", type="string", length=15, nullable=false)
     */
    private $phone;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=40, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=45, nullable=false)
     */
    private $password;


}
