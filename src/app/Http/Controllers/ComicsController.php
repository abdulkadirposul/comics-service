<?php

namespace App\Http\Controllers;

use App\Http\Requests\ComicsListRequest;

class ComicsController extends Controller
{
    public function index(ComicsListRequest $request)
    {
        return [];
    }
}
