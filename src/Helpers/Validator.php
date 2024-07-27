<?php

namespace App\Helpers;

use App\Infra\Http\Exceptions\ValidatorException;

class Validator
{
    protected $errors = [];

    public function validate(array $fields, array $values): array
    {
        foreach ($fields as $field => $rules) {
            if (!isset($values[$field])) {
                if (isset($rules['required']) && $rules['required']) {
                    $this->errors[$field][] = "The field ({$field}) is required.";
                }

                continue;
            }

            $value = trim($values[$field]);

            foreach ($rules as $rule => $ruleValue) {
                if ($rule === 'required' && empty($value)) {
                    $this->errors[$field][] = "The field ({$field}) is required.";
                }

                if ($rule === 'type' && !$this->validateType($value, $ruleValue)) {
                    $this->errors[$field][] = "The field ({$field}) must be of type {$ruleValue}.";
                }

                if ($rule === 'min' && strlen($value) < $ruleValue) {
                    $this->errors[$field][] = "The field ({$field}) must be at least {$ruleValue} characters.";
                }

                if ($rule === 'max' && strlen($value) > $ruleValue) {
                    $this->errors[$field][] = "The field ({$field}) must be less than {$ruleValue} characters.";
                }

                if (is_callable($ruleValue)) {
                    $customError = $ruleValue($value);
                    if ($customError) {
                        $this->errors[$field][] = $customError;
                    }
                }
            }
        }

        if (!empty($this->errors)) {
            throw new ValidatorException($this->errors);
        }

        return $values;
    }

    public function getErrors()
    {
        return $this->errors;
    }

    protected function validateType($value, $type)
    {
        switch ($type) {
            case 'string':
                return is_string($value);

            case 'number':
                return is_numeric($value);

            case 'email':
                return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;

            default:
                return false;
        }
    }
}
