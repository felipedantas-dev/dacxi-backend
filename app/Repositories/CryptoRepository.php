<?php

namespace App\Repositories;

use App\Models\Crypto;

class CryptoRepository
{

    /**
     * Get all cryptos
     *
     * @return array
     */
    public function list()
    {
        $data = Crypto::all();
        
        return !empty($data) ? $data->toArray() : [];
    }

    /**
     * Get crypto by id
     *
     * @param int $id
     * @return array
     */
    public function get (int $id)
    {
        $data = Crypto::where('id', $id)->first();

        return !empty($data) ? $data->toArray() : [];
    }

    /**
     * Store a new crypto
     *
     * @param string $external_id
     * @param string $name
     * @param string $symbol
     * @return array
     */
    public function getOrStore(string $external_id, string $name = null, string $symbol = null)
    {

        return Crypto::firstOrCreate(
            ['external_id' => $external_id],
            ['name' => $name, 'symbol' => $symbol]
        );

    }

}
