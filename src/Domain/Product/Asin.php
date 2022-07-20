<?php

namespace Module\Domain\Product;

use Ramsey\Uuid\Uuid;

class Asin
{
    private string $asin;
    private string $uuid;

    private function __construct(string $uuid, string $asin) {
        $this->asin = $asin;
        $this->uuid = $uuid;
    }

    /**
     * @param ?string $uuid
     * @param string $asin
     * @return static
     */
    public static function create(?string $uuid, string $asin): static
    {
        $uuid = $uuid ?? Uuid::uuid4()->toString();
        $self = new static($uuid, $asin);
        return $self;
    }

    /**
     * @return string
     */
    public function getAsin(): string
    {
        return $this->asin;
    }

    /**
     * @return string
     */
    public function getUuid(): string
    {
        return $this->uuid;
    }
}
