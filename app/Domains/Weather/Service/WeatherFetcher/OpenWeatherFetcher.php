<?php

namespace App\Domains\Weather\Service\WeatherFetcher;

use App\Domains\Weather\Adapter\OpenWeatherItemAdapter;
use App\Domains\Weather\Collection\WeatherItemCollection;
use App\Domains\Weather\Collection\WeatherLocationCollection;
use App\Domains\Weather\Exception\FailedToFetchWeatherException;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\ClientException;

class OpenWeatherFetcher implements WeatherFetcherInterface
{
    public function __construct()
    {
        $client = new Client();
    }

    public function fetchCurrentWeather(WeatherLocationCollection $weatherLocationCollection): WeatherItemCollection
    {
        $client = new Client([
            'base_uri' => 'https://api.openweathermap.org',
            'timeout'  => 2.0,
        ]);

        $openWeatherAdapter = new OpenWeatherItemAdapter();

        $collection = new WeatherItemCollection();

        foreach ($weatherLocationCollection as $weatherLocation) {
            $locationName = (string)$weatherLocation;
            $locationUri = $this->getWeatherApiUri($locationName);

            $result = $client->get($locationUri);

            if ($result->getStatusCode() !== 200) {
                throw new FailedToFetchWeatherException("Http request failed for location: $locationUri");
            }

            $itemJson = $result->getBody()->getContents();
            $weatherItem = $openWeatherAdapter->jsonToEntity($itemJson);
            $collection->add($weatherItem);
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
