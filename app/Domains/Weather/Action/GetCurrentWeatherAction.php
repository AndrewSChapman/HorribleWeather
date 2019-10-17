<?php

namespace App\Domains\Weather\Action;

use App\Domains\Weather\Service\CurrentWeatherLister\CurrentWeatherListerInterface;
use App\Http\Actions\BaseAction;

class GetCurrentWeatherAction extends BaseAction
{
    /** @var CurrentWeatherListerInterface */
    private $currentWeatherLister;

    public function __construct(CurrentWeatherListerInterface $currentWeatherLister)
    {
        $this->currentWeatherLister = $currentWeatherLister;
    }

    public function getCurrentWeather(): array
    {
        $currentWeatherItemArray = [];

        foreach ($this->currentWeatherLister->getCurrentWeather() as $weatherItem) {
            $currentWeatherItemArray[] = $weatherItem->toArray();
        }

        return $currentWeatherItemArray;
    }
}
