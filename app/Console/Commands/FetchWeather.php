<?php
namespace App\Console\Commands;

use App\Domains\Location\Service\LocationLister\LocationListerInterface;
use App\Domains\Weather\Collection\WeatherItemCollection;
use App\Domains\Weather\Service\WeatherFetcher\WeatherFetcherInterface;
use App\Domains\Weather\Service\WeatherPersister\WeatherPersisterInterface;
use Illuminate\Console\Command;

class FetchWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:weather';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetches the current weather from the OpenWeatherMap service and stores the results';

    /** @var LocationListerInterface */
    private $locationLister;

    /** @var WeatherFetcherInterface */
    private $weatherFetcher;

    /** @var WeatherPersisterInterface */
    private $weatherPersister;

    public function __construct(
        LocationListerInterface $locationLister,
        WeatherFetcherInterface $weatherFetcher,
        WeatherPersisterInterface $weatherPersister
    ) {
        parent::__construct();

        $this->locationLister = $locationLister;
        $this->weatherFetcher = $weatherFetcher;
        $this->weatherPersister = $weatherPersister;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(): void
    {
        $this->weatherPersister->persistWeatherItems($this->loadCurrentWeather());
    }

    private function loadCurrentWeather(): WeatherItemCollection
    {
        $this->info('Loading weather.');

        // Define the locations that we want to load the weather for.
        $locations = $this->locationLister->getList();

        // Fetch the weather
        $items = $this->weatherFetcher->fetchCurrentWeather($locations);

        return $items;
    }
}
