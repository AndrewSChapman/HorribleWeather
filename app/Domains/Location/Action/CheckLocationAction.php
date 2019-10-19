<?php

namespace App\Domains\Location\Action;

use App\Domains\Location\Enum\LocationRequestError;
use App\Domains\Location\Service\LocationChecker\LocationCheckerInterface;
use App\Domains\Location\Type\LocationName;
use App\Http\Actions\BaseAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CheckLocationAction extends BaseAction
{
    /** @var LocationCheckerInterface */
    private $locationChecker;

    /** @var Request */
    private $request;

    public function __construct(Request $request, LocationCheckerInterface $locationChecker)
    {
        $this->request = $request;
        $this->locationChecker = $locationChecker;
    }

    public function checkLocation(): JsonResponse
    {
        try {
            $locationName = new LocationName($this->request->get('name', ''));
            $weatherItem = $this->locationChecker->tryLocation($locationName);

            if (!$weatherItem) {
                return new JsonResponse(['error' => LocationRequestError::INVALID_LOCATION_NAME], 400);
            }

            return new JsonResponse($weatherItem->toArray());
        } catch (\Exception $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 400);
        } catch (\TypeError $error) {
            return new JsonResponse(['error' => $error->getMessage()], 400);
        }
    }
}
