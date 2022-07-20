<?php

namespace Module\Domain\Product;

interface ProductRepository
{
    public function save(Product $product): bool;

}
