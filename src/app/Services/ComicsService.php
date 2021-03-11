<?php

namespace App\Services;

use App\Services\Contracts\ComicsServiceContract;
use App\Services\Traits\HttpClientTrait;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Collection;

class ComicsService implements ComicsServiceContract
{
    use HttpClientTrait;

    /**
     * @param int $xkcdLength
     * @param int $poorlyDrawLinesLength
     * @return Collection
     * @throws AuthorizationException
     */
    public function getList(int $xkcdLength, int $poorlyDrawLinesLength): Collection
    {
        $collection = collect($this->getXKCDComics($xkcdLength));
        return $collection->merge($this->getPoorlyDrawLines($poorlyDrawLinesLength));
    }

    /**
     * @param int $xkcdLength
     * @return array
     * @throws AuthorizationException
     */
    private function getXKCDComics(int $xkcdLength): array
    {
        $this->setBaseUrl(config('config.xkcd_url'));

        //get latest comics and make inspiration from it's content
        $currentComics = $this->httpGet("info.0.json");

        if (!isset($currentComics->num)) {
            return [];
        }

        $currentNum = $currentComics->num;
        $returnArray = [];

        //make api calls as much as demanded with length
        for ($i = 0; $i < $xkcdLength; $i++) {
            $comicsCursorNum = $currentNum - $i;
            $comicsCursorUrl = "/" . $comicsCursorNum . "/info.0.json";
            $returnArray[] = $this->httpGet($comicsCursorUrl);
        }

        return $returnArray;
    }

    private function getPoorlyDrawLines(int $poorlyDrawLinesLength): array
    {
        return [];
    }
}
