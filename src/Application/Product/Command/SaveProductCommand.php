<?php

namespace Module\Application\Product\Command;

class SaveProductCommand
{

    public string $uuid;
    public string $title;
    public string $description;
    public float $price;
    public string $sender_on_store;
    public string $saler_by;
}
