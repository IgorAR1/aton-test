<?php

namespace App\Core\Validator;

interface ValidatorInterface
{
    public function validate(array $data): array;

    public function getErrors(): array;

    public function setRules(array $rules): static;
}