@extends('layouts.app')

@section('content')
<div class="col">
    <div class="card shadow-lg p-4">
        <div class="card-body">
            <h3 class="display-6">Hallo, <span class="fw-bold">{{ auth()->user()->name }}</span></h3>
        </div>
    </div>
</div>
@endsection