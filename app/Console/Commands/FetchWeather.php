<?php
namespace App\Console\Commands;

use App\Domains\Weather\Collection\WeatherItemCollection;
use App\Domains\Weather\Collection\WeatherLocationCollection;
use App\Domains\Weather\Enum\WeatherLocation;
use App\Domains\Weather\Service\WeatherFetcher\OpenWeatherFetcher;
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

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->loadCurrentWeather();
    }

    private function loadCurrentWeather(): WeatherItemCollection
    {
        $this->info('Loading weather.');

        // Define the locations that we want to load the weather for.
        $locations = new WeatherLocationCollection();
        $locations->add(new WeatherLocation(WeatherLocation::Brighton));
        $locations->add(new WeatherLocation(WeatherLocation::Leeds));
        //$locations->add(new WeatherLocation(WeatherLocation::London));
        //$locations->add(new WeatherLocation(WeatherLocation::Manchester));
        //$locations->add(new WeatherLocation(WeatherLocation::RedRuth));
        //$locations->add(new WeatherLocation(WeatherLocation::Edinburgh));

        // Fetch the weather
        $service = new OpenWeatherFetcher();
        $items = $service->fetchCurrentWeather($locations);

        return $items;
    }
}
