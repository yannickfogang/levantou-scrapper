<?php

namespace Module\Application\Product\Asin\save;

use Module\Domain\Product\Asin;
use Module\Domain\Product\AsinRepository;
use Module\Domain\Product\Exception\AsinAlreadyExistException;

class SaveAsinHandler
{

    private AsinRepository $asinRepository;

    public function __construct(AsinRepository $asinRepository)
    {
        $this->asinRepository = $asinRepository;
    }

    /**
     * @param SaveAsinCommand $command
     * @return SaveAsinResponse
     * @throws AsinAlreadyExistException
     */
    public function __invoke(SaveAsinCommand $command): SaveAsinResponse
    {
        $response = new SaveAsinResponse();

        $asin = $this->asinRepository->getByAsin($command->asin);

        if($asin) {
            throw new AsinAlreadyExistException("Ce produit Asin a été déjà enregistré");
        }

        $asin = Asin::create($command->uuid, $command->asin);
        $isSave = $this->asinRepository->save($asin);

        if ($isSave) {
            $response->isSave = true;
            $response->asin = $asin;
        }
        return $response;
    }

}
