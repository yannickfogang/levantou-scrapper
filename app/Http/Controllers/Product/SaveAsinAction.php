<?php

namespace App\Http\Controllers\Product;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Module\Application\Product\Asin\save\SaveAsinCommand;
use Module\Application\Product\Asin\save\SaveAsinHandler;
use Module\Domain\Product\Exception\AsinAlreadyExistException;

class SaveAsinAction
{

    /**
     * @param Request $request
     * @param SaveAsinHandler $handler
     * @return JsonResponse
     */
    public function __invoke(
        Request $request,
        SaveAsinHandler $handler
    ): JsonResponse
    {
        $asinCommand = new SaveAsinCommand();
        $asinCommand->asin = $request->get('asin');
        $asinCommand->uuid = $request->get('uuid');

        try  {
            $response = $handler->__invoke($asinCommand);
            if ($response->isSave) {
                return response()->json(['isSave' => $response->isSave, ['asin' => $response->asin->getAsin(), 'uuid' => $response->asin->getUuid()]]);
            }
        } catch (AsinAlreadyExistException $e) {}

        return response()->json(['isSave' => false]);
    }
}
