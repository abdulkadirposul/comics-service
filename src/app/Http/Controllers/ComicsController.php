<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComicsListRequest;
use App\Services\Contracts\ComicsServiceContract;

class ComicsController extends Controller
{
    private ComicsServiceContract $comicsService;

    public function __construct(ComicsServiceContract $comicsService)
    {
        $this->comicsService = $comicsService;
    }

    /**
     * checkFileInfo
     * @param ComicsListRequest $request
     * @return array
     * @OA\Info(title="Comics Service Api Documentation", version="0.1")
     * @OA\Get(
     *      path="/api/comics",
     *      tags={"comics"},
     *      summary="Fetch comics from different platforms",
     *      description="Fetch comics from different platforms",
     *      operationId="comics",
     *      @OA\Parameter(name="xkcd_length", in="query", required=false, description="Expected size from XKCD",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\Parameter(name="poorly_drawn_lines_length", in="query", required=false, description="Expected size from PoorlyDrawnLines",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *
     *      @OA\Response(response=200, description="Success",
     *          @OA\JsonContent(
     *              @OA\Property(property="picture_url", type="string", format="string"),
     *              @OA\Property(property="title'", type="string", format="string"),
     *              @OA\Property(property="description", type="string", format="string"),
     *              @OA\Property(property="web_url", type="string", format="string"),
     *              @OA\Property(property="publishing_date", type="string", format="string")
     *          )
     *      ),
     *
     *     @OA\Response(response=500,description="Returns when a unexpected error is occurred"),
     *     @OA\Response(response=422,description="The given data was invalid.")
     * )
     */
    public function index(ComicsListRequest $request): array
    {
        //remember used parameters below are always present. In ComicsListRequest it is handled
        return $this->comicsService->getList($request->input('xkcd_length'), $request->input('poorly_drawn_lines_length'));
    }
}
