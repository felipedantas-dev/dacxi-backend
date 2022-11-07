<?php

namespace App\Services;

use App\Repositories\CurrencyRepository;
use App\Services\CoinGeckoService;
use Error;
use Exception;

class CurrencyService
{

    public function __construct(CoinGeckoService $coingecko_service, CurrencyRepository $currency_repository)
    {
        $this->coingecko_service = $coingecko_service;
        $this->currency_repository = $currency_repository;
    }

    public function list ()
    {

        try {

            return $this->currency_repository->list();

        } catch (Exception $e) {
            throw new Error($e);
        }
        
    }

    public function setDefault ()
    {
        try {
            
            $this->currency_repository->getOrStore("usd");
            $this->currency_repository->getOrStore("brl");

            return $this->currency_repository->list();

        } catch (Exception $e) {
            throw new Error($e);
        }
    }

}
