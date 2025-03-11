<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\CountryCityService;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use \Illuminate\Http\JsonResponse;

class CityQuestionsController extends Controller
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
    public function __invoke(Request $request) : JsonResponse
    {
        try {
            $data = $this->countryCityService->fetchData();
            $question = $this->generateRandomQuestion($data);
            return response()->json($question);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    private function generateRandomQuestion($data): array
    {
        $selectedCountry = Arr::random($data);

        while (empty($selectedCountry['capital'])) {
            $selectedCountry = Arr::random($data);
        }

        $remainingCapitals = Arr::where($data, function ($value) use ($selectedCountry) {
            return $value['capital'] !== $selectedCountry['capital'] && !empty($value['capital']);
        });

        $wrongCapitals = Arr::random($remainingCapitals, 2);

        $options = [
            $selectedCountry['capital'],
            $wrongCapitals[0]['capital'],
            $wrongCapitals[1]['capital']
        ];

        shuffle($options);

        return [
            'country' => $selectedCountry['name'],
            'options' => $options
        ];
    }
}
