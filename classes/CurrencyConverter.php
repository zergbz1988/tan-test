<?php

namespace app\classes;

/**
 * Class CurrencyConverter
 * @package app\classes
 *
 * @property AppContract $app
 * @property string $codeFrom
 * @property string $codeTo
 * @property float $valueFrom
 * @property float $valueTo
 *
 * @property Currency $currency
 */
class CurrencyConverter implements CurrencyConverterContract
{
    protected $exchangeRepository;
    protected $codeFrom;
    protected $codeTo;
    protected $valueFrom;
    protected $valueTo;
    protected $rate;
    protected $currency;

    /**
     * CurrencyConverter constructor.
     * @param ExchangeRepositoryContract $exchangeRepository
     * @param string $codeFrom
     * @param string $codeTo
     * @param float $valueFrom
     */
    public function __construct(ExchangeRepositoryContract $exchangeRepository, string $codeFrom, string $codeTo, float $valueFrom)
    {
        $this->exchangeRepository = $exchangeRepository;
        $this->codeFrom = $codeFrom;
        $this->codeTo = $codeTo;
        $this->valueFrom = $valueFrom;
    }

    /**
     *
     */
    public function convert(): void
    {
        $this->rate = $this->exchangeRepository->rate($this->codeFrom, $this->codeTo);
    }

    /**
     * @return string
     */
    public function converted(): string
    {
        return $this->currency->formattedValue($this->valueTo);
    }
}