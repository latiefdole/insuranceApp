@extends('layouts.app')

@section('content')
<div class="flex-2" x-data="order"> 
    <div class="container mx-auto p-4">
        <h2 class="text-center text-2xl font-semibold mb-4">Get Order Data</h2>
        <form method="POST" action="{{ route('get.order.data') }}" class="bg-gray-800 p-12 rounded-lg shadow-md">
            @csrf
            <div class="mb-4">
                <label for="startDate" class="block text-sm font-medium text-gray-300">Start Date:</label>
                <input type="date" id="startDate" name="startDate" class="mt-1 block w-full px-3 py-2 border border-gray-700 bg-gray-900 text-white rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="endDate" class="block text-sm font-medium text-gray-300">End Date:</label>
                <input type="date" id="endDate" name="endDate" class="mt-1 block w-full px-3 py-2 border border-gray-700 bg-gray-900 text-white rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500" required>
            </div>
            <div class="mb-4">
                <label for="user" class="block text-sm font-medium text-gray-300">User:</label>
                <select class="mt-1 block w-full px-3 py-2 border border-gray-700 bg-gray-900 text-white rounded-md shadow-sm focus:outline-none focus:ring focus:ring-blue-500" id="user-search" name="user-search">
                </select>
                <input type="hidden" id="userId" name="userId">
                <input type="hidden" id="displayName" name="displayName">
            </div>
            <button type="submit" name="getOrder" class="w-full py-2 px-4 bg-blue-600 text-white rounded-md hover:bg-blue-700">Get Data</button>
        </form>
    </div>
</div> 
@endsection

@push("script")
<!-- <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

 -->
@endpush
@push("script")
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
       
    
document.addEventListener('alpine:init', () => {
    Alpine.data('order', () => ({
        userSelectedID: '',
        userSelectedName: '',
        init() {
            const self = this;
            $('#user-search').select2({
                    ajax: {
                        url: '/search-users',
                        headers: {
                            'Content-Type': 'application/json',
                            },
                        data: function(params) {
                            var query = {
                                term: params.term
                            }
                            return query;
                        },
                        processResults: function(data) {
                            var result = data.results;
                            console.log(result);
                            // console.log(results);
                            return {
                                results: data.map(user => ({
                                    id: user.UserId, 
                                    text: user.DisplayName 
                                }))
                            };

                            //return{ result:data };
                           // this.ListProduk = data;
                            // return {
                            //     results: data
                            // };
                        },
                    },
                    placeholder: 'Cari User',
                    minimumInputLength: 1
                });
                $('#user-search').on('select2:select', function(e) {
                    var data = e.params.data;
                
                // Debugging: Check if selection works
                console.log('Selected User:', data);

                // Update hidden input fields
                $('#userId').val(data.id);          // Set UserId in hidden input
                $('#displayName').val(data.text);   // Set DisplayName in hidden input

                // Debugging: Check if inputs are updated
                console.log('userId:', $('#userId').val());
                console.log('displayName:', $('#displayName').val());
                });
                // $('#user-search').trigger('change');

                // $('#user-search').on('select2:select', function (e) {
                //     const data = e.params.data;
                //     self.userSelectedID = data.id;
                //     self.userSelectedName = data.text;
                // });
                // $('#user-search').on('select2:select', function(e) {
                //     var data = e.params.data;
                //     $(this).val(null).trigger('change');
                // });
        },
    
    }));
});
</script>

@endpush