<?php

namespace app\classes;

/**
 * Class DbExchangeRepository
 * @package app\classes
 */
class DbExchangeRepository implements ExchangeRepositoryContract
{
    protected $driver;

    /**
     * DbExchangeRepository constructor.
     * @param DbDriverContract $driver
     */
    public function __construct(DbDriverContract $driver)
    {
        $this->driver = $driver;
    }

    /**
     * @param string $codeFrom
     * @param string $codeTo
     * @return float
     */
    public function rate(string $codeFrom, string $codeTo): float
    {
        return $this->cache->value('exchangeFrom' . $codeFrom . 'To' . $codeTo);
    }

    /**
     * @param string $codeFrom
     * @param string $codeTo
     * @param float $rate
     */
    public function store(string $codeFrom, string $codeTo, float $rate): void
    {
        $this->driver->store('exchange', compact('codeFrom', 'codeTo', 'rate'));
    }
}