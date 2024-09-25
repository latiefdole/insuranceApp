@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Post Data</h2>
    <form method="post" action="{{ route('post-data') }}">
        @csrf
        <input type="hidden" name="startDate" value="{{ old('startDate') }}">
        <input type="hidden" name="endDate" value="{{ old('endDate') }}">
        <button type="submit" class="btn btn-success btn-block">Submit Data</button>
    </form>
    @if(isset($response))
        <div class="alert alert-info mt-3">
            <strong>Response:</strong> {{ json_encode($response) }}
        </div>
    @endif
</div>
@endsection
