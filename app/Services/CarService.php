<?php

namespace App\Services;

use App\Models\Car;
use Illuminate\Database\Eloquent\Builder;

class CarService
{
    /**
     * @var Car
     */
    private $model;

    /**
     * @var Builder
     */
    private $query;

    /**
     * @var \Illuminate\Http\Request
     */
    private $request;

    public function __construct(Car $car)
    {
        $this->model = $car;
        $this->request = request();
        $this->query = $this->model->newQuery();
    }

    /**
     * @return CarService
     */
    public function filter()
    {
        if ($this->request->has('name')) {
            $this->query->where('name', $this->request->get('name'));
        }

        if ($this->request->has('gov_number')) {
            $this->query->where('gov_number', $this->request->get('gov_number'));
        }

        if ($this->request->has('color')) {
            $this->query->where('color', $this->request->get('color'));
        }

        if ($this->request->has('brand')) {
            $this->query->where('brand', 'LIKE', $this->request->get('brand') . '%');
        }

        if ($this->request->has('model')) {
            $this->query->where('model', 'LIKE', $this->request->get('model') . '%');
        }

        if ($this->request->has('year')) {
            $this->query->where('year', $this->request->get('year'));
        }

        if ($this->request->has('vin_code')) {
            $this->query->where('vin_code', $this->request->get('vin_code'));
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function order()
    {
        if ($this->request->has('order_by')) {
            $type = $this->request->get('order_type') ?: 'DESC';
            $this->query->orderBy($this->request->get('order_by'), $type);
        }

        return $this;
    }

    public function query()
    {
        return $this->query;
    }
}
