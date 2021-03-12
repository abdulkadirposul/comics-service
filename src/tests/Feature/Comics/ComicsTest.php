<?php

namespace Tests\Feature\Comics;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ComicsTest extends TestCase
{
    /**
     * A test to check if there are 20 pieces of comics when no params is provided
     *
     * @return void
     */
    public function test_request_has_no_params()
    {
        $response = $this->get('/api/comics');

        $response->assertStatus(200);
        $response->assertJsonCount(20);
    }

    /**
     * A test to check if structure of response is [{'picture_url','title','description','web_url','publishing_date'}]
     */
    public function test_response_structure()
    {
        $response = $this->get('/api/comics');
        $response->assertJsonStructure([
            '*' => [
                'picture_url',
                'title',
                'description',
                'web_url',
                'publishing_date'
            ]
        ]);
    }

    /**
     * A test to check response length with valid paramters
     * @param $xkcdLength
     * @param $poorlyDrawLinesLength
     * @param $expectedLength
     * @dataProvider validParamsProvider
     */
    public function test_request_with_valid_params($xkcdLength, $poorlyDrawLinesLength, $expectedLength)
    {
        $params = "?xkcd_length=".$xkcdLength."&poorly_drawn_lines_length=".$poorlyDrawLinesLength;
        $response = $this->get('/api/comics'.$params);
        $response->assertStatus(200);
        $response->assertJsonCount($expectedLength);
    }

    /**
     * A test with invalid params
     * @param $xkcdLength
     * @param $poorlyDrawLinesLength
     * @dataProvider invalidParamsProvider
     */
    public function test_request_with_invalid_params($xkcdLength, $poorlyDrawLinesLength)
    {
        $params = "?xkcd_length=".$xkcdLength."&poorly_drawn_lines_length=".$poorlyDrawLinesLength;
        $response = $this->get('/api/comics'.$params);
        $response->assertStatus(422);
    }

    /**
     * @return array
     */
    public function validParamsProvider(): array
    {
        return [
            [10, 10, 20],
            [5, 5, 10],
            [1, 1, 2]
        ];
    }

    /**
     * @return array
     */
    public function invalidParamsProvider(): array
    {
        return [
            [10, -1],
            [5, 1000],
            [-2, 10],
            [1000, 10],
        ];
    }
}
