@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-6 text-white text-center">Data PosCIU</h1>
    <!-- Search Form -->
    <form method="GET" action="{{ route('posciu.indexciu.data') }}" class="mb-4 flex justify-end">
        <input type="text" name="search" value="{{ $search }}" placeholder="Search..." 
               class="border border-gray-600 bg-gray-800 text-white rounded-lg p-2" />
        <button type="submit" class="ml-2 bg-blue-500 text-white p-2 rounded-lg">Search</button>
    </form>

    <!-- Data Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-gray-800 border border-gray-700 rounded-lg mx-auto text-white">
            <thead>
                <tr class="bg-gray-900 text-gray-400">
                    <th class="py-2 px-4 border border-gray-700 text-center">AwbNo</th>
                    <th class="py-2 px-4 border border-gray-700 text-center">Nama Pengirim</th>
                    <th class="py-2 px-4 border border-gray-700 text-center">Nama Penerima</th>
                    <th class="py-2 px-4 border border-gray-700 text-center">Tanggal Awb</th>
                    <th class="py-2 px-4 border border-gray-700 text-center">Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($data as $item)
                <tr class="hover:bg-gray-700 text-sm">
                    <td class="py-2 px-4 border border-gray-700 text-center">{{ $item->nomor_resi }}</td>
                    <td class="py-2 px-4 border border-gray-700 text-left">{{ $item->nama_pengirim }}</td>
                    <td class="py-2 px-4 border border-gray-700 text-left">{{ $item->nama_penerima }}</td>
                    <td class="py-2 px-4 border border-gray-700 text-center">{{ \Carbon\Carbon::parse($item->tanggal_pengiriman)->format('d-m-Y') }}</td>
                    <td class="py-2 px-4 border border-gray-700 text-center">{{ $item->Status }}</td>
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
