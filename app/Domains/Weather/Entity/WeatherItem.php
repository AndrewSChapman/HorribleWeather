<?php

namespace App\Domains\Weather\Entity;

use App\Core\Interfaces\Serialisable;
use App\Core\Type\CreatedAt;
use App\Core\Type\UpdatedAt;
use App\Domains\Location\Type\LocationName;
use App\Domains\Weather\Enum\WeatherType;
use App\Domains\Location\Type\LocationId;
use App\Domains\Weather\Type\Temperature;
use App\Domains\Weather\Type\WeatherDescription;
use App\Domains\Weather\Type\WeatherIcon;
use App\Domains\Weather\Type\WeatherItemId;
use App\Domains\Weather\Type\WindSpeed;

class WeatherItem implements Serialisable
{
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

    public function toArray(): array
    {
        return [
            'id' => $this->getId()->getUuid()->toString(),
            'createdAt' => $this->getCreatedAt()->getTimestamp(),
            'updatedAt' => $this->getUpdatedAt()->getTimestamp(),
            'type' => (string)$this->getType(),
            'locationId' => (string)$this->getLocationId(),
            'locationName' => $this->locationName !== null ? $this->locationName->toString() : '',
            'description' => $this->getDescription()->toString(),
            'temperature' => $this->getTemperature()->getValue(),
            'wind_speed' => $this->getWindSpeed()->getValue(),
        ];
    }
}
