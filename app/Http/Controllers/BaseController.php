<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class BaseController extends Controller
{
    public function trending_languages()
    {
        $createdAfterDate = Carbon::now()->subDays(30);
        //Make the API call to GitHub
        $response = Http::get('https://api.github.com/search/repositories', [
            'q' => 'created:>' . $createdAfterDate->format('Y-m-d'),
            'sort' => 'stars',
            'order' => 'desc',
            'per_page' => 100,
        ]);
        //check if the call failed
        if ($response->failed()) {
            return response()->json([
                'success' => false,
            ]);
        }
        //Do some transformation to the result
        //Get items
        $languages = collect($response->collect()->get('items'))
            //Group them with the language, and get only repo's name & url
            ->mapToGroups(function ($item) {
                return [
                    $item['language'] => [
                        'name' => $item['full_name'],
                        'url' => $item['html_url'],
                    ]
                ];
            })
            //Map grouped items to get its count (repos count) & convert repos' collection to array
            ->map(function ($item) {
                return [
                    'count' => $item->count(),
                    'repos' => $item->toArray()
                ];
            })
            //Reject empty/null keyed items (No language)
            ->reject(function ($item, $key) {
                return empty($key);
            });
        //return the results
        return response()->json([
            'success' => true,
            'languages' => $languages
        ]);
    }
}
