<?php

namespace app\classes;

/**
 * Class App
 * @package app\classes
 *
 * @property ConfigContract $config
 */
class App implements AppContract
{
    protected $config;

    /**
     * App constructor.
     * @param ConfigContract $config
     */
    public function __construct(ConfigContract $config)
    {
        $this->config = $config;
    }

    /**
     * Starts Application
     */
    public function start(): void
    {
        require_once __DIR__ . '/../app.php';
    }

    /**
     * @return ConfigContract
     */
    public function config(): ConfigContract
    {
        return $this->config;
    }
}