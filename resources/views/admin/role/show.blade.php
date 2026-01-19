@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" href="{{asset('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/table-datatable-jquery.css')}}">
@endsection
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        <a href="{{route('admin.roles.index')}}" class="btn_page">
                            Data Role
                        </a>
                    </div>
                    <h2 class="page-title">
                        Detail Role
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <div class="btn-list">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="page-body">
        <div class="container-xl">
            <div class="row py-2">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Role : {{$roles->name}}</h3>
                    </div>
                    <div class="card-body">
                        <h4>Permissions</h4>
                    </div>
                    <div class="card-table mx-3">
                        <form action="{{route('admin.roles.update', $id)}}" method="POST">
                            @method('PUT')
                            @csrf
                            <table class="table table-hover table-striped">
                                <thead class="sticky-top text-center">
                                <tr>
                                    <th scope="col">Nama</th>
                                    <th scope="col">Status
                                        <button id="checkAll">Centang Semua</button>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="text-center">
                                @foreach($permissions as $permission)
                                    <tr>
                                        <td>{{ $permission->name }}</td>
                                        <td>
                                            @if($roles->hasPermissionTo($permission))
                                                <input class="form-check-input" id="id-{{$permission->name}}"
                                                       name="{{$permission->name}}" type="checkbox" checked="">
                                            @else
                                                <input class="form-check-input" id="id-{{$permission->name}}"
                                                       name="{{$permission->name}}" type="checkbox">
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </table>

                            <div class="col">
                                <label for="edit-submit-create" class="btn btn-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                         viewBox="0 0 24 24"
                                         stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                                         stroke-linejoin="round">
                                        <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                        <path d="M12 5l0 14"/>
                                        <path d="M5 12l14 0"/>
                                    </svg>
                                    Simpan Permission
                                </label>
                                <input type="submit" id="edit-submit-create" class="d-none">
                            </div>

                        </form>
                    </div>
                    <div class="card-footer d-flex justify-content-between">
                    </div>
                </div>
            </div>

        </div>
    </div>

@endsection

@section('script')
    <script>
        $(document).ready(function () {
            // Event handler untuk centang semua
            $('#checkAll').click(function () {
                // Ambil status centang dari tombol "Centang Semua"
                var checkAllStatus = $(this).prop('checked');

                // Setel status centang semua checkbox berdasarkan status centang tombol "Centang Semua"
                $('.permission-checkbox').prop('checked', checkAllStatus);
            });

            // Event handler untuk checkbox izin individual
            $('.permission-checkbox').click(function () {
                // Periksa apakah semua checkbox izin tercentang
                var allChecked = $('.permission-checkbox:checked').length === $('.permission-checkbox').length;

                // Atur status centang tombol "Centang Semua" berdasarkan kondisi di atas
                $('#checkAll').prop('checked', allChecked);
            });
        });
    </script>
@endsection
