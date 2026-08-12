@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
 
<div class="row g-3">
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="text-muted small">Total Destinasi</div>
                <div class="fs-2 fw-bold" style="color:#0E3B36;">{{ $totalDestinasi }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="text-muted small">Total Atraksi</div>
                <div class="fs-2 fw-bold" style="color:#0E3B36;">{{ $totalAtraksi }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="text-muted small">Total User</div>
                <div class="fs-2 fw-bold" style="color:#0E3B36;">{{ $totalUser }}</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card shadow-sm border-0">
            <div class="card-body">
                <div class="text-muted small">Total Ulasan</div>
                <div class="fs-2 fw-bold" style="color:#0E3B36;">{{ $totalUlasan }}</div>
            </div>
        </div>
    </div>
</div>
 
<div class="mt-4">
    <p class="text-muted">Gunakan menu di sidebar untuk mengelola Destinasi, Atraksi, dan User.</p>
</div>
 
@endsection
