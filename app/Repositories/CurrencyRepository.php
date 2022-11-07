<?php

namespace App\Repositories;

use App\Models\Currencies;

class CurrencyRepository
{

    /**
     * Get all currencies
     *
     * @return array
     */
    public function list()
    {
        $data = Currencies::all();
        
        return !empty($data) ? $data->toArray() : [];
    }

    /**
     * Get all currencies symbols
     *
     * @return array
     */
    public function listSymbols()
    {
        $data = Currencies::select('id','symbol')->get();
        
        return !empty($data) ? $data->toArray() : [];
    }

    /**
     * Store or get a currency
     *
     * @param string $symbol
     * @return array
     */
    public function getOrStore(string $symbol)
    {

        return Currencies::firstOrCreate(
            ['symbol' => $symbol]
        );
    }

}
