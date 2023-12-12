<?php

class Validator 
{
    protected $rules = [];
    protected $messages = [];
    protected $errors = [];

    protected static $customValidators = [];
    
    protected static $defaultMessages = [
        'required'      => 'Поле :field обязательно для заполнения.',
        'email'         => 'Поле :field должно быть действительным адресом электронной почты.',
        'minLength'     => "Поле :field должно быть минимум :p0 символов",
        'maxLength'     => "Поле :field должно быть максимум :p0 символов",
        'numeric'       => 'Поле :field должно быть числовым.',
        'integer'       => 'Поле :field должно быть целым числом.',
        'alpha'         => 'Поле :field должно содержать только буквы.',
        'alphaNumeric'  => 'Поле :field должно содержать только буквы и цифры.',
        'date'          => 'Поле :field должно быть датой в формате :p0.',
    ];

    public function __construct(array $rules, array $messages = []) 
    {
        $this->rules = $rules;
        $this->messages = $messages;
    }

    public function validate(array $data) 
    {
        foreach ($this->rules as $field => $fieldRules) {

            $value = $data[$field] ?? null;

            foreach ($fieldRules as $rule) {

                [$ruleName, $ruleParams] = $this->parseRule($rule);

                if (isset(self::$customValidators[$ruleName])) {
                    $validator = self::$customValidators[$ruleName]['callback'];
                    $valid = $validator($value, $ruleParams);
                } else {

                    $validator = 'validate' . ucfirst($ruleName);
                    $valid = $this->$validator($value, $ruleParams);
                }
                
                if (!$valid) {
                    $this->errors[$field][$ruleName] = $this->getErrorMessage($field, $ruleName, $ruleParams);
                }
            }
        }
        return empty($this->errors);
    }

    public static function validator($ruleName, $message, callable $callback) 
    {
        self::$customValidators[$ruleName] = [
            'callback' => $callback, 
            'message' => $message];
    }

    protected function getErrorMessage($field, $ruleName, $ruleParams) 
    {
        $message = $this->messages[$field . '.' . $ruleName] 
                ?? self::$customValidators[$ruleName]['message'] 
                ?? self::$defaultMessages[$ruleName] 
                ?? 'Ошибка при валидации поля :field.';

        return $this->formatErrorMessage($message, $field, $ruleParams);
    }

    protected function formatErrorMessage($message, $field, $ruleParams) 
    {
        $message = str_replace(':field', $field, $message);
        foreach ($ruleParams as $i => $param) {
            $message = str_replace(":p$i", $param, $message);
        }
        return $message;
    }

    protected function parseRule($rule) 
    {
        $ruleParts = explode(':', $rule);
        $ruleName = $ruleParts[0];
        $params = isset($ruleParts[1]) ? explode(',', $ruleParts[1]) : [];
        return [$ruleName, $params];
    }

    public function getErrors()
    {
        return $this->errors;
    }

    public function getFirstErrors()
    {
        $result = [];
        foreach ($this->errors as $error) {
            $result[] = reset($error);
        }
        return $result;
    }

    public function hasErrors()
    {
        return !empty($this->errors);
    }

    /**
     * Default validator methods
     */

     protected function validateRequired($value) 
     {
        return !empty($value);
    }

    protected function validateMinLength($value, $minLength) 
    {
        return strlen($value) >= $minLength;
    }

    protected function validateMaxLength($value, $maxLength) 
    {
        return strlen($value) <= $maxLength;
    }

    protected function validateEmail($value) 
    {
        return filter_var($value, FILTER_VALIDATE_EMAIL) !== false;
    }

    protected function validateNumeric($value)
    {
        return is_numeric($value);
    }

    protected function validateInteger($value)
    {
        return filter_var($value, FILTER_VALIDATE_INT) !== false;
    }

    protected function validateAlpha($value)
    {
        return ctype_alpha($value);
    }

    protected function validateAlphaNumeric($value)
    {
        return ctype_alnum($value);
    }

    protected function validateDate($value, $format)
    {
        $date = DateTime::createFromFormat($format, $value);
        return $date && $date->format($format) === $value;
    }
}
