<?php

namespace App\Domains\Weather\Entity;

use App\Core\Interfaces\ArraySerialisable;
use App\Core\Type\CreatedAt;
use App\Core\Type\UpdatedAt;
use App\Core\Type\WholeNumber;
use App\Domains\Location\Type\LocationName;
use App\Domains\Weather\Enum\WeatherType;
use App\Domains\Location\Type\LocationId;
use App\Domains\Weather\Type\Temperature;
use App\Domains\Weather\Type\WeatherDescription;
use App\Domains\Weather\Type\WeatherIcon;
use App\Domains\Weather\Type\WeatherItemId;
use App\Domains\Weather\Type\WindSpeed;

class WeatherItem implements ArraySerialisable
{
    private const INCREMENT_DEPLORABLE = 10;
    private const INCREMENT_TERRIBLE = 5;
    private const INCREMENT_NOT_GREAT = 3;

    /** @var WeatherItemId */
    private $id;

    /** @var CreatedAt */
    private $createdAt;

    /** @var UpdatedAt */
    private $updatedAt;

    /** @var LocationId */
    private $locationId;

    /** @var WeatherType */
    private $type;

    /** @var WeatherDescription */
    private $description;

    /** @var Temperature */
    private $temperature;

    /** @var WindSpeed */
    private $windSpeed;

    /** @var WeatherIcon */
    private $weatherIcon;

    /** @var LocationName|null */
    private $locationName;

    public function __construct(
        WeatherItemId $id,
        LocationId $locationId,
        WeatherType $type,
        WeatherDescription $description,
        Temperature $temperature,
        WindSpeed $windSpeed,
        WeatherIcon $weatherIcon,
        CreatedAt $createdAt = null,
        UpdatedAt $updatedAt = null
    ) {
        $this->id = $id;
        $this->locationId = $locationId;
        $this->type = $type;
        $this->description = $description;
        $this->temperature = $temperature;
        $this->windSpeed = $windSpeed;
        $this->weatherIcon = $weatherIcon;

        if ($createdAt instanceof CreatedAt) {
            $this->createdAt = $createdAt;
        } else {
            $this->createdAt = new CreatedAt();
        }

        if ($updatedAt instanceof UpdatedAt) {
            $this->updatedAt = $updatedAt;
        } else {
            $this->updatedAt = new UpdatedAt();
        }
    }

    public function setLocationName(LocationName $locationName): void
    {
        $this->locationName = $locationName;
    }

    public function getId(): WeatherItemId
    {
        return $this->id;
    }

    public function getLocationId(): LocationId
    {
        return $this->locationId;
    }

    public function getType(): WeatherType
    {
        return $this->type;
    }

    public function getDescription(): WeatherDescription
    {
        return $this->description;
    }

    public function getTemperature(): Temperature
    {
        return $this->temperature;
    }

    public function getWindSpeed(): WindSpeed
    {
        return $this->windSpeed;
    }

    public function getWeatherIcon(): WeatherIcon
    {
        return $this->weatherIcon;
    }

    public function getCreatedAt(): CreatedAt
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): UpdatedAt
    {
        return $this->updatedAt;
    }

    public function getLocationName(): ?LocationName
    {
        return $this->locationName;
    }

    public function getScore(): WholeNumber
    {
        $score = 0;

        /***********************
         * CONSIDER TEMPERATURE
         *********************/
        // WAAAAAY TOO COLD OR TOO HOT
        if ($this->getTemperature()->getValue() < -2) {
            $score = $score + self::INCREMENT_DEPLORABLE;
        }
        else if ($this->getTemperature()->getValue() > 36) {
            $score = $score + self::INCREMENT_DEPLORABLE;
        }

        // TOO COLD OR TOO HOT
        else if ($this->getTemperature()->getValue() < 4) {
            $score = $score + self::INCREMENT_TERRIBLE;
        }
        else if ($this->getTemperature()->getValue() > 30) {
            $score = $score + self::INCREMENT_TERRIBLE;
        }

        // A LITTLE TOO COLD OR TOO HOT
        else if ($this->getTemperature()->getValue() <= 13) {
            $score = $score + self::INCREMENT_NOT_GREAT;
        }
        else if ($this->getTemperature()->getValue() > 29) {
            $score = $score + self::INCREMENT_NOT_GREAT;
        }

        /***********************
         * CONSIDER WEATHER TYPE
         *********************/
        $deplorableWeatherTypes = [
            WeatherType::Thunderstorm,
            WeatherType::Tornado,
            WeatherType::Dust,
            WeatherType::Ash,
            WeatherType::Sand
        ];

        $terribleWeatherTypes = [
            WeatherType::Snow,
            WeatherType::Rain,
            WeatherType::Smoke,
        ];

        $notGreatWeatherTypes = [
            WeatherType::Mist,
            WeatherType::Clouds,
            WeatherType::Drizzle,
            WeatherType::Fog,
            WeatherType::Haze,
            WeatherType::Squall
        ];

        $weatherType = (string)$this->getType();

        if (in_array($weatherType, $deplorableWeatherTypes)) {
            $score += self::INCREMENT_DEPLORABLE;
        } else if (in_array($weatherType, $terribleWeatherTypes)) {
            $score += self::INCREMENT_TERRIBLE;
        } else if (in_array($weatherType, $notGreatWeatherTypes)) {
            $score += self::INCREMENT_NOT_GREAT;
        }

        /***********************
         * CONSIDER WIND SPEED
         *********************/
        if ($this->getWindSpeed()->getValue() >= 30) {
            $score += self::INCREMENT_DEPLORABLE;
        } else if ($this->getWindSpeed()->getValue() >= 20) {
            $score += self::INCREMENT_TERRIBLE;
        } else if ($this->getWindSpeed()->getValue() >= 10) {
            $score += self::INCREMENT_NOT_GREAT;
        }

        return new WholeNumber($score);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId()->getUuid()->toString(),
            'createdAt' => $this->getCreatedAt()->getTimestamp(),
            'updatedAt' => $this->getUpdatedAt()->getTimestamp(),
            'type' => (string)$this->getType(),
            'locationId' => (string)$this->getLocationId(),
            'locationName' => $this->getLocationName() !== null ? $this->getLocationName()->toString() : '',
            'description' => $this->getDescription()->toString(),
            'temperature' => $this->getTemperature()->getValue(),
            'wind_speed' => $this->getWindSpeed()->getValue(),
            'score' => $this->getScore()->getValue()
        ];
    }
}
