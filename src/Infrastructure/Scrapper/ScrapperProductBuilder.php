<?php

namespace Module\Infrastructure\Scrapper;

use Module\Domain\Product\Product;

class ScrapperProductBuilder
{
    public ?string $title = null;
    public ?string $description = null;
    public ?string $descriptionHtml = null;
    public ?float $price = null;
    public ?string $currency = null;
    public ?string $asin = null;

    public ?string $saler_by = null;
    public ?string $sender_on_store = null;
    public ?string $publish_date = null;
    public ?string $evaluation = null;
    public ?string $best_seller_rank = null;
    public ?string $link_more_builder = null;
    public ?string $categories = null;
    public array $concurrentProduct = [];
    public array $images = [];
    public array $relatedProducts = [];
    private array $productBoughtTogether = [];


    public static function asProduct(): static
    {
        return new static();
    }


    public function withTitle(?string $title): static
    {
        $this->title = $title;
        return $this;
    }


    public function withDescription(?string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function withDescriptionHtml(?string $description): static
    {
        $this->descriptionHtml = $description;
        return $this;
    }

    public function withPrice(?float $price): static
    {
        $this->price = $price;
        return $this;
    }

    public function withSalerBy(?string $saler_by): static
    {
        $this->saler_by = $saler_by;
        return $this;
    }

    public function withSenderOnStore(?string $sender_on_store): static
    {
        $this->sender_on_store = $sender_on_store;
        return $this;
    }

    public function withCurrency(?string $currency): static
    {
        $this->currency = $currency;
        return $this;
    }

    public function withAsin(?string $asin): static
    {
        $this->asin = $asin;
        return $this;
    }


    public function withPublishDate(?string $publish_date): static
    {
        $this->publish_date = $publish_date;
        return $this;
    }

    public function withEvaluation(?string $evaluation): static
    {
        $this->evaluation = $evaluation;
        return $this;
    }

    public function withBestSellerRank(?string $best_seller_rank): static
    {
        $this->best_seller_rank = $best_seller_rank;
        return $this;
    }

    public function withLinkMoreProduct(string $link_more_product): static
    {
        $this->link_more_builder = $link_more_product;
        return $this;
    }

    public function withCategoriesProduct(string $categories): static
    {
        $this->categories = $categories;
        return $this;
    }

    public function withConcurrentProduct(array $products): static
    {
        $this->concurrentProduct = $products;
        return $this;
    }

    public function withImagesProducts(array $images): static
    {
        $this->images = $images;
        return $this;
    }

    public function withRelatedProducts(array $products): static
    {
        $this->relatedProducts = $products;
        return $this;
    }

    public function withProductsBoughtTogether(array $products): static
    {
        $this->productBoughtTogether = $products;
        return $this;
    }

    public function build(): Product
    {
        $product = Product::create(
            $this->title,
            $this->description,
            $this->price,
            $this->saler_by,
            $this->sender_on_store,
            $this->categories
        );

        $product->updateDescriptionHtml($this->descriptionHtml);
        $product->updateCurrency($this->currency);
        $product->updateAsin($this->asin);
        $product->updateEvaluation($this->evaluation);
        $product->updatePublishDate($this->publish_date);
        $product->updateBestSellerRank($this->best_seller_rank);
        $product->updateLinkMoreProduct($this->link_more_builder);
        $product->updateConcurrentProducts($this->concurrentProduct);
        $product->updateRelatedProducts($this->relatedProducts);
        $product->updateBoughtTogether($this->productBoughtTogether);
        $product->updateImages($this->images);

        return $product;
    }
}
