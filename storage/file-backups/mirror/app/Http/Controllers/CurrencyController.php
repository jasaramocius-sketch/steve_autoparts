<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Http;

class CurrencyController extends Controller
{
    public function rates()
    {
        $response = Http::get(config('services.currency.url'));

        if ($response->successful()) {
            return $response->json();
        }

        return response()->json([
            'error' => 'Unable to fetch exchange rates'
        ], 500);
    }

    public function convertCurrency($amount, $from, $to)
    {
        $response = Http::get(
            'https://api.unirateapi.com/api/widget/v1/convert',
            [
                'amount' => $amount,
                'from'   => strtoupper($from),
                'to'     => strtoupper($to),
            ]
        );

        if (!$response->successful()) {
            return response()->json([
                'success' => false,
            ]);
        }

        return $response->json();
    }
    public function convert($amount, $from, $to)
    {
        $response = Http::get(
            'https://api.unirateapi.com/api/widget/v1/convert',
            [
                'amount' => $amount,
                'from'   => strtoupper($from),
                'to'     => strtoupper($to),
            ]
        );

        return response()->json($response->json(), $response->status());
    }
}