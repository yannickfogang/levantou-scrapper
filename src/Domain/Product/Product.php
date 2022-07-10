<?php

namespace Module\Domain\Product;

use Ramsey\Uuid\Uuid;

class Product
{
    private ?string $uuid;
    private string $title;
    private string $description;
    private float $price;
    private string $saler_by;
    private string $sender_on_store;

    private function __construct(?string $uuid) {
        if ($uuid) {
            $this->uuid = $uuid;
        } else {
            $this->uuid = Uuid::uuid4()->toString();
        }
    }

    /**
     * @throws ErrorSaveProductArgumentsException
     */
    public static function create(
        string $uuid,
        string $title,
        string $description,
        float $price,
        string $saler_by,
        string $sender_on_store
    ): static
    {
        $self = new static($uuid);
        $self->uuid = $uuid;
        $self->title = $title;
        $self->description = $description;
        $self->price = $price;
        $self->saler_by = $saler_by;
        $self->sender_on_store = $sender_on_store;

        $self->validateProductData();

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
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return string
     */
    public function getSalerBy(): string
    {
        return $this->saler_by;
    }

    /**
     * @return string
     */
    public function getSenderOnStore(): string
    {
        return $this->sender_on_store;
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
