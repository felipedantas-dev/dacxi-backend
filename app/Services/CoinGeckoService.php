<?php

namespace App\Services;

use Codenixsv\CoinGeckoApi\CoinGeckoClient;

class CoinGeckoService
{

    public function __construct()
    {
        $this->coingecko_client = new CoinGeckoClient();
    }

    /**
     * Get the API Status
     *
     * @return void
     */
    public function getPing()
    {  
        return $this->coingecko_client->ping();
    }

    /**
     * List all coins
     *
     * @return void
     */
    public function getCryptos()
    {
        return $this->coingecko_client->coins()->getList();
    }

    /**
     * List all supportedcurrencies
     * 
     * @return void
     */
    public function getCurrencies()
    {
        return $this->coingecko_client->simple()->getSupportedVsCurrencies();
    }


    /**
     * Get price of a coin by currency specified
     *
     * @return void
     */
    public function getPrices (string $cryptos, string $currencies)
    {
        return $this->coingecko_client->simple()->getPrice($cryptos, $currencies);
    }

    /**
     * Get history of a coin by date specified
     */
    public function getHistory (string $cryptos, string $date)
    {
        return $this->coingecko_client->coins()->getHistory($cryptos, $date);
    }
}
