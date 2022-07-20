<?php

namespace Module\Application\Product\Asin\save;

use Module\Domain\Product\Asin;

class SaveAsinResponse
{
    public bool $isSave = false;
    public ?Asin $asin = null;
}
