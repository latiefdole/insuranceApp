@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Get Order Data</h2>
    <form method="post" action="{{ route('get-order') }}">
        @csrf
        <div class="form-group">
            <label for="startDate">Start Date:</label>
            <input type="date" id="startDate" name="startDate" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="endDate">End Date:</label>
            <input type="date" id="endDate" name="endDate" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="displayName">Display Name:</label>
            <input type="text" id="displayName" name="displayName" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="userId">User ID:</label>
            <input type="number" id="userId" name="userId" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Get Data</button>
    </form>
    @if(isset($response))
        <div class="alert alert-info mt-3">
            <strong>Response:</strong> {{ json_encode($response) }}
        </div>
    @endif
</div>
@endsection
