<?php

namespace App\Domains\Location\Action;

use App\Domains\Location\Service\LocationPersister\LocationPersisterInterface;
use App\Domains\Location\Type\LocationName;
use App\Http\Actions\BaseAction;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class SaveLocationAction extends BaseAction
{
    /** @var LocationPersisterInterface */
    private $locationPersister;

    /** @var Request */
    private $request;

    public function __construct(Request $request, LocationPersisterInterface $locationPersister)
    {
        $this->request = $request;
        $this->locationPersister = $locationPersister;
    }

    public function saveLocation(): JsonResponse
    {
        try {
            $locationName = new LocationName($this->request->post('name', ''));
            $this->locationPersister->persistLocation($locationName);

            return new JsonResponse([]);
        } catch (\Exception $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], 400);
        } catch (\TypeError $error) {
            return new JsonResponse(['error' => $error->getMessage()], 400);
        }
    }
}
