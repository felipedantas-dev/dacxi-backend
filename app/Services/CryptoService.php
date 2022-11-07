<?php

namespace App\Services;

use App\Repositories\CryptoRepository;
use App\Services\CoinGeckoService;
use Error;
use Exception;

class CryptoService
{

    public function __construct(CoinGeckoService $coingecko_service, CryptoRepository $crypto_repository)
    {
        $this->coingecko_service = $coingecko_service;
        $this->crypto_repository = $crypto_repository;
    }

    public function list ()
    {

        try {

            return $this->crypto_repository->list();

        } catch (Exception $e) {
            throw new Error($e);
        }
        
    }

    public function get (int $id)
    {

        try {

            return $this->crypto_repository->get($id);
            
        } catch (Exception $e) {
            throw new Error($e);
        }
        
    }

    public function setDefault ()
    {
        try {
            
            $this->crypto_repository->getOrStore("bitcoin", "Bitcoin", "btc");
            $this->crypto_repository->getOrStore("dacxi", "Dacxi", "dacxi");
            $this->crypto_repository->getOrStore("ethereum", "Ethereum", "eth");
            $this->crypto_repository->getOrStore("cosmos", "Cosmos Hub", "atom");
            $this->crypto_repository->getOrStore("terra-luna-2", "Terra", "luna");

            return $this->crypto_repository->list();

        } catch (Exception $e) {
            throw new Error($e);
        }
    }

}
