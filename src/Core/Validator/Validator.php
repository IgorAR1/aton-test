<?php

namespace App\Core\Validator;

class Validator implements ValidatorInterface
{
    private array $errors = [];
    private array $rules = [];
    private array $data = [];
    /**
     * @var true
     */
    private bool $sometimes = false;

    public function setRules(array $rules): static
    {
        $this->rules = $rules;

        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function setData(array $data): void
    {
        $this->data = $data;
    }

    public function validate(array $data): array
    {
        $this->data = $data;

        foreach ($this->rules as $key => $rules) {
            foreach ($rules as $rule) {
                if (is_callable($rule)) {
                    $rule($key);
                }
                if (method_exists($this, $rule)) {
                    $this->{$rule}($key);
                }
            }
            $this->sometimes = false;
        }

        return $this->errors;
    }

    //Минус OCP, Для простоты так
    private function required(string $value): void
    {
        if (!isset($this->data[$value])) {
            $this->errors[] = "{$value} is required";
        }
    }

    private function string(string $value): void
    {
        if (!$this->sometimes && (!isset($this->data[$value]) || !is_string($this->data[$value]))) {
            $this->errors[] = "{$value} must be a string";
        }

    }

    private function array(string $value): void
    {
        if (!$this->sometimes && (!isset($this->data[$value]) || !is_array($this->data[$value]))) {
            $this->errors[] = "{$value} must be an array";
        }

    }

    private function notBlank(string $value): void
    {
        if (!$this->sometimes && (!isset($this->data[$value]) || empty($this->data[$value]))) {
            $this->errors[] = "{$value} must be non-blank";
        }
    }

    public function sometimes(): void
    {
        $this->sometimes = true;
    }
}