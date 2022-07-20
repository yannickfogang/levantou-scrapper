<?php

namespace Module\Domain\Product;

interface AsinRepository
{
    public function save(Asin $asin): bool;
    public function getByAsin(string $asin): ?Asin;
}
