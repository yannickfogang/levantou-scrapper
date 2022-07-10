<?php

namespace AsinData\RetrieveData;

use Tests\Unit\AsinData\Builder\SaveProductCommandBuild;
use Module\Application\Product\Command\SaveProductHandler;
use Module\Domain\Product\ErrorSaveProductArgumentsException;
use Module\Infrastructure\Product\ProductRepositoryInMemory;
use Tests\TestCase;

class RetrieveDataTest extends TestCase
{

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
    }

    public function test_asin_data_can_save_after_fetch()
    {
        $saveProductCommand = SaveProductCommandBuild::asProduct()->build();
        $productRepository = new ProductRepositoryInMemory();
        $saveProduct = new SaveProductHandler($productRepository);
        $response = $saveProduct->__invoke($saveProductCommand);
        $this->assertTrue($response->isSave);
    }

    public function test_asin_data_save_with_wrong_params() {
        $saveProductCommand = SaveProductCommandBuild::asProduct()
            ->withTitle('')
            ->withDescription('')
            ->build();
        $productRepository = new ProductRepositoryInMemory();
        $saveProduct = new SaveProductHandler($productRepository);
        $this->expectException(ErrorSaveProductArgumentsException::class);
        $this->expectExceptionMessage("Tous les paramètres du produit ne sont pas renseigné");
        $saveProduct->__invoke($saveProductCommand);
    }
}

