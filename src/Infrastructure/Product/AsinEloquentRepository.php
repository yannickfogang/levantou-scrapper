<?php

namespace Module\Infrastructure\Product;

use Module\Domain\Product\Asin;
use Module\Domain\Product\AsinRepository;

class AsinEloquentRepository implements AsinRepository
{

    public function save(Asin $asin): bool
    {
        \App\Models\Asin::create(
            [
                'uuid' => $asin->getUuid(),
                'asin' => $asin->getAsin()
            ]
        );
        return true;
    }

    /**
     * @param string $asin
     * @return Asin|null
     */
    public function getByAsin(string $asin): ?Asin
    {
        $eAsin = \App\Models\Asin::whereAsin($asin)->first();
        if (!$eAsin) {
            return null;
        }
        return Asin::create($eAsin->uuid, $eAsin->asin);
    }

}
