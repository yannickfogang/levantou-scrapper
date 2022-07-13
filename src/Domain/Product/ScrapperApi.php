<?php

namespace Module\Domain\Product;

interface ScrapperApi
{
    public function extractProduct(string $url, string $countryCode): Product;
}
