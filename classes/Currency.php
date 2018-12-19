<?php
/**
 * Created by PhpStorm.
 * User: Marat.Komarov
 * Date: 19.12.2018
 * Time: 10:11
 */

namespace app\classes;

/**
 * Class Currency
 * @package app\classes
 *
 * @property string $code
 * @property string $prefix
 * @property string $suffix
 */
class Currency implements CurrencyContract
{
    protected $code;
    protected $prefix;
    protected $suffix;

    /**
     * Currency constructor.
     * @param string $code
     * @param string $prefix
     * @param string $suffix
     */
    public function __construct(string $code, string $prefix, string $suffix)
    {
        $this->code = $code;
        $this->prefix = $prefix;
        $this->suffix = $suffix;
    }

    /**
     * @param float $value
     * @return string
     */
    public function formattedValue(float $value): string
    {
        return implode(' ', [
            $this->prefix(),
            $value,
            $this->suffix()
        ]);
    }

    /**
     * @return string
     */
    public function code(): string
    {
        return $this->code;
    }

    /**
     * @return string
     */
    public function prefix(): string
    {
        return $this->prefix;
    }

    /**
     * @return string
     */
    public function suffix(): string
    {
        return $this->suffix;
    }
}