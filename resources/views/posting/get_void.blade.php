@extends('layouts.app')

@section('content')
<div class="flex-2">
    <div class="container mx-auto p-4">
        <h2 class="text-center text-2xl font-semibold mb-4">Posting Data Void to CIU</h2>
        <form method="POST" action="{{ route('post.void.data') }}" class="bg-gray-800 p-12 rounded-lg shadow-md">
            @csrf
            <label>Airwaybill (pisakan awb dengan koma) : </label><br>
            
            <textarea name="awb" id="awb" class="w-full py-2 px-4 text-white rounded-md mt-4"></textarea>
            <button type="submit" name="getData" class="w-full py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700 mt-4">Get Data</button>
        </form>

        <!-- Conditionally render table -->
        @if(isset($data) && $data->count() > 0)
        <div class="overflow-x-auto mt-8">
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
                    @foreach($data as $item)
                    <tr class="hover:bg-gray-700 text-sm">
                        <td class="py-2 px-4 border border-gray-700 text-center">{{ $item->nomor_resi }}</td>
                        <td class="py-2 px-4 border border-gray-700 text-left">{{ $item->nama_pengirim }}</td>
                        <td class="py-2 px-4 border border-gray-700 text-left">{{ $item->nama_penerima }}</td>
                        <td class="py-2 px-4 border border-gray-700 text-center">{{ \Carbon\Carbon::parse($item->tanggal_pengiriman)->format('d-m-Y') }}</td>
                        <td class="py-2 px-4 border border-gray-700 text-center">{{ $item->Status }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Pagination Links -->
        <div class="mt-4 flex justify-start">
            {{ $data->links() }}
        </div>
        @endif

        <!-- No Data Found Message -->
        @if(isset($data) && $data->isEmpty())
        <div class="mt-4 text-center text-gray-400">
            No data found.
        </div>
        @endif
    </div>
</div>
@endsection
