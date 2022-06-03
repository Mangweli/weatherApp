<?php

namespace App\Console\Commands;

use App\Repositories\Interfaces\CityInterface;
use App\Repositories\Interfaces\DailyForecastInterface;
use Carbon\Carbon;
use Illuminate\Console\Command;
use App\Traits\UtilityFunctions;

class DailyForecastCommand extends Command
{
    use UtilityFunctions;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'forecast:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Retrieves, updates and process daily weather forecast 4 times a day';

    private DailyForecastInterface $dailyForecastRepository;
    private CityInterface $cityRepository;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(DailyForecastInterface $dailyForecastRepository, CityInterface $cityRepository)
    {
        $this->dailyForecastRepository = $dailyForecastRepository;
        $this->cityRepository          = $cityRepository;

        parent::__construct();
    }

    public function handle()
    {
        $cities       = $this->cityRepository->getSystemCities();
        $this->getDailyForecast($cities, strtotime(Carbon::today()));
    }
}
