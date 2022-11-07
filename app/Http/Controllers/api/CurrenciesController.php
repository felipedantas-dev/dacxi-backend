<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Services\CurrencyService;
use Exception;

class CurrenciesController extends Controller
{

    public function __construct(CurrencyService $currency_service)
    {
        $this->currency_service = $currency_service;
    }
    /**
     * List of currencies on database
     *
     * @return \Illuminate\Http\Response
     */
    public function index ()
    {
        try {

            return response()->json($this->currency_service->setDefault(), 200);
        
        } catch (Exception $e) {

            return response()->json(['error' => $e->getMessage()], 400);

        }

    }

}
