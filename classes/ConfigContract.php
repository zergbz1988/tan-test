<?php

namespace app\classes;

/**
 * Interface ConfigContract
 * @package app\classes
 */
interface ConfigContract
{
    /**
     * @param string $key
     * @return mixed
     */
    public function value(string $key);

    /**
     * @param string $key
     * @param string $value
     */
    public function put(string $key, string $value): void;
}