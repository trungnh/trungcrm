<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use Illuminate\Validation\Validator;

/**
 * Class CustomerRequest
 * @package App\Http\Requests\Admin
 */
class CustomerRequest extends Request
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
