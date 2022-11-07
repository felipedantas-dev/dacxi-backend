<?php

namespace App\Services;

use App\Repositories\CryptoRepository;
use App\Repositories\CurrencyRepository;
use App\Repositories\PriceRepository;
use App\Services\CoinGeckoService;
use Exception;

class PriceService
{

    public function __construct(CoinGeckoService $coingecko_service, PriceRepository $price_repository, CryptoRepository $crypto_repository, CurrencyRepository $currency_repository)
    {
        $this->coingecko_service = $coingecko_service;
        $this->price_repository = $price_repository;
        $this->crypto_repository = $crypto_repository;
        $this->currency_repository = $currency_repository;
    }

    public function currentPrice (int $cryptoID)
    {
        try {

            $crypto = $this->getCrypto($cryptoID);
            $data = [];

            if (!empty($crypto)) {

                $currencies = $this->getCurrencies();

                $currentPrices = $this->coingecko_service->getPrices($crypto["external_id"], $this->formatCurrencies($currencies));
                
                foreach ($currentPrices[$crypto["external_id"]] as $currencySymbol => $currentPrice) {

                    $currencyIndex = array_search($currencySymbol, array_column($currencies, "symbol"));

                    $price = $this->price_repository->getOrStore($cryptoID, $currencies[$currencyIndex]["id"], $currentPrice);

                    $data["crypto"]["name"] = $crypto["name"];
                    $data["crypto"]["external_id"] = $crypto["external_id"];
                    $data["crypto"]["symbol"] = $crypto["symbol"];
                    $data["currencies"][$currencySymbol]["price"] = $currentPrice;
                    $data["datetime"] = date('Y-m-d H:i', strtotime($price["created_at"]));

                }

                return $data;

            }

            throw new Exception("Crypto not found, please inform a valid ID of a crypto.");

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }
    }

    public function getByCrypto (int $crypto)
    {

        try {

            return $this->price_repository->get($crypto);

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }

    public function getByCryptoDatetime (int $cryptoID, string $datetime)
    {

        try {

            $crypto = $this->getCrypto($cryptoID);
            $currencies = $this->getCurrencies();
            $data = [];

            if (!empty($crypto)) {

                $specifiedPrices = $this->coingecko_service->getHistory($crypto["external_id"], date('d-m-Y', strtotime($datetime)));

                if (!array_key_exists("market_data", $specifiedPrices)) {
                    throw new Exception("There are no values for this cryptocurrency on the informed datetime.");
                }

                foreach ($currencies as $currency) {
                    $estimateCurrency = $this->price_repository->getOrStoreHistory($crypto["id"], $currency["id"], $datetime, $specifiedPrices["market_data"]["current_price"][$currency["symbol"]]);

                    if (!empty($estimateCurrency)) {
                        $data["crypto"] = $estimateCurrency["crypto_id"];
                        $data["estimates"][$currency["symbol"]]["value"] = $estimateCurrency["price"];
                        $data["datetime"] = $datetime;
                    }
                }

                return $data;
            }

            throw new Exception("Crypto not found, please inform a valid ID of a crypto.");

        } catch (Exception $e) {
            throw new Exception($e->getMessage());
        }

    }


    private function getCrypto (int $id)
    {
        return $this->crypto_repository->get($id);
    }

    private function getCurrencies ()
    {
        return $this->currency_repository->listSymbols();
    }

    private function formatCurrencies ($currencies)
    {
        $data = [];

        foreach ($currencies as $currency) {
            array_push($data, $currency["symbol"]);
        }

        return join(',', $data);
    }

}
