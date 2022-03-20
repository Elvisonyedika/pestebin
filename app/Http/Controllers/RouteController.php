<?php

namespace App\Http\Controllers;

use App\Models\RouteManager;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class RouteController extends Controller
{
    /**
     * Generate a short url from a bunch of text and return to the caller.
     * 
     * @param Request $request.
     * 
     * @return Response $response.
     */
    public function generateRoute(Request $request)
    {

        $request->validate([
            'text' => ['required']
        ]);

        $route = new RouteManager();
        $route->text = $request->input('text');
        $route->expiry_date = $request->input('expiry_date'); # date that the route can expire

        return url("/api/generated-route/" . $route->generate());
    }

    /**
     * Retrieve a text based on the url
     * 
     * @param Request $request.
     * 
     * @return Response $response.
     */
    public function retrieveData(Request $request, string $hashedUrl)
    {
        $route = RouteManager::where([
            'hashed_url' => $hashedUrl
        ])->first();

        if ($route) {

            if (!empty($route->expiry_date)) {
                $difference = Carbon::now() - $route->expiry_date;
                dd([
                    $difference, Carbon::date($difference),
                ]);
            }

            return $route->text;
        }

        return null;
    }
}
