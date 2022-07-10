<?php

namespace Module\Application\Product\Command;

use Module\Domain\Product\Product;
use Module\Domain\Product\ProductRepository;

class SaveProductHandler
{

    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @param SaveProductCommand $saveProductCommand
     * @return SaveProductResponse
     */
    public function __invoke(SaveProductCommand $saveProductCommand): SaveProductResponse
    {
        $response = new SaveProductResponse();

        $product = Product::create(
            $saveProductCommand->uuid,
            $saveProductCommand->title,
            $saveProductCommand->description,
            $saveProductCommand->price,
            $saveProductCommand->saler_by,
            $saveProductCommand->sender_on_store
        );

        $response->isSave = $this->productRepository->add($product);

        return $response;
    }

}
