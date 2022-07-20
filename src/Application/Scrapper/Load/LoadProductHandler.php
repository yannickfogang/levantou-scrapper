<?php

namespace Module\Application\Scrapper\Load;

use Module\Domain\Product\ProductRepository;
use Module\Domain\Product\ScrapperApi;

class LoadProductHandler
{

    private ScrapperApi $scrapperApi;
    private ProductRepository $productRepository;

    public function __construct(ScrapperApi $scrapperApi, ProductRepository $productRepository)
    {
        $this->scrapperApi = $scrapperApi;
        $this->productRepository = $productRepository;
    }

    public function __invoke(string $asin): LoadProductResponse
    {
        $response = new LoadProductResponse();

        $product = $this->scrapperApi->extractDefaultProductDetailsData($asin);

        if ($product) {
            $response->isLoad = true;
        }
        $response->isSave = $this->productRepository->save($product);
        return $response;
    }

}
