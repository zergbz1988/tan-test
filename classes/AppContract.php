<?php
/**
 * Created by PhpStorm.
 * User: Marat.Komarov
 * Date: 18.12.2018
 * Time: 16:30
 */

namespace app\classes;

/**
 * Interface AppContract
 * @package app\classes
 *
 * @property ConfigContract $config
 */
interface AppContract
{
    public function start(): void;
    /**
     * @return ConfigContract
     */
    public function config(): ConfigContract;
}