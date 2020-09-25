<?php

namespace App\Http\Middleware;

use App\Services\ExternalApiService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProceedVin
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
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

        $request->merge(ExternalApiService::getCarByVin($request->post('vin_code')));

        return $next($request);
    }
}
