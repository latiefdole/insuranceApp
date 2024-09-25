@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6 text-white text-center">Hasil Posting</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-gray-800 border border-gray-700 rounded-lg mx-auto text-white">
            <thead>
                <tr class="bg-gray-900 text-gray-400">
                    <th class="py-2 px-4 border border-gray-700 text-center">Nomor Resi</th>
                    <th class="py-2 px-4 border border-gray-700 text-center">Nomor Sertifikat</th>
                    <th class="py-2 px-4 border border-gray-700 text-center">Insurance Date</th>
                    <th class="py-2 px-4 border border-gray-700 text-center">Status</th>
                    <th class="py-2 px-4 border border-gray-700 text-center">Remark</th>
                </tr>
            </thead>
            <tbody>
                @foreach(session('responseData') as $item)
                <tr class="hover:bg-gray-700 text-sm">
                    <td class="py-2 px-4 border border-gray-700 text-center">{{ $item->nomor_resi }}</td>
                    <td class="py-2 px-4 border border-gray-700 text-center">{{ $item->nomor_sertifikat }}</td>
                    <td class="py-2 px-4 border border-gray-700 text-center">{{ \Carbon\Carbon::parse($item->InsuranceDate)->format('d-m-Y') }}</td>
                    <td class="py-2 px-4 border border-gray-700 text-center">{{ $item->Status }}</td>
                    <td class="py-2 px-4 border border-gray-700 text-center">{{ $item->remark }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
