<?php

namespace App\Http\Controllers;

use App\Exceptions\ExternalApiException;
use App\Exports\CarExport;
use App\Http\Requests\CarCreateRequest;
use App\Http\Requests\CarEditRequest;
use App\Models\Car;
use App\Services\CarService;
use App\Services\ExternalApiService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Throwable;

class CarController extends Controller
{
    /**
     * @var CarService
     */
    private $modelService;

    /**
     * CarController constructor.
     * @param CarService $carService
     */
    function __construct(CarService $carService)
    {
        $this->modelService = $carService;
    }

    /**
     * @return JsonResponse
     */
    function index()
    {
        $cars = $this->modelService->filter()->order()->query();
        $cars = $cars->paginate();

        return response()->json(['status' => true, 'cars' => $cars], 200);
    }

    /**
     * @param CarCreateRequest $request
     * @return JsonResponse
     */
    function create(CarCreateRequest $request)
    {
        $car = new Car();
        $car->fill($request->all());

        if ($car->save()) {
            return response()->json(['status' => true, 'message' => __('messages.car_created')], 200);
        } else {
            return response()->json(['status' => false, 'message' => __('messages.error_adding_car')], 200);
        }
    }

    /**
     * @param CarEditRequest $request
     * @param $id
     * @return JsonResponse
     */
    function edit(CarEditRequest $request, $id)
    {
        try {
            $car = Car::findOrFail($id);

            if ($car->update($request->all())) {
                return response()->json(['status' => true, 'message' => __('messages.car_updated')], 200);
            } else {
                return response()->json(['status' => false, 'message' => __('messages.error_updating_car')], 200);
            }
        } catch (Throwable $exception) {
            return response()->json(['status' => false, 'message' => $exception->getMessage()], 404);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    function remove($id)
    {
        try {
            $car = Car::findOrFail($id);
            $car->delete();

            return response()->json(['status' => true, 'message' => __('messages.car_deleted')], 200);
        } catch (Throwable $exception) {
            logger($exception->getMessage());
            return response()->json(['status' => false, 'message' => __('messages.error_deleting_car').'. '.$exception->getMessage()], 500);
        }
    }

    /**
     * @return BinaryFileResponse
     */
    function export()
    {
        $cars = $this->modelService->filter()->order()->query()->get();

        return Excel::download(new CarExport($cars), 'cars.xlsx');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ExternalApiException
     */
    function models(Request $request)
    {
        $manufacturer = ExternalApiService::getManufacturer($request->get('brand'));

        if ($manufacturer) {
            $models = ExternalApiService::getModels($manufacturer->Make_ID)->pluck('Model_Name');

            return response()->json(['status' => true, 'brand' => $manufacturer->Make_Name, 'models' => $models], 200);
        }

        return response()->json(['status' => false], 200);
    }
}
