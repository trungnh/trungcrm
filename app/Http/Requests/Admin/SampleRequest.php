<?php

namespace App\Http\Requests\Admin;


use App\Http\Requests\Request;
use Illuminate\Validation\Validator;

/**
 * Class SampleRequest
 * @package App\Http\Requests\Admin
 */
class SampleRequest extends Request
{
    /**
     * Transform inputs.
     */
    public function sanitize()
    {
        $this->set('emails', explode(',', $this->emails));
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'emails' => 'Email list',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'emails' => 'required|array',
            'emails.*' => 'email',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'emails.*' => 'The :attribute must be a valid email address.',
        ];
    }

    /**
     * Append validate logic.
     *
     * @param Validator $validator
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function (Validator $validator) {
            $this->checkEmailExists($validator, $this->emails);
        });
    }

    /**
     * Check emauil exists.
     *
     * @param Validator $validator
     * @param array $emails
     */
    public function checkEmailExists(Validator $validator, array $emails)
    {
        if (!in_array('admin@test.com', $emails)) {
            $validator->errors()->add('emails', 'Email not exists!');
        }
    }
}
