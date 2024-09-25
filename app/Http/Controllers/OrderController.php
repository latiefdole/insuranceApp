<?php

namespace App\Http\Controllers;

use App\Models\PosCIU;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class OrderController extends Controller
{
    public function showForm()
    {
        return view('posting/get_order');
    }

    public function getOrderInsuranceCIU(Request $request)
    {
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');
        $displayName = $request->input('displayName');
        $userId = $request->input('userId');

       $result= $this->processOrderInsuranceCIU($startDate, $endDate, $displayName, $userId);
       return $this->resultgetdataCIU($startDate, $endDate,$result);
       //return view('posting/get_posting', $result);

    }

    private function processOrderInsuranceCIU($startDate, $endDate, $displayName, $userId)
    {
        try {
            // Define the query to fetch the data
            $query = "
                SELECT 
                    o.AwbNo AS nomor_resi,
                    o.InputDate AS tanggal_input,
                    DATEADD(DAY, ISNULL(o.LeadTime, 1), o.InputDate) AS tanggal_pengiriman,
                    REPLACE(o.ShipperName, '\\\\', '/') AS nama_pengirim,
                    o.BranchId AS kode_cabang,
                    REPLACE(b.BranchName, '\\\\', '/') AS alamat_pengirim,
                    REPLACE(o.ShipperTelphone1, '\\\\', '/') AS telepon_pengirim,
                    REPLACE(o.ReceiverName, '\\\\', '/') AS nama_penerima,
                    REPLACE(o.ReceiverAddress1, '\\\\', '/') AS alamat_penerima,
                    REPLACE(o.ReceiverTelphone1, '\\\\', '/') AS telepon_penerima,
                    mContent.ContentName AS jenis_barang,
                    o.TotalGrossWeight AS berat_barang,
                    o.totalkoli AS jumlah_barang,
                    IIF(ISNULL(o.ValueOfGoods, 0) = 0, 0, o.ValueOfGoods) AS harga_barang,
                    IIF(ISNULL(o.ShippingCost, 0) = 0, 0, o.ShippingCost) AS harga_pengiriman,
                    CASE
                        WHEN o.UseInsurance = 0 THEN ISNULL(o.ShippingCost * 10, 0)
                        WHEN o.UseInsurance = 1 AND (o.ValueOfGoods IS NOT NULL OR o.ValueOfGoods > 0) THEN o.ValueOfGoods
                        ELSE 0
                    END AS harga_pertanggungan,
                    CAST(CASE
                            WHEN o.UseInsurance = 0 THEN 350
                            WHEN o.UseInsurance = 1 THEN
                                CASE
                                    WHEN (o.ValueOfGoods * 0.0008) > 3500 THEN o.ValueOfGoods * 0.0008
                                    ELSE 3500
                                END
                            ELSE 0
                        END AS DECIMAL(10, 0)) AS premium,
                    LOWER(m.ModaName) AS pengiriman_melalui,
                    IIF(ISNULL(o.UseInsurance, 0) = 0, 'PL01', 'PL02') AS jenis_plan,
                    mContent.ContentName AS TypeOfGoods,
                    g.GoodsName AS DescOfGoods
                FROM tOrderDom AS o WITH (NOLOCK)
                LEFT OUTER JOIN mBranch AS b WITH (NOLOCK) ON o.OriginId = b.BranchId
                LEFT OUTER JOIN mCovrageArea AS c WITH (NOLOCK) ON o.DestinationId = c.CityCode
                LEFT OUTER JOIN mGoods AS g WITH (NOLOCK) ON o.GoodsId = g.GoodsId
                LEFT OUTER JOIN mShipmentType AS s WITH (NOLOCK) ON o.ShipTypeId = s.ShipTypeId
                LEFT OUTER JOIN mContent WITH (NOLOCK) ON o.ContentId = mContent.ContentId
                LEFT OUTER JOIN mService sv WITH (NOLOCK) ON o.ServiceId = sv.ServiceId
                LEFT OUTER JOIN mProduct p WITH (NOLOCK) ON sv.ProductId = p.ProductId
                LEFT OUTER JOIN mModa m WITH (NOLOCK) ON p.ModaId = m.ModaId
                WHERE o.OriginId IN (SELECT BranchInsId FROM mBranchInsurance WHERE ConfigId = 265 AND ActiveId = 1)
                    AND o.StatusId NOT IN (28, 84, 71, 37)
                    AND o.ServiceId NOT IN (10, 56)
                    AND o.AwbNo NOT IN (
                        SELECT nomor_resi FROM posCIU WHERE Status IN ('Invoiced', 'Paid')
                        UNION
                        SELECT nomor_resi FROM posCIU WHERE Status IN ('Approved', 'Canceled')
                        AND nomor_resi NOT IN (
                            SELECT AwbNo FROM tBAPHdr WHERE CONVERT(DATE, InputDate) BETWEEN ? AND ?
                        )
                    )
                    AND CONVERT(DATE, o.InputDate) BETWEEN ? AND ?
            ";

            // Execute the query to fetch data
            $data = DB::connection('sqlsrv')->select($query, [
                $startDate, 
                $endDate, 
                $startDate, 
                $endDate
            ]);
            // Check if data is found
            if (empty($data)) {
                return response()->json([
                    'message' => 'Data Not Found.'
                ], 404); // Return 404 Not Found if no data is found
            }
            // dd($data);
            // Loop through each row of the data and perform insert or update
            foreach ($data as $row) {
                // Check if the record exists
                $existingRecord = DB::table('posCIU')->where('nomor_resi', $row->nomor_resi)->first();
            
                if ($existingRecord) {
                    // If the record exists, update the fields except 'Status'
                    $affectedRows = DB::table('posCIU')->where('nomor_resi', $row->nomor_resi)->update([
                        'tanggal_input' => $row->tanggal_input,
                        'tanggal_pengiriman' => $row->tanggal_pengiriman,
                        'tanggal_penerimaan' => null,
                        'nama_pengirim' => $row->nama_pengirim,
                        'kode_cabang' => $row->kode_cabang,
                        'user_input' => $userId,
                        'alamat_pengirim' => $row->alamat_pengirim,
                        'telepon_pengirim' => $row->telepon_pengirim,
                        'nama_penerima' => $row->nama_penerima,
                        'alamat_penerima' => $row->alamat_penerima,
                        'telepon_penerima' => $row->telepon_penerima,
                        'jenis_barang' => $row->jenis_barang,
                        'berat_barang' => $row->berat_barang,
                        'jumlah_barang' => $row->jumlah_barang,
                        'harga_barang' => $row->harga_barang,
                        'harga_barang1' => $row->harga_barang,
                        'harga_pengiriman' => $row->harga_pengiriman,
                        'harga_pengiriman1' => $row->harga_pengiriman,
                        'harga_pertanggungan' => $row->harga_pertanggungan,
                        'premium' => $row->premium,
                        'premium1' => $row->premium,
                        'pengiriman_melalui' => $row->pengiriman_melalui,
                        'jenis_plan' => $row->jenis_plan,
                        'jenis_plan1' => $row->jenis_plan,
                        'UserId' => $userId
                    ]);
                } else {
                    $affectedRows = DB::table('posCIU')->insert([
                        'nomor_resi' => $row->nomor_resi,
                        'tanggal_input' => $row->tanggal_input,
                        'tanggal_pengiriman' => $row->tanggal_pengiriman,
                        'tanggal_penerimaan' => null,
                        'nama_pengirim' => $row->nama_pengirim,
                        'kode_cabang' => $row->kode_cabang,
                        'user_input' => $userId,
                        'alamat_pengirim' => $row->alamat_pengirim,
                        'telepon_pengirim' => $row->telepon_pengirim,
                        'nama_penerima' => $row->nama_penerima,
                        'alamat_penerima' => $row->alamat_penerima,
                        'telepon_penerima' => $row->telepon_penerima,
                        'jenis_barang' => $row->jenis_barang,
                        'berat_barang' => $row->berat_barang,
                        'jumlah_barang' => $row->jumlah_barang,
                        'harga_barang' => $row->harga_barang,
                        'harga_barang1' => $row->harga_barang,
                        'harga_pengiriman' => $row->harga_pengiriman,
                        'harga_pengiriman1' => $row->harga_pengiriman,
                        'harga_pertanggungan' => $row->harga_pertanggungan,
                        'premium' => $row->premium,
                        'premium1' => $row->premium,
                        'pengiriman_melalui' => $row->pengiriman_melalui,
                        'jenis_plan' => $row->jenis_plan,
                        'jenis_plan1' => $row->jenis_plan,
                        'Status' => 'Open', // Set status to 'Open' on insert
                        'UserId' => $userId
                    ]);
                }
            }
            

            return response()->json([
                'message' => 'Get Data successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'ErrorCode' => $e->getCode(),
                'ErrorMessage' => $e->getMessage(),
            ], 500);
        }
    }
    public function resultgetdataCIU($startDate, $endDate, $result)
    {
        // Format tanggal untuk digunakan dalam query
        $startDateFormatted = \Carbon\Carbon::parse($startDate)->format('Y-m-d');
        $endDateFormatted = \Carbon\Carbon::parse($endDate)->format('Y-m-d');
        $querybap= "SELECT AwbNo  FROM tBAPHdr WHERE CONVERT(DATE, InputDate) BETWEEN ? AND ?";
        $awbbap = DB::connection('sqlsrv')->select($querybap, [
            $startDateFormatted, 
            $endDateFormatted, 
        ]);
        // Fetch the AwbNo values from the SQL Server result
        $awbbapArray = array_map(function($item) {
            return $item->AwbNo;
        }, $awbbap);
        
        // Create a string for the IN clause, wrapping all values in single quotes
        $awbbapPlaceholders = implode(',', array_map(function ($nomorResi) {
            return "'$nomorResi'"; // Directly wrap all values in single quotes
        }, $awbbapArray));
        // Define the raw SQL query
        $query = "
        SELECT * FROM (
            SELECT 
                REPLACE(nama_penerima, '''', '') AS namapenerima,
                REPLACE(nama_pengirim, '''', '') AS namapengirim,
                REPLACE(REPLACE(alamat_penerima, '''', ''), CHAR(34), '') AS alamatpenerima,
                posCIU.*
            FROM posCIU
            WHERE 
                (Status IN ('Open') 
                    AND DATE(tanggal_input) BETWEEN ? AND ?
                )
                OR (
                    Status IN ('Approved', 'Canceled') 
                    AND nomor_resi IN ($awbbapPlaceholders) 
                    AND DATE(tanggal_input) BETWEEN ? AND ?
                )
        ) AS SubQuery
        ";
        // Execute the raw SQL query
        $data = DB::connection('mysql')->select($query, [
            $startDateFormatted, 
            $endDateFormatted, 
            $startDateFormatted, 
            $endDateFormatted,
        ]);
        // Convert result to Laravel pagination format
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $perPage = 10; // Set items per page
        $currentItems = array_slice($data, ($currentPage - 1) * $perPage, $perPage);
        $total = count($data);
        $data = new LengthAwarePaginator($currentItems, $total, $perPage, $currentPage, [
            'path' => LengthAwarePaginator::resolveCurrentPath()
        ]);

        return view('posting/data_result', compact('data','result'));
    }
}
