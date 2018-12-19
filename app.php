<?php

use app\classes\Cache;
use app\classes\CacheExchangeRepository;
use app\classes\DbExchangeRepository;
use app\classes\HttpExchangeRepository;
use app\classes\MySqlDriver;

$this->config->put('cache', Cache::class);
$this->config->put('dbDriver', MySqlDriver::class);
$this->config->put('cacheExchangeRepository', CacheExchangeRepository::class);
$this->config->put('dbExchangeRepository', DbExchangeRepository::class);
$this->config->put('httpExchangeRepository', HttpExchangeRepository::class);
$this->config->put('currencyExchangeServiceURL', 'https://example.com');
