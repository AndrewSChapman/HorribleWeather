<?php
namespace App\Testing\UnitTestDataHelper;

use App\Domains\Weather\Collection\WeatherItemCollection;
use App\Domains\Weather\Entity\WeatherItem;
use App\Domains\Weather\Enum\WeatherType;
use App\Domains\Weather\Repository\WeatherItemRepositoryInterface;
use App\Domains\Location\Type\LocationId;
use App\Domains\Weather\Service\WeatherPersister\WeatherPersisterInterface;
use App\Domains\Weather\Type\Temperature;
use App\Domains\Weather\Type\WeatherDescription;
use App\Domains\Weather\Type\WeatherIcon;
use App\Domains\Weather\Type\WeatherItemId;
use App\Domains\Weather\Type\WindSpeed;
use App\Testing\UnitTest;
use App\Testing\UnitTestDataHelper\Factory\LocationDataFactory;
use Illuminate\Http\Request;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class UnitTestDataHelper
{
    /** @var LocationDataFactory */
    private $locationDataFactory;

    /**
     * @param TestCase $testCase
     * @return Request|MockObject
     */
    public function getMockRequest(TestCase $testCase): Request
    {
        $request = $testCase->getMockBuilder(Request::class)
            ->disableOriginalConstructor()
            ->getMock();

        return $request;
    }

    public function location(): LocationDataFactory
    {
        if (!isset($this->locationDataFactory)) {
            $this->locationDataFactory = new LocationDataFactory();
        }

        return $this->locationDataFactory;
    }

    public function getWeatherItem(?LocationId $locationId = null): WeatherItem
    {
        $id = new WeatherItemId('', true);

        if (null === $locationId) {
            $locationId = new LocationId('', true);
        }

        $weatherType = new WeatherType(WeatherType::Rain);
        $weatherDescription = new WeatherDescription('Light rain');
        $temperature = new Temperature(11.5);
        $windSpeed = new WindSpeed(0.5);
        $weatherIcon = new WeatherIcon('09d');

        $weatherItem = new WeatherItem(
            $id,
            $locationId,
            $weatherType,
            $weatherDescription,
            $temperature,
            $windSpeed,
            $weatherIcon
        );

        return $weatherItem;
    }

    public function getWeatherItemCollection(int $numWeatherItems = 1): WeatherItemCollection
    {
        $weatherItemCollection = new WeatherItemCollection();

        for ($counter = 1; $counter <= $numWeatherItems; $counter++) {
            $weatherItemCollection->add($this->getWeatherItem());
        }

        return $weatherItemCollection;
    }

    /**
     * @return WeatherItemRepositoryInterface|MockObject
     */
    public function getWeatherItemRepository(UnitTest $testCase): WeatherItemRepositoryInterface
    {
        $repository = $testCase->getMockBuilder(WeatherItemRepositoryInterface::class)
            ->getMock();

        return $repository;
    }

    /**
     * @return WeatherPersisterInterface|MockObject
     */
    public function getWeatherPersister(UnitTest $testCase): WeatherPersisterInterface
    {
        $repository = $testCase->getMockBuilder(WeatherPersisterInterface::class)
            ->getMock();

        return $repository;
    }
}
