<?php

namespace Module\Domain\Product;

use Module\Domain\Product\Exception\ErrorSaveProductArgumentsException;
use Ramsey\Uuid\Uuid;

class Product
{
    private ?string $uuid;
    private ?string $title;
    private ?string $description;
    private ?string $descriptionHtml;
    private ?string $asin;
    private ?float $price;
    private ?string $saler_by;
    private ?string $sender_on_store;

    private ?string $currency;
    private ?string $publish_date;
    private ?string $evaluation;
    private ?string $best_seller_rank;
    private ?string $link_more_product;
    private ?string $categories;
    private array $concurrentProduct = [];
    private array $images = [];
    private array $relatedProducts = [];
    private array $productBoughtTogether = [];

    private function __construct(
        ?string $uuid,
        ?string $title,
        ?string $description,
        ?float  $price,
        ?string $saler_by,
        ?string $sender_on_store,
        ?string $categories
    )
    {
        $this->uuid = $uuid;
        $this->title = $title;
        $this->description = $description;
        $this->price = $price;
        $this->saler_by = $saler_by;
        $this->sender_on_store = $sender_on_store;
        $this->categories = $categories;
    }

    /**
     * @throws ErrorSaveProductArgumentsException
     */
    public static function create(
        ?string $title,
        ?string $description,
        ?float  $price,
        ?string $saler_by,
        ?string $sender_on_store,
        ?string $categories
    ): static
    {
        $uuid = Uuid::uuid4()->toString();
        $self = new static(
            $uuid,
            $title,
            $description,
            $price,
            $saler_by,
            $sender_on_store,
            $categories
        );
        $self->uuid = $uuid;
        $self->title = $title;
        $self->description = $description;
        $self->price = $price;
        $self->saler_by = $saler_by;
        $self->sender_on_store = $sender_on_store;

        //$self->validateProductData();

        return $self;
    }

    /**
     * @return string|null
     */
    public function getUuid(): ?string
    {
        return $this->uuid;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getPrice(): ?float
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getSalerBy(): ?string
    {
        return $this->saler_by;
    }

    /**
     * @return string
     */
    public function getSenderOnStore(): ?string
    {
        return $this->sender_on_store;
    }

    public function updateDescriptionHtml(?string $description): void
    {
        $this->descriptionHtml = $description;
    }

    public function updateCurrency(?string $currency): void
    {
        $this->currency = $currency;
    }

    /**
     * @param string $asin
     */
    public function updateAsin(?string $asin): void
    {
        $this->asin = $asin;
    }

    /**
     * @param string|null $publish_date
     */
    public function updatePublishDate(?string $publish_date): void
    {
        $this->publish_date = $publish_date;
    }

    /**
     * @param string|null $evaluation
     */
    public function updateEvaluation(?string $evaluation): void
    {
        $this->evaluation = $evaluation;
    }

    /**
     * @param string|null $best_seller_rank
     */
    public function updateBestSellerRank(?string $best_seller_rank): void
    {
        $this->best_seller_rank = $best_seller_rank;
    }

    public function updateLinkMoreProduct(?string $link_more_product): void
    {
        $this->link_more_product = $link_more_product;
    }

    public function updateCategories(?string $categories): void
    {
        $this->categories = $categories;
    }

    public function updateConcurrentProducts(array $products) {
        $this->concurrentProduct = $products;
    }

    public function updateImages(array $images) {
        $this->images = $images;
    }

    public function updateRelatedProducts(array $products) {
        $this->relatedProducts = $products;
    }

    public function updateBoughtTogether(array $products) {
        $this->productBoughtTogether = $products;
    }

    /**
     * @return string
     */
    public function getDescriptionHtml(): ?string
    {
        return $this->descriptionHtml;
    }

    /**
     * @return string|null
     */
    public function getCurrency(): ?string
    {
        return $this->currency;
    }

    /**
     * @return string
     */
    public function getAsin(): string
    {
        return $this->asin;
    }

    /**
     * @return string|null
     */
    public function getPublishDate(): ?string
    {
        return $this->publish_date;
    }

    /**le t
     * @return string|null
     */
    public function getEvaluation(): ?string
    {
        return $this->evaluation;
    }

    /**
     * @return string|null
     */
    public function getBestSellerRank(): ?string
    {
        return $this->best_seller_rank;
    }

    /**
     * @return string|null
     */
    public function getLinkMoreProduct(): ?string
    {
        return $this->link_more_product;
    }

    /**
     * @return string|null
     */
    public function getCategories(): ?string
    {
        return $this->categories;
    }

    /**
     * @return array
     */
    public function getConcurrentProduct(): array
    {
        return $this->concurrentProduct;
    }

    /**
     * @return array
     */
    public function getImages(): array
    {
        return $this->images;
    }

    /**
     * @return array
     */
    public function getRelatedProducts(): array
    {
        return $this->relatedProducts;
    }

    /**
     * @return array
     */
    public function getProductBoughtTogether(): array
    {
        return $this->productBoughtTogether;
    }



    private function validateProductData(): void
    {
        if (
            $this->title == '' ||
            $this->description == '' ||
            $this->uuid == '' ||
            $this->saler_by == '' ||
            $this->sender_on_store == '' ||
            $this->price == ''
        ) {
            throw new ErrorSaveProductArgumentsException('Tous les paramètres du produit ne sont pas renseigné');
        }
    }

}
