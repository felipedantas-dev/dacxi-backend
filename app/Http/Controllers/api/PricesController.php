<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Services\PriceService;
use Exception;
use Illuminate\Http\Request;

class PricesController extends Controller
{

    public function __construct(PriceService $price_service)
    {
        $this->price_service = $price_service;
    }
   
    /**
     * Return a current crypo price
     *
     * @param integer $id
     * @return void
     */
    public function current (int $id)
    {
        try {

            return response()->json($this->price_service->currentPrice($id), 200);
        
        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 400);

        }
    }

    /**
     * Return a history of crypto price
     *
     * @param integer $id
     * @return void
     */
    public function show (int $id)
    {
        try {

            return response()->json($this->price_service->getByCrypto($id), 200);
        
        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 400);

        }
    }

    /**
     * Return a estimate price of a crypto by a date time
     *
     * @param integer $id
     * @param Request $request
     * @return void
     */
    public function showByDatetime (int $id, Request $request)
    {
        try {

            return response()->json($this->price_service->getByCryptoDatetime($id, $request->input("datetime")), 200);
        
        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 400);

        }
    }

}
