<?php

namespace Tests\Feature\Scrapper;

use App\Models\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Module\Application\Scrapper\Load\LoadProductHandler;
use Module\Infrastructure\Product\ProductRepositoryEloquent;
use Module\Infrastructure\Scrapper\Curl;
use Module\Infrastructure\Scrapper\ScrapperWebScrappingApi;
use Tests\TestCase;

class ScrapperTest extends TestCase
{
    use RefreshDatabase;

    private ScrapperWebScrappingApi $scrapperApi;
    private string $asin;
    private ProductRepositoryEloquent $productRepository;

    public function setUp(): void
    {
        parent::setUp(); // TODO: Change the autogenerated stub
        $this->asin = 'B07NQF38K4';
        $curl = new Curl();
        $this->scrapperApi = new ScrapperWebScrappingApi($curl);
        $this->productRepository = new ProductRepositoryEloquent();
    }

    public function test_can_save_product() {
        $loadProduct = new LoadProductHandler($this->scrapperApi, $this->productRepository);
        $loadProduct->__invoke($this->asin);
        $this->assertCount(1, Product::all());
        $this->assertEquals(1, Product::all()->count());
    }

}