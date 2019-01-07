<?php

namespace App\Models\Entities;

/**
 * Class Dealer
 * @package App\Models\Entities
 *
 * @property $id integer
 * @property $name string
 * @property $address string
 * @property $cars array
 */
class Dealer
{
    protected $id,
        $name,
        $address;

    /**
     * Dealer constructor.
     * @param string $name
     * @param string $address
     */
    public function __construct(string $name, string $address)
    {
        $this->name = $name;
        $this->address = $address;
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function address(): string
    {
        return $this->address;
    }
}