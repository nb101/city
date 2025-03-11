<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\CityAnswerRequest;
use App\Services\CountryCityService;
use Illuminate\Http\Request;
use \Illuminate\Http\JsonResponse;

class CityAnswersController extends Controller
{
    protected CountryCityService $countryCityService;

    public function __construct(CountryCityService $countryCityService)
    {
        $this->countryCityService = $countryCityService;
    }

    /**
     * Handle the incoming request.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function __invoke(CityAnswerRequest $request) : JsonResponse
    {
        $country = $request->input('country');
        $capital = $request->input('capital');

        try {
            $data =  $this->countryCityService->fetchData();

            foreach ($data as $item) {
                if ($item['name'] === $country) {
                    $correctCapital = $item['capital'];
                    if ($capital === $correctCapital) {
                        return response()->json(['correct' => true]);
                    } else {
                        return response()->json(['correct' => false, 'correct_capital' => $correctCapital]);
                    }
                }
            }

            return response()->json(['correct' => false]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

}
