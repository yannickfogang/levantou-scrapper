<?php

namespace Module\Domain\Product;

interface ProductRepository
{
    public function add(Product $product): bool;
}
