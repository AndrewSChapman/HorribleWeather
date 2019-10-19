<?php

namespace Tests\Unit\Domains\Location\Action;

use App\Domains\Location\Action\SaveLocationAction;
use App\Testing\UnitTest;
use Illuminate\Http\JsonResponse;

class SaveLocationActionTest extends UnitTest
{
    /**
     * SCENARIO: Given I invoke the SaveLocationAction,
     * AND I ensure a valid location name is provided as a POST parameter
     * AND I call saveLocation
     * THEN I will receive a 200 response
     */
    public function testSaveLocationActionWillReturn200IfLocationValid(): void
    {
        $request = $this->getDataHelper()->getMockRequest($this);
        $request->expects($this->once())->method('post')->willReturn('Brighton,uk');

        $locationPersister = $this->getDataHelper()->location()->getLocationPersister($this);
        $locationPersister->expects($this->once())->method('persistLocation');

        $action = new SaveLocationAction($request, $locationPersister);
        $response = $action->saveLocation();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

    /**
     * SCENARIO: Given I invoke the SaveLocationAction,
     * AND a valid location name is not provided as a POST parameter
     * AND I call saveLocation
     * THEN I will receive a 400 response
     */
    public function testSaveLocationActionWillReturn400IfLocationInvalid(): void
    {
        $request = $this->getDataHelper()->getMockRequest($this);
        $request->expects($this->once())->method('post')->willReturn('');

        $locationPersister = $this->getDataHelper()->location()->getLocationPersister($this);

        $action = new SaveLocationAction($request, $locationPersister);
        $response = $action->saveLocation();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->status());

        $responseArray = $response->getData(true);
        $this->assertArrayHasKey('error', $responseArray);
    }
}
