<?php

namespace App\Entity;

use App\Repository\SellerRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SellerRepository::class)
 */
class Seller
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=40)
     */
    private $contact_name;

    /**
     * @ORM\ManyToOne(targetEntity=Enterprise::class)
     * @ORM\JoinColumn(nullable=false)
     */
    private $enterprise;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContactName(): ?string
    {
        return $this->contact_name;
    }

    public function setContactName(string $contact_name): self
    {
        $this->contact_name = $contact_name;

        return $this;
    }

    public function getEnterpriseId(): ?Enterprise
    {
        return $this->enterprise;
    }

    public function setEnterpriseId(?Enterprise $enterprise): self
    {
        $this->enterprise = $enterprise;

        return $this;
    }
}
