<?php

namespace App\Domains\Weather\Service\WeatherFetcher;

use App\Core\Type\Timestamp;
use App\Domains\Location\Exception\InvalidLocationException;
use App\Domains\Weather\Adapter\OpenWeatherItemAdapter;
use App\Domains\Weather\Collection\WeatherItemCollection;
use App\Domains\Location\Collection\LocationEntityCollection;
use App\Domains\Weather\Exception\FailedToFetchWeatherException;
use GuzzleHttp\Client;

class OpenWeatherFetcher implements WeatherFetcherInterface
{
    /**
     * Fetches the current weather from the OpenWeather API for the specified locations
     * and returns the weather in a WeatherItemCollection
     * @param LocationEntityCollection $weatherLocationCollection
     * @return WeatherItemCollection
     * @throws \ReflectionException
     */
    public function fetchCurrentWeather(LocationEntityCollection $weatherLocationCollection): WeatherItemCollection
    {
        $client = new Client([
            'base_uri' => 'https://api.openweathermap.org',
            'timeout'  => 2.0,
        ]);

        $openWeatherAdapter = new OpenWeatherItemAdapter();

        $collection = new WeatherItemCollection();
        $now = new Timestamp();

        foreach ($weatherLocationCollection as $weatherLocation) {
            $locationUri = $this->getWeatherApiUri($weatherLocation->getLocationName()->toString());

            try {
                $result = $client->get($locationUri);

                if ($result->getStatusCode() !== 200) {
                    throw new FailedToFetchWeatherException("Http request failed for location: $locationUri");
                }

                $itemJson = $result->getBody()->getContents();
                $weatherItem = $openWeatherAdapter->jsonToEntity($weatherLocation->getId(), $itemJson, $now);
                $collection->add($weatherItem);
            } catch (\Exception $exception) {
                throw new InvalidLocationException($weatherLocation->getLocationName());
            }
        }

        return $collection;
    }

    /**
     * @param string $location e.g. Brighton,uk
     * @return string
     */
    private function getWeatherApiUri(string $location): string
    {
        return "/data/2.5/weather?q=$location&appid=c276dab50e780ea9bd25ef280a1c30bc&units=metric";
    }
}
