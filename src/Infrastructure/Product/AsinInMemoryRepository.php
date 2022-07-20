<?php

namespace Module\Infrastructure\Product;

use Module\Domain\Product\Asin;
use Module\Domain\Product\AsinRepository;

class AsinInMemoryRepository implements AsinRepository
{

    /**
     * @var array<int, Asin>
     */
    private array $asins;

    public function save(Asin $asin): bool
    {
        $this->asins[] = $asin;
        return true;
    }

    public function getByAsin(string $asin): ?Asin
    {
        if(empty($this->asins)) {
            return null;
        }
        $exist = array_filter($this->asins, fn($a) => $a->getAsin() === $asin);
        if (empty($exist)) {
            return null;
        }
        return $exist[0];
    }
}
