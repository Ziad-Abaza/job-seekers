<?php

trait ValidatorTrait
{
    /*
    |--------------------------------------------------------------------------
    | Validate Request Data Function
    |--------------------------------------------------------------------------
    */
    public function validateRequestData($request, $rules)
    {
        $errors = $this->makeValidator($request, $rules)->errors;

        if (!empty($errors)) {
            return $errors;
        }

        return null;
    }

    /*
    |--------------------------------------------------------------------------
    | Make Validator Function
    |--------------------------------------------------------------------------
    */
    private function makeValidator($data, $rules)
    {
        $validator = new stdClass();
        $validator->errors = [];

        foreach ($rules as $field => $rule) {
            if (!isset($data[$field]) || !$this->validateField($data[$field], $rule)) {
                $validator->errors[$field] = "The $field field is invalid.";
            }
        }

        return $validator;
    }

    /*
    |--------------------------------------------------------------------------
    | Validate Field Function
    |--------------------------------------------------------------------------
    */
    private function validateField($value, $rule)
    {
        $ruleParts = explode('|', $rule);

        foreach ($ruleParts as $rulePart) {
            if ($rulePart === 'required' && empty($value)) {
                return false;
            }
            if ($rulePart === 'nullable' && empty($value)) {
                continue;
            }
            if ($rulePart === 'email' && !filter_var($value, FILTER_VALIDATE_EMAIL)) {
                return false;
            }
            if ($rulePart === 'url' && !filter_var($value, FILTER_VALIDATE_URL)) {
                return false;
            }
            if ($rulePart === 'numeric' && !is_numeric($value)) {
                return false;
            }
            if ($rulePart === 'integer' && filter_var($value, FILTER_VALIDATE_INT) === false) {
                return false;
            }
            if ($rulePart === 'string' && !is_string($value)) {
                return false;
            }
            if ($rulePart === 'array' && !is_array($value)) {
                return false;
            }
            if (strpos($rulePart, 'min:') !== false) {
                $minLength = (int)str_replace('min:', '', $rulePart);
                if (strlen($value) < $minLength) {
                    return false;
                }
            }
            if (strpos($rulePart, 'max:') !== false) {
                $maxLength = (int)str_replace('max:', '', $rulePart);
                if (strlen($value) > $maxLength) {
                    return false;
                }
            }
        }

        return true;
    }
}
