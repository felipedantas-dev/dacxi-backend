<?php

namespace App\Repositories;

use App\Models\PriceHistory;
use Illuminate\Support\Facades\DB;

class PriceRepository
{

    /**
     * Get all currencies
     *
     * @return array
     */
    public function get(int $id)
    {
        $data = PriceHistory::select("cryptos.name as crypto", "currencies.symbol as currency", "price", "price_histories.created_at as datetime")
                ->join('cryptos', 'price_histories.crypto_id', '=', 'cryptos.id')
                ->join('currencies', 'price_histories.currency_id', '=', 'currencies.id')
                ->where("crypto_id", $id)
                ->orderBy('price_histories.created_at', 'desc')
                ->get();

        return !empty($data) ? $data->toArray() : [];
    }

    /**
     * Get or store a price of crypto
     *
     * @param integer $crypto
     * @param integer $currency
     * @param string $price
     * @param string $datetime
     * @return array
     */
    public function getOrStore (int $crypto, int $currency, string $price)
    {

        $currentDatetime = date('Y-m-d H:i') . ':00';

        return PriceHistory::firstOrCreate([
            'crypto_id' => $crypto, 
            'currency_id' => $currency, 
            "price" => $price, 
            "created_at" => $currentDatetime,
            "updated_at" => $currentDatetime
        ]);
    }

    /**
     * Get or store by a datetime history
     *
     * @param integer $crypto
     * @param integer $currency
     * @param string $datetime
     * @return array
     */
    public function getOrStoreHistory (int $crypto, int $currency, string $datetime, string $price = null)
    {

        $datetime = date('Y-m-d H:i', strtotime($datetime)) .  ':00';

        return PriceHistory::firstOrCreate(
        [
            'crypto_id' => $crypto, 
            'currency_id' => $currency,
            "created_at" => $datetime
        ],
        [
            "updated_at" => $datetime,
            "price" => $price
        ]);
    }
    

}
