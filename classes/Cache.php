<?php
/**
 * Created by PhpStorm.
 * User: Marat.Komarov
 * Date: 19.12.2018
 * Time: 10:43
 */

namespace app\classes;

use InvalidArgumentException;

/**
 * Class Cache
 * @package app\classes
 *
 * @property array $data
 *
 */
class Cache implements CacheContract
{
    protected $data = [];

    /**
     * @param string $key
     * @return mixed|null
     */
    public function value(string $key)
    {
        if ($this->data[$key]['expires'] !== 0 && $this->data[$key]['expires'] <= time()) {
            unset($this->data[$key]);
        }
        if (!isset($this->data[$key])) {
            throw new InvalidArgumentException("Cache key `$key` doesn't exists!");
        }

        return $this->data[$key]['value'];
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param int $minutes
     */
    public function store(string $key, $value, int $minutes = 0): void
    {
        $this->data[$key] = [
            'value' => $value,
            'expires' => ($minutes === 0 ? 0 : time() + $minutes * 60)
        ];
    }
}