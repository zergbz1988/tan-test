<?php
/**
 * Created by PhpStorm.
 * User: Marat.Komarov
 * Date: 18.12.2018
 * Time: 16:28
 */

namespace app\classes;

/**
 * Class Config
 * @package app\classes
 */
class Config implements ConfigContract
{
    protected $config;

    /**
     * Config constructor.
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public function value(string $key): string
    {
        return $this->config[$key];
    }

    /**
     * @param string $key
     * @param string $value
     */
    public function put(string $key, string $value): void
    {
        $this->config[$key] = $value;
    }
}