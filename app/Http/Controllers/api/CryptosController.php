<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Services\CryptoService;
use Exception;

class CryptosController extends Controller
{

    public function __construct(CryptoService $crypto_service)
    {
        $this->crypto_service = $crypto_service;
    }
    
    /**
     * List of cryptos on database
     *
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
        try {

            return response()->json($this->crypto_service->list(), 200);
        
        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 400);

        }

    }

    /**
     * Return a specified crypto
     *
     * @param integer $id
     * @return void
     */
    public function show (int $id)
    {
        try {

            return response()->json($this->crypto_service->get($id), 200);
        
        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 400);

        }

    }

}
