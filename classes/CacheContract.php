<?php
/**
 * Created by PhpStorm.
 * User: Marat.Komarov
 * Date: 19.12.2018
 * Time: 10:41
 */

namespace app\classes;

/**
 * Interface CacheContract
 * @package app\classes
 */
interface CacheContract
{
    /**
     * @param string $key
     * @return mixed
     */
    public function value(string $key);

    /**
     * @param string $key
     * @param mixed $value
     * @param int $minutes
     */
    public function store(string $key, $value, int $minutes = 0): void;
}