<?php

namespace App\Http\Middleware;

use App\Http\Requests\CarCreateRequest;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProceedVin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $validator = Validator::make($request->all(), [
            'vin_code' => 'required|size:17',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => false, 'errors' => $validator->messages()], 200);
        }

        $request->merge($this->proceed($request->post('vin_code')));

        return $next($request);
    }

    private function proceed($vin)
    {
        $json = json_decode(file_get_contents('https://vpic.nhtsa.dot.gov/api/vehicles/decodevin/'.$vin.'?format=json&model'))->Results;

        return [
            'brand' => $json[6]->Value,
            'model' => $json[8]->Value,
            'year' => $json[9]->Value
        ];
    }
}
