<?php

namespace App\Models;

/**
 * Class Client
 * @package App\Models
 *
 * @property $name string
 * @property $address string
 * @property $phone int
 */
class Client
{
    protected $name,
        $address,
        $phone;

    /**
     * Client constructor.
     * @param string $name
     * @param string $address
     * @param int $phone
     */
    public function __construct(string $name, string $address, int $phone)
    {
        $this->name = $name;
        $this->address = $address;
        $this->phone = $phone;
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

    /**
     * @return int
     */
    public function phone(): int
    {
        return $this->phone;
    }
}