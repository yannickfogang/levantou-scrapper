<?php

namespace Module\Domain\Product;

interface ScrapperApi
{
    public function loadPage(string $url, string $countryCode): string;
}
