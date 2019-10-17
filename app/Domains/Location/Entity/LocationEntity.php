<?php

namespace App\Domains\Location\Entity;

use App\Core\Interfaces\Serialisable;
use App\Core\Type\CreatedAt;
use App\Core\Type\UpdatedAt;
use App\Domains\Location\Type\LocationId;
use App\Domains\Location\Type\LocationName;

class LocationEntity implements Serialisable
{
    /** @var LocationId */
    private $id;

    /** @var CreatedAt */
    private $createdAt;

    /** @var UpdatedAt */
    private $updatedAt;

    /** @var LocationName */
    private $location;

    public function __construct(
        LocationId $id,
        LocationName $locationName,
        CreatedAt $createdAt = null,
        UpdatedAt $updatedAt = null
    ) {
        $this->id = $id;
        $this->location = $locationName;

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

    public function getId(): LocationId
    {
        return $this->id;
    }

    public function getLocationName(): LocationName
    {
        return $this->location;
    }

    public function getCreatedAt(): CreatedAt
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): UpdatedAt
    {
        return $this->updatedAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId()->getUuid()->toString(),
            'createdAt' => $this->getCreatedAt()->getTimestamp(),
            'updatedAt' => $this->getUpdatedAt()->getTimestamp(),
            'location' => $this->getLocationName()->getValue()
        ];
    }
}
