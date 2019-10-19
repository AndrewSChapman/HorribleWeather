<?php

namespace Tests\Unit\Domains\Location\Action;

use App\Domains\Location\Action\CheckLocationAction;
use App\Domains\Location\Enum\LocationRequestError;
use App\Testing\UnitTest;
use Illuminate\Http\JsonResponse;

class CheckLocationActionTest extends UnitTest
{
    /**
     * SCENARIO: Given I invoke the CheckLocationAction,
     * AND I ensure a valid location name is provided as a get parameter
     * THEN I will receive a 200 response
     * AND I will see a weather item returned
     */
    public function testLocationCheckerWillReturnWeatherItemIfLocationValid(): void
    {
        $request = $this->getDataHelper()->getMockRequest($this);
        $request->expects($this->once())->method('get')->willReturn('Brighton,uk');

        $locationChecker = $this->getDataHelper()->location()->getLocationChecker($this);
        $locationChecker->expects($this->once())->method('tryLocation')->willReturn($this->getDataHelper()->getWeatherItem());

        $action = new CheckLocationAction($request, $locationChecker);
        $response = $action->checkLocation();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());

        $responseArray = $response->getData(true);
        $this->assertArrayHasKey('temperature', $responseArray);
    }

    /**
     * SCENARIO: Given I invoke the CheckLocationAction,
     * AND I do not provide a valid location name as a get parameter
     * THEN I will receive a 400 response
     */
    public function testLocationCheckerWillReturn400IfLocationInvalid(): void
    {
        $request = $this->getDataHelper()->getMockRequest($this);
        $request->expects($this->once())->method('get')->willReturn('Blerg,uk');

        $locationChecker = $this->getDataHelper()->location()->getLocationChecker($this);
        $locationChecker->expects($this->once())->method('tryLocation')->willReturn(null);

        $action = new CheckLocationAction($request, $locationChecker);
        $response = $action->checkLocation();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->status());

        $responseArray = $response->getData(true);
        $this->assertArrayHasKey('error', $responseArray);
        $this->assertEquals(LocationRequestError::INVALID_LOCATION_NAME, $responseArray['error']);
    }

    /**
     * SCENARIO: Given I invoke the CheckLocationAction,
     * AND I do not provide a valid location name as a get parameter
     * THEN I will receive a 400 response
     */
    public function testLocationCheckerWillReturn400IfLocationNotProvided(): void
    {
        $request = $this->getDataHelper()->getMockRequest($this);
        $request->expects($this->once())->method('get')->willReturn(null);

        $locationChecker = $this->getDataHelper()->location()->getLocationChecker($this);

        $action = new CheckLocationAction($request, $locationChecker);
        $response = $action->checkLocation();

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(400, $response->status());
    }
}
