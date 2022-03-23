<?php

namespace App\Http\Controllers;

use App\Models\RouteManager;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

class RouteController extends Controller
{
    /**
     * @OA\Post(
     * path="/api/generate-route",
     * operationId="generateRoute",
     * tags={"GenerateRoute"},
     * summary="Generate Route",
     * description="Generate a short url from a bunch of text and return to the caller",
     *
     *      @OA\Parameter(
     *          name="text",
     *          in="query",
     *          required=true,
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *      @OA\Parameter(
     *          name="expiry_date",
     *          in="query",
     *          required=false,
     *          @OA\Schema(
     *              type="datetime",
     *              example="d-m-Y H:i:s"
     *          )
     *      ),
     *
     *      @OA\Response(
     *          response=201,
     *          description="Route Generated Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=200,
     *          description="Route Generated Successfully",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function generateRoute(Request $request)
    {

        $request->validate([
            'text' => ['required']
        ]);

        $route = new RouteManager();
        $route->text = $request->input('text');

        $expiry_date = $request->input('expiry_date'); # date that the route can expire
        try
        {
            if (!empty($expiry_date))
            {
                $route->expiry_date = Carbon::createFromFormat('d-m-Y H:i:s', $expiry_date);
            }
        } catch (\Exception $exception) {
            abort(503, "Invalid expiry date");
        }

        return url("/api/generated-route/" . $route->generate());
    }

    /**
     * @OA\Get(
     * path="/api/generated-route/{hashedUrl}",
     * summary="Get Route Details",
     * description="Get Route Details",
     * operationId="GetRouteDetails",
     * tags={"RouteDetails"},
     *  @OA\Parameter(
     *      description="Hashed Url",
     *      in="path",
     *      name="hashedUrl",
     *      required=true,
     *      example="faf23651e5f86b88e83508ceb1c8ca8d",
     *      @OA\Schema(
     *          type="string"
     *      )
     *  ),
     *      @OA\Response(
     *          response=200,
     *          description="Route Details Successfully Fetched",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(
     *          response=422,
     *          description="Unprocessable Entity",
     *          @OA\JsonContent()
     *       ),
     *      @OA\Response(response=400, description="Bad request"),
     *      @OA\Response(response=404, description="Resource Not Found"),
     * )
     */
    public function retrieveData(Request $request, string $hashedUrl)
    {
        $route = RouteManager::where([
            'hashed_url' => $hashedUrl
        ])->first();

        if ($route) {

            if (!empty($route->expiry_date)) {
                if (Carbon::parse($route->expiry_date)->gte(Carbon::now())) {
                    return $route->text;
                } else {
                    return null;
                }
            }

            return $route->text;
        }

        return null;
    }
}
