<?php

namespace Module\Infrastructure\Scrapper;

use Module\Domain\Product\ScrapperApi;

class ScrapperWebScrappingApi implements ScrapperApi
{
    private Curl $curl;

    public function __construct(Curl $curl) {
        $this->curl = new $curl;
    }

    /**
     * @throws \Exception
     */
    public function loadPage(string $url, string $countryCode): string
    {
         return $this->curl->Call($url, $countryCode);
    }
}

