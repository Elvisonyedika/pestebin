<?php

use App\Http\Controllers\Controller;
use App\Models\RouteManager;
use Illuminate\Http\Request;

class GeneratorController extends Controller
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

        $validated = $request->validate([
            'text' => ['required']
        ]);

        $route = new RouteManager();
        $route->text = $request->input('text');
        $route->expiry_date = $request->input('expiry_date'); # date that the route can expire

        $shortendURL = '';
        return $shortendURL;
    }
}
