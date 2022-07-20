<?php

namespace Module\Domain\Product;

interface ScrapperApi
{
    public function extractDefaultProductDetailsData(string $asin): ?Product;
}
