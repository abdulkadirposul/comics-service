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
        $currentComics = $this->httpGetObject("info.0.json");

        if (!isset($currentComics->num)) {
            return [];
        }

        $currentNum = $currentComics->num;
        $returnArray = [];

        //make api calls as much as demanded with length
        $comicsCursorNum = $currentNum;
        for ($i = 0; $i < $xkcdLength && $comicsCursorNum > 0; $i++) {
            $comicsCursorNum = $currentNum - $i;
            $comicsCursorUrl = "/" . $comicsCursorNum . "/info.0.json";

            $resultObject = $this->httpGetObject($comicsCursorUrl);
            $returnArray[] = [
                'picture_url' => $resultObject->img,
                'title' => $resultObject->title,
                'description' => $resultObject->alt,
                'web_url' => $this->getUrl($comicsCursorUrl),
                'publishing_date' => convertToDatetime($resultObject->year, $resultObject->month, $resultObject->day)
            ];
        }

        return $returnArray;
    }

    private function getPoorlyDrawLines(int $poorlyDrawLinesLength): array
    {
        $this->setBaseUrl(config('config.poorly_drawn_lines'));
        $feedContent = $this->httpGetBody("");
        $feedContent = clearXmlContent($feedContent);
        $feedContent = simplexml_load_string($feedContent);

        $cursor = $poorlyDrawLinesLength;
        $returnArray = [];

        foreach ($feedContent->channel->item as $entry) {

            if ($poorlyDrawLinesLength <= 0) {
                break;
            }

            $pictureUrl = $this->getPoorlyDrawLinesPicture($entry->contentEncoded);

            $returnArray[] = [
                'picture_url' => $pictureUrl,
                'title' => (string)$entry->title,
                'description' => (string)$entry->description,
                'web_url' => (string)$entry->guid,
                'publishing_date' => date('Y-m-d H:i:s',strtotime((string)$entry->pubDate))
            ];

            $poorlyDrawLinesLength--;
        }

        return $returnArray;
    }

    /**
     * @param $entry
     * @return string
     */
    private function getPoorlyDrawLinesPicture($entry): string
    {
        if (isset($entry->figure->a->img["src"])) {
            return (string)$entry->figure->a->img["src"];
        }

        if (isset($entry->div->figure->a->img["src"])) {
            return (string)$entry->div->figure->a->img["src"];
        }

        return "";
    }
}
