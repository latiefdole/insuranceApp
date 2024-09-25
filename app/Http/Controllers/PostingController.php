<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PosCIU;
use App\Models\PosResponseCIU;

class PostingController extends Controller
{
    public function postData(Request $request)
    {
        $selectedResis = $request->input('items', []);

        foreach ($selectedResis as $nomor_resi) {
            $posCIU = PosCIU::where('nomor_resi', $nomor_resi)->first();
            
            if ($posCIU) {
                // Prepare data for posting
                $postData = $posCIU->toArray();
                $postData = ['travelin' => json_encode($postData)];

                $url = 'http://newgen-apps1.com/cargociu/request/webservice/server_cargo2.php';
                $boundary = '---------------------------' . md5(time());
                $contentType = 'multipart/form-data; boundary=' . $boundary;
                $payload = "--$boundary\r\n"
                    . 'Content-Disposition: form-data; name="travelin"' . "\r\n\r\n"
                    . json_encode($postData) . "\r\n"
                    . "--$boundary--";

                $response = $this->sendHttpRequest($url, $payload, $contentType);

                if ($response) {
                    $items = json_decode($response, true);

                    if (isset($items['nomor_resi'])) {
                        $existingRecord = PosResponseCIU::where('nomor_resi', $nomor_resi)->first();

                        if (!$existingRecord) {
                            PosCIU::where('nomor_resi', $nomor_resi)
                                ->update([
                                    'nomor_sertifikat' => $items['NomorSertifikat'],
                                    'Status' => $items['Status'],
                                ]);

                            PosResponseCIU::create([
                                'nomor_sertifikat' => $items['NomorSertifikat'],
                                'InsuranceDate' => now()->format('Y-m-d'),
                                'Status' => $items['Status'],
                                'remark' => $items['Remark'],
                                'nomor_resi' => $nomor_resi,
                            ]);
                        } else {
                            $existingRecord->update([
                                'Status' => $items['Status'],
                                'remark' => $items['Remark'],
                            ]);
                        }
                    }
                }
            }
        }

        // Fetch results from posResponseCIU
        $responseData = PosResponseCIU::whereIn('nomor_resi', $selectedResis)->get();

        // Redirect to the results page with the response data
        return redirect()->route('posting/results.view')->with('responseData', $responseData);
    }

    private function sendHttpRequest($url, $payload, $contentType)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: ' . $contentType]);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

        $response = curl_exec($ch);
        curl_close($ch);

        return $response;
    }

    public function resultsView()
    {
        return view('results');
    }

    //void
    public function showForm()
    {
        return view('posting/get_void');
    }

    public function postVoid(Request $request)
    {
        $awb = $request->input('awb');
        // Split the input by comma
        $dataArray = explode(',', $awb);

        // Trim whitespace from each element
        $dataArray = array_map('trim', $dataArray);
        foreach ($dataArray as $nomor_resi) {
            $posCIU = PosCIU::where('nomor_resi', $nomor_resi)->first();
            
            if ($posCIU) {
                // Prepare data for posting
                $posCIU->status = 'voided';  // Assuming 'status' is a field in your model
                $posCIU->save();
                $posUpdateCIU = PosCIU::where('nomor_resi', $nomor_resi)->first();

                $postData = $posUpdateCIU->toArray();
                $postData = ['travelin' => json_encode($postData)];

                $url = 'http://newgen-apps1.com/cargociu/request/webservice/server_cargo2.php';
                $boundary = '---------------------------' . md5(time());
                $contentType = 'multipart/form-data; boundary=' . $boundary;
                $payload = "--$boundary\r\n"
                    . 'Content-Disposition: form-data; name="travelin"' . "\r\n\r\n"
                    . json_encode($postData) . "\r\n"
                    . "--$boundary--";

                $response = $this->sendHttpRequest($url, $payload, $contentType);

                if ($response) {
                    $items = json_decode($response, true);

                    if (isset($items['nomor_resi'])) {
                        $existingRecord = PosResponseCIU::where('nomor_resi', $nomor_resi)->first();

                        if (!$existingRecord) {
                            PosCIU::where('nomor_resi', $nomor_resi)
                                ->update([
                                    'nomor_sertifikat' => $items['NomorSertifikat'],
                                    'Status' => $items['Status'],
                                ]);

                            PosResponseCIU::create([
                                'nomor_sertifikat' => $items['NomorSertifikat'],
                                'InsuranceDate' => now()->format('Y-m-d'),
                                'Status' => $items['Status'],
                                'remark' => $items['Remark'],
                                'nomor_resi' => $nomor_resi,
                            ]);
                        } else {
                            $existingRecord->update([
                                'Status' => $items['Status'],
                                'remark' => $items['Remark'],
                            ]);
                        }
                    }
                }
            }
        }

        // Fetch results from posResponseCIU
        $responseData = PosResponseCIU::whereIn('nomor_resi', $selectedResis)->get();

        // Redirect to the results page with the response data
        return redirect()->route('posting/results.view')->with('responseData', $responseData);
    }

}

// {
//     public function showForm()
//     {
//         return view('posting/get_posting');
//     }
    
//     public function getData(Request $request)
//     {
//         $startDate = $request->input('start_date');
//         $endDate = $request->input('end_date');
        
//         $data = PosCIU::when($startDate && $endDate, function($query) use ($startDate, $endDate) {
//             return $query->whereBetween('tanggal_input', [$startDate, $endDate])            
//             ->orWhere('Status', '=', 'Open');
//         });

//         return view('posting/get_posting', compact('data', 'startDate', 'endDate'));
//     }   
    
//     public function postCIUData(Request $request)
//     {
//         $response = Http::post('https://api.pcpexpress.com/api.mobile/insurance/PosCIUData', [
//             'startDate' => $request->startDate,
//             'endDate' => $request->endDate,
//         ]);

//         return view('insurance.post_data', ['response' => $response->json()]);
//     }

// }
