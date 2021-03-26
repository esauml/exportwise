<?php
namespace App\Entity;

class ProductSearch {

    /**
     * @var int|null
     */
    private $maxPrice;

    /**
     * @return int|null
     */
    public function getMaxPrice(): ?int
    {
        return $this->maxPrice;
    }

    /**
     * @param int|null $maxPrice
     * @return ProductSearch
     */
    public function setMaxPrice(int $maxPrice): ProductSearch
    {
        $this->maxPrice = $maxPrice;
        return $this;
    }

}