@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6 text-white text-center">Data Response CIU</h1>
    <!-- Search Form -->
    
    <form method="GET" action="{{ route('posciu.indexresponse.data') }}" class="mb-4 flex justify-end space-x-2">
    
    <input type="date" name="start_date" value="{{ $startDate }}" class="border border-gray-600 bg-gray-800 text-white rounded-lg p-2" />
    <input type="date" name="end_date" value="{{ $endDate }}" class="border border-gray-600 bg-gray-800 text-white rounded-lg p-2" />
    <button type="submit" class="ml-2 bg-blue-500 text-white p-2 rounded-lg">Search</button>
    <a href="{{ route('export.response', [
        'start_date' => $startDate,
        'end_date' => $endDate
    ]) }}" class="mb-4 inline-block bg-green-500 text-white p-2 rounded-lg">
    Export to Excel
</a>
</form>


    <!-- Data Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-gray-800 border border-gray-700 rounded-lg mx-auto text-white">
            <thead>
                <tr class="bg-gray-900 text-gray-400">
                    <th class="py-2 px-4 border border-gray-700 text-center">AwbNo</th>
                    <th class="py-2 px-4 border border-gray-700 text-center">No Polis</th>
                    <th class="py-2 px-4 border border-gray-700 text-center">Status</th>
                    <th class="py-2 px-4 border border-gray-700 text-center">Tanggal</th>
                    <th class="py-2 px-4 border border-gray-700 text-center">Remark</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr class="hover:bg-gray-700 text-sm">
                    <td class="py-2 px-4 border border-gray-700 text-center">{{ $item->nomor_resi }}</td>
                    <td class="py-2 px-4 border border-gray-700 text-left">{{ $item->nomor_sertifikat }}</td>
                    <td class="py-2 px-4 border border-gray-700 text-left">{{ $item->Status }}</td>
                    <td class="py-2 px-4 border border-gray-700 text-center">{{ \Carbon\Carbon::parse($item->InsuranceDate)->format('d-m-Y') }}</td>
                    <td class="py-2 px-4 border border-gray-700 text-center">{{ $item->remark }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-2 px-4 border border-gray-700 text-center text-gray-400">No data found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="mt-4 flex justify-start">
        {{ $data->links() }}
    </div>
</div>
@endsection
