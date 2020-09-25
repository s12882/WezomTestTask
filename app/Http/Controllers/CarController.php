<?php

namespace App\Http\Controllers;

use App\Http\Requests\CarCreateRequest;
use App\Http\Requests\CarEditRequest;
use App\Models\Car;
use App\Services\CarService;
use Illuminate\Http\JsonResponse;
use Throwable;

class CarController extends Controller
{
    /**
     * @var Car
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
            return response()->json(['status' => true, 'message' => __('Car was successfully added to base')], 200);
        } else {
            return response()->json(['status' => false, 'message' => __('Error occurred while adding car to base')], 200);
        }
    }

    /**
     * @param CarEditRequest $request
     * @param $id
     * @return JsonResponse
     */
    function edit(CarEditRequest $request, $id)
    {
        $car = Car::findOrFail($id);

        if ($car->update($request->all())) {
            return response()->json(['status' => true, 'message' => __('Car info was successfully changed')], 200);
        } else {
            return response()->json(['status' => false, 'message' => __('Error occurred while changing car info')], 200);
        }
    }

    /**
     * @param $id
     * @return JsonResponse
     */
    function remove($id)
    {
        $car = Car::findOrFail($id);

        try {
            $car->delete();

            return response()->json(['status' => true, 'message' => __('Car info was successfully deleted')], 200);
        } catch (Throwable $exception) {
            logger($exception->getMessage());
            return response()->json(['status' => false, 'message' => __('Error occurred while deleting car info')], 500);
        }
    }

    /**
     * @return JsonResponse
     */
    function models()
    {
        $brand = $this->modelService->filter()->query()->pluck('brand')->first();
        $models = $this->modelService->query()->pluck('model');

        return response()->json(['status' => true, 'brand' => $brand, 'models' => $models], 200);
    }
}
