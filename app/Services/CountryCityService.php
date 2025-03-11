<?php

namespace App\Services;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class CountryCityService
{
    public function fetchData()
    {
        return Cache::remember('countries_and_capitals', 60, function () {
            $url = config('services.countries_api.url');
            $response = Http::get($url);

            if ($response->successful()) {
                return $response->json()['data'];
            }

            throw new \Exception("Failed to retrieve data from external API.");
        });
    }
}
