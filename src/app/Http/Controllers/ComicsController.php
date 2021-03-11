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
        return [];
    }
}
