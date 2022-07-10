<?php

namespace Tests\Unit\AsinData\Builder;

use Module\Application\Product\Command\SaveProductCommand;

class SaveProductCommandBuild extends SaveProductCommand
{

    public string $uuid = '123456';
    public string $title = 'Light my Fire';
    public string $description = 'A VERY PRACTICAL FLINT FIRE STARTER - The flint striker allows you to easily';
    public float $price = 20;
    public string $sender_on_store = 'teste';
    public string $saler_by = 'teste';

    public static function asProduct(): static
    {
        return new static();
    }

    public function withUuid(string $uuid): static
    {
        $this->uuid = $uuid;
        return $this;
    }

    public function withTitle(string $title): static
    {
        $this->title = $title;
        return $this;
    }

    public function withDescription(string $description): static
    {
        $this->description = $description;
        return $this;
    }

    public function withPrice(float $price): static
    {
        $this->price = $price;
        return $this;
    }

    public function withSenderOnStore(string $senderOnStore): static
    {
        $this->sender_on_store = $senderOnStore;
        return $this;
    }

    public function withSalerBy(string $saler_by): static
    {
        $this->saler_by = $saler_by;
        return $this;
    }

    public function build(): SaveProductCommand
    {
        $saveProductCommand = new SaveProductCommand();
        $saveProductCommand->price = $this->price;
        $saveProductCommand->sender_on_store = $this->sender_on_store;
        $saveProductCommand->saler_by = $this->saler_by;
        $saveProductCommand->title = $this->title;
        $saveProductCommand->description = $this->description;
        $saveProductCommand->uuid = $this->uuid;
        return $saveProductCommand;
    }
}
