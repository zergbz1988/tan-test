<?php

namespace App\Models\Entities;

/**
 * Class Car
 * @package App\Models\Entities
 *
 * @property $id integer
 * @property $make string
 * @property $model string
 * @property $componentry string
 * @property $price int
 * @property $vin string
 *
 * @property $dealer object
 */
class Car
{
    protected $id,
        $make,
        $model,
        $componentry,
        $price,
        $vin,
        $dealer;

    /**
     * Car constructor.
     * @param string $make
     * @param string $model
     * @param string $componentry
     * @param int $price
     * @param string $vin
     */
    public function __construct(string $make, string $model, string $componentry, int $price, string $vin)
    {
        $this->make = $make;
        $this->model = $model;
        $this->componentry = $componentry;
        $this->price = $price;
        $this->vin = $vin;
    }

    /**
     * @param object $dealer
     */
    public function addToDealer($dealer): void
    {
        $this->dealer = $dealer;
    }

    /**
     * @return string
     */
    public function make(): string
    {
        return $this->make;
    }

    /**
     * @return string
     */
    public function model(): string
    {
        return $this->model;
    }

    /**
     * @return string
     */
    public function componentry(): string
    {
        return $this->componentry;
    }

    /**
     * @return int
     */
    public function price(): int
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function vin(): int
    {
        return $this->vin;
    }
}