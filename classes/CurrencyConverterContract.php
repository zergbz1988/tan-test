<?php

namespace app\classes;

/**
 * Interface CurrencyConverter
 * @package app\interfaces
 */
interface CurrencyConverterContract
{
    public function convert(): void;

    /**
     * @return string
     */
    public function converted(): string;
}