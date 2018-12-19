<?php
/**
 * Created by PhpStorm.
 * User: Marat.Komarov
 * Date: 19.12.2018
 * Time: 10:38
 */

namespace app\classes;

/**
 * Interface CurrencyRepositoryContract
 * @package app\classes
 */
interface ExchangeRepositoryContract
{
    /**
     * @param string $codeFrom
     * @param string $codeTo
     * @return float
     */
    public function rate(string $codeFrom, string $codeTo): float;
}