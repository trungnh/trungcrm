<?php

namespace App\Http\Requests\Admin;

use App\Http\Requests\Request;
use Illuminate\Validation\Validator;

/**
 * Class ProductRequest
 * @package App\Http\Requests\Admin
 */
class ReportRequest extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'month' => 'required|string',
            'product_id' => 'required|int',
            'source' => 'required|string',
        ];
    }
}
