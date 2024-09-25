@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4" x-data="{
    selectAll: false,
    selectedItems: [],
    toggleAll() {
        this.selectedItems = this.selectAll ? Array.from(document.querySelectorAll('.itemCheckbox')).map(checkbox => checkbox.value) : [];
    },
    checkSelectAll() {
        const allChecked = document.querySelectorAll('.itemCheckbox:checked').length === document.querySelectorAll('.itemCheckbox').length;
        this.selectAll = allChecked;
    }
}">
    <h1 class="text-2xl font-bold mb-6 text-white text-center">Get Data PosCIU</h1>

    <!-- Data Table -->
    <div class="overflow-x-auto">
        <form id="postDataForm" action="{{ route('post.data') }}" method="POST">
            @csrf
            <table class="min-w-full bg-gray-800 border border-gray-700 rounded-lg mx-auto text-white">
                <thead>
                    <tr class="bg-gray-900 text-gray-400">
                        <th class="py-2 px-4 border border-gray-700 text-center">
                        Select All<br><input type="checkbox" id="selectAll" x-model="selectAll" @change="toggleAll()"> 
                        </th>
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
                        <td class="py-2 px-4 border border-gray-700 text-center">
                            <input type="checkbox" class="itemCheckbox" name="items[]" value="{{ $item->nomor_resi }}" x-model="selectedItems" @change="checkSelectAll()">
                        </td>
                        <td class="py-2 px-4 border border-gray-700 text-center">{{ $item->nomor_resi }}</td>
                        <td class="py-2 px-4 border border-gray-700 text-left">{{ $item->nama_pengirim }}</td>
                        <td class="py-2 px-4 border border-gray-700 text-left">{{ $item->nama_penerima }}</td>
                        <td class="py-2 px-4 border border-gray-700 text-center">{{ \Carbon\Carbon::parse($item->tanggal_pengiriman)->format('d-m-Y') }}</td>
                        <td class="py-2 px-4 border border-gray-700 text-center">{{ $item->Status }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-2 px-4 border border-gray-700 text-center text-gray-400">Data Not Found</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
            <div class="mt-4">
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Post Selected Data</button>
            </div>
        </form>
    </div>

    <!-- Loading Dialog -->
    <div id="loadingDialog" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
        <div class="bg-white p-4 rounded shadow-lg">
            <p class="text-gray-700">Loading...</p>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.start();

    // Loading dialog show on submit
    const form = document.getElementById('postDataForm');
    const loadingDialog = document.getElementById('loadingDialog');

    form.addEventListener('submit', function () {
        loadingDialog.classList.remove('hidden'); // Show loading dialog when form is submitted
    });
});
</script>
@endpush
