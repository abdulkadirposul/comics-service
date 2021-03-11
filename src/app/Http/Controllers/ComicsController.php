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

    public function index(ComicsListRequest $request)
    {
        //remember used parameters below are always present. In ComicsListRequest it is handled
        return $this->comicsService->getList($request->input('xkcd_length'), $request->input('poorly_draw_lines_length'));
    }
}
