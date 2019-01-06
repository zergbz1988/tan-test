<?php

namespace TanTest\Http\Request;


use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Validator\ConstraintViolationListInterface;
use Symfony\Component\Validator\Validation;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class Validator
 * @package TanTest\Foundation\Request
 *
 * @property ValidatorInterface $validator
 * @property ParameterBag $query
 * @property array $errors
 */
abstract class Validator
{
    protected $validator,
        $query,
        $errors = [];

    /**
     * Validator constructor.
     * @param ParameterBag $query
     */
    public function __construct(ParameterBag $query)
    {
        $this->validator = Validation::createValidator();
        $this->query = $query;
    }

    /**
     * @return array
     */
    public function errors(): array
    {
        return $this->errors;
    }

    /**
     * @param string $parameter
     * @param ConstraintViolationListInterface $errors
     */
    public function addErrors(string $parameter, ConstraintViolationListInterface $errors): void
    {
        foreach ($errors as $error) {
            $this->errors[$parameter][] = $error->getMessage();
        }
    }

    /**
     * @return bool
     */
    abstract public function validate(): bool;
}