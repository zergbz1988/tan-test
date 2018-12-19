<?php

namespace app\classes;

/**
 * Class CacheExchangeRepository
 * @package app\classes
 */
class CacheExchangeRepository implements ExchangeRepositoryContract
{
    protected $cache;

    /**
     * CacheCurrencyRepository constructor.
     * @param CacheContract $cache
     */
    public function __construct(CacheContract $cache)
    {
        $this->cache = $cache;
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
        $this->cache->store('exchangeFrom' . $codeFrom . 'To' . $codeTo, $rate);
    }
}