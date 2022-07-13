<?php

namespace Module\Infrastructure\Scrapper;

use Goutte\Client;
use Illuminate\Support\Facades\App;
use Module\Domain\Product\Product;
use Module\Domain\Product\ScrapperApi;
use Symfony\Component\DomCrawler\Crawler;

class ScrapperWebScrappingApi implements ScrapperApi
{
    private Curl $curl;

    public function __construct(Curl $curl)
    {
        $this->curl = new $curl;
    }

    public function extractProduct($url, $countryCode): Product
    {
        $arrExtractRule = [
            'title' => ['selector' => '#productTitle', 'output' => 'text'],
            'categories' => [
                'selector' => 'div#wayfinding-breadcrumbs_feature_div a.a-color-tertiary',
                'output' => 'text'
            ],
            'description' => [
                'selector' => 'div#feature-bullets ul.a-unordered-list',
                'output' => 'html'
            ],
            'price' => [
                'selector' => 'div#corePrice_feature_div span.a-offscreen',
                'output' => 'text'
            ]
        ];
        $content = $this->curl->Call($url, $countryCode, $arrExtractRule);
        dd(json_decode($content, true));
    }
}

