<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromView;

class CarExport implements FromView
{
    /**
     * @var Collection
     */
    private $collection;

    /**
     * CarExport constructor.
     * @param Collection $collection
     */
    function __construct(Collection $collection)
    {
        $this->collection = $collection;
    }
    /**
     * @return View
     */
    public function view(): View
    {
        return view('exports.cars', [
            'cars' => $this->collection
        ]);
    }
}
