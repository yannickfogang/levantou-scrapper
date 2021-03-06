<?php

namespace Module\Infrastructure\Product;

use Module\Domain\Product\Product;
use Module\Domain\Product\ProductRepository;

class ProductRepositoryInMemory implements ProductRepository
{
    private array $products = [];

    public function save(Product $product): bool
    {
        $this->products[] = $product;
        return true;
    }
}
