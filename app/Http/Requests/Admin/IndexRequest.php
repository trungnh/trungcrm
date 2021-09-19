<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use Illuminate\Validation\Validator;

/**
 * Class IndexRequest
 * @package App\Http\Requests\Admin
 */
class IndexRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'text' => 'in:0,1',
        ];
    }
}
