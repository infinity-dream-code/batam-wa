@extends('layouts.admin_new')

@section('style')
    <link rel="stylesheet" href="{{ asset('main/vendor/libs/select2/select2.css') }}">
    <link rel="stylesheet" href="{{ asset('main/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }}">
    <link rel="stylesheet" href="{{ asset('main/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }}">
    <style>
        table.dataTable tr.selected {
            border-top: 2px solid var(--bs-primary);
            border-bottom: 2px solid var(--bs-primary);
            border-left: none;
            border-right: none;
        }
    </style>
@endsection

@section('content')
<div class="container py-4">
    <h2>Upload Gaji Guru Tetap</h2>

    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('upload.gaji-tetap') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">File Excel (.xls/.xlsx)</label>
            <input type="file" class="form-control" name="file" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload & Kirim</button>
    </form>
    <br>
    <br>
    <br>

    <h2>Upload Gaji Guru Tsanawiyah</h2>

    @if (session('success'))
        <div class="alert alert-success mt-3">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('upload.gaji-tsanawiyah') }}" method="POST" enctype="multipart/form-data" class="mt-4">
        @csrf
        <div class="mb-3">
            <label for="file" class="form-label">File Excel (.xls/.xlsx)</label>
            <input type="file" class="form-control" name="file" required>
        </div>
        <button type="submit" class="btn btn-primary">Upload & Kirim</button>
    </form>
</div>
@endsection
