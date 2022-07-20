<?php

namespace Module\Infrastructure\Product;

use Module\Domain\Product\Product;
use Module\Domain\Product\ProductRepository;

class ProductRepositoryEloquent implements ProductRepository
{

    public function save(Product $product): bool
    {
        try {
            \App\Models\Product::create(
                [
                    'uuid' => $product->getUuid(),
                    'title' => $product->getTitle(),
                    'description' => $product->getDescription(),
                    'description_html' => $product->getDescriptionHtml(),
                    'price' => $product->getPrice(),
                    'asin' => $product->getAsin(),
                    'seller_by' => $product->getSalerBy(),
                    'sender_on_store' => $product->getSenderOnStore(),
                    'currency' => $product->getCurrency(),
                    'publish_date' => $product->getPublishDate(),
                    'evaluation' => $product->getEvaluation(),
                    'best_seller_rank' => $product->getBestSellerRank(),
                    'link_concurrent_product' => $product->getLinkMoreProduct(),
                    'categories' => $product->getCategories(),
                    'concurrent_products' => $product->getConcurrentProduct(),
                    'images' => $product->getImages(),
                    'related_products' => $product->getRelatedProducts(),
                    'product_bought_together' => $product->getProductBoughtTogether()
                ]
            );
            return true;
        } catch (\Exception $e) {
            dd($e);
        }
        return false;
    }
}
