<?php
/**
 * Created by PhpStorm.
 * User: Marat.Komarov
 * Date: 19.12.2018
 * Time: 10:11
 */

namespace app\classes;

/**
 * Interface CurrencyContract
 * @package app\classes
 */
interface CurrencyContract
{
    /**
     * @param float $value
     * @return string
     */
    public function formattedValue(float $value): string;

    /**
     * @return string
     */
    public function code(): string;

    /**
     * @return string
     */
    public function prefix(): string;

    /**
     * @return string
     */
    public function suffix(): string;
}