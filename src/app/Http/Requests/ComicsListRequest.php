<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ComicsListRequest extends FormRequest
{
    const DEFAULT_COMICS_LENGTH = 10;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'xkcd_length' => 'int|max:30|min:0',
            'poorly_drawn_lines_length' => 'int|max:30|min:0'
        ];
    }

    protected function prepareForValidation()
    {
        if (!$this->has('xkcd_length')) {
            $this->merge([
                'xkcd_length' => self::DEFAULT_COMICS_LENGTH
            ]);
        }

        if (!$this->has('poorly_drawn_lines_length')) {
            $this->merge([
                'poorly_drawn_lines_length' => self::DEFAULT_COMICS_LENGTH
            ]);
        }
    }
}
