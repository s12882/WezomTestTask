<?php

namespace App\Console\Commands;

use App\Exceptions\ExternalApiException;
use App\Models\Brand;
use App\Models\CarModel;
use App\Services\ExternalApiService;
use Illuminate\Console\Command;

class UpdateBrandsAndModels extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-cars-base';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
     * @throws ExternalApiException
     */
    public function handle()
    {
        $manufacturers = ExternalApiService::getAllManufacturers();

        $manufacturers->each(function ($item, $key) {
            $brand = Brand::findOrNew($item->Make_ID);
            $brand->name = $item->Make_Name;
            if ($brand->save()) {
                ExternalApiService::getModels($brand->id)->each(function ($item, $key) use ($brand) {
                    $model = CarModel::findOrNew($item->Model_ID);
                    $model->name = $item->Model_Name;
                    $model->brand()->associate($brand);
                });
            }
        });
    }
}
