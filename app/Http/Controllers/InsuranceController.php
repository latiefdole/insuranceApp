<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class InsuranceController extends Controller
{
   
    public function postPosCIUData(Request $request)
    {
        $response = Http::post('https://api.pcpexpress.com/api.mobile/insurance/PosCIUData', [
            'startDate' => $request->startDate,
            'endDate' => $request->endDate,
        ]);

        return view('insurance.post_data', ['response' => $response->json()]);
    }
}
