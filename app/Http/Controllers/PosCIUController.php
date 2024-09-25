<?php

namespace App\Http\Controllers;

use App\Models\PosCIU;
use App\Models\PosResponseCIU;
use App\Exports\PosResponseCIUExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;

class PosCIUController extends Controller
{
    public function indexciu(Request $request)
    {
        $search = $request->input('search', '');
        $data = PosCIU::query()
            ->where('nama_pengirim', 'like', "%$search%")
            ->orWhere('nomor_resi', 'like', "%$search%")
            ->paginate(10);

        return view('posciu.indexciu', compact('data', 'search'));
        // $search = $request->input('search');
        
        // // Fetch the data with optional search functionality
        // $data = PosCIU::when($search, function($query, $search) {
        //     return $query->where('nomor_resi', 'like', '%' . $search . '%')
        //                  ->orWhere('nama_pengirim', 'like', '%' . $search . '%')
        //                  ->orWhere('nama_penerima', 'like', '%' . $search . '%');
        // })
        // ->paginate(10);

        // return view('posciu.indexciu', compact('data', 'search'));
    } 
    public function getdata(Request $request){
        // Ambil parameter pencarian, pengurutan, dan paginasi
        $search = $request->input('search', '');
        $sortBy = $request->input('sort_by', 'nomor_resi');
        $sortOrder = $request->input('sort_order', 'asc');
        $currentPage = $request->input('page', 1);
        $perPage = 10; // Jumlah data per halaman

        // Query data dengan filter dan pengurutan
        $query = PosCIU::query()
            ->where('nama_pengirim', 'like', "%{$search}%")
            ->orWhere('nama_penerima', 'like', "%{$search}%")
            ->orderBy($sortBy, $sortOrder);

        // Ambil data dengan paginasi
        $data = $query->paginate($perPage, ['*'], 'page', $currentPage);

        // Mengembalikan data dalam format JSON
        return response()->json($data);
    }
    
    public function indexresponse(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        
        // Fetch the data with optional search functionality
        $data = PosResponseCIU::when($startDate && $endDate, function($query) use ($startDate, $endDate) {
            return $query->whereBetween('InsuranceDate', [$startDate, $endDate]);
        })
        ->paginate(10);

        return view('posciu.indexresponse', compact('data', 'startDate', 'endDate'));
    }
    public function exportResponse(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $filename = 'data_response_ciu-' . $startDate . '-' . $endDate . '.xlsx';
        return Excel::download(new PosResponseCIUExport($startDate, $endDate), $filename);
    }
   
}
