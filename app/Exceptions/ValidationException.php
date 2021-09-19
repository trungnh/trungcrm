<?php

namespace App\Exceptions;


class ValidationException extends \Exception
{
    /**
     * @var array
     */
    protected $errors;

    /**
     * ValidationException constructor.
     * @param array $errors
     */
    public function __construct($errors)
    {
        parent::__construct('The given data was invalid.');

        $this->errors = $errors;
    }

    /**
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
