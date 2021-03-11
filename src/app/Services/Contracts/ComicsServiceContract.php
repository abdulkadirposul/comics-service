<?php

namespace App\Services\Contracts;

use Illuminate\Support\Collection;

interface ComicsServiceContract
{
    public function getList(int $xkcdLength, int $poorlyDrawLinesLength): Collection;
}
