<?php

use app\classes\App;
use app\classes\Config;
use app\classes\CurrencyConverter;
use app\classes\CacheExchangeRepository;
use app\classes\DbExchangeRepository;

require_once __DIR__ . '/autoload.php';

$app = new App(new Config());
$app->start();

$cacheClass = $this->app->config()->value('cache');
$cache = new $cacheClass();

try {
    $exchangeRepositoryClass = $app->config()->value('cacheExchangeRepository');
    /* @var CacheExchangeRepository $exchangeRepository */
    $exchangeRepository = new $exchangeRepositoryClass($cache);
    $currencyConverter = new CurrencyConverter($exchangeRepository,'ru', 'ua', 150);
    $currencyConverter->convert();
} catch (InvalidArgumentException $e) {
    try {
        $dbDriverClass = $app->config()->value('dbDriver');
        $dbDriver = new $dbDriverClass();
        $exchangeRepositoryClass = $this->app->config()->value('dbExchangeRepository');
        /* @var DbExchangeRepository $exchangeRepository */
        $exchangeRepository = new $exchangeRepositoryClass($dbDriver);
        $this->rate = $exchangeRepository->rate($this->codeFrom, $this->codeTo);
    } catch (InvalidArgumentException $e) {

    }
}

echo 'new value: ' . $currencyConverter->converted();


