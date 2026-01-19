@extends('layouts.admin')
@section('style')
    <link rel="stylesheet" href="{{asset('libs/datatables.net-bs5/css/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/table-datatable-jquery.css')}}">
@endsection
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Manajemen Role
                    </div>
                    <h2 class="page-title">
                        Manajemen Role
                    </h2>
                </div>
                <!-- Page title actions -->
                <div class="col-auto ms-auto d-print-none">
                    <div class="btn-list">
                        <div class="btn-list">
                            <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal"
                               data-bs-target="#modal-create">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 5l0 14"/>
                                    <path d="M5 12l14 0"/>
                                </svg>
                                Tambah Role Baru
                            </a>
                            <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal"
                               data-bs-target="#modal-create" aria-label="Create new report">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                     viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                     stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                                    <path d="M12 5l0 14"/>
                                    <path d="M5 12l14 0"/>
                                </svg>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Page body -->
    <div class="page-body">
        <div class="container-xl">
            <div class="card shadow">
                <div class="card-header d-flex justify-content-between">
                    <h3 class="card-title">
                        Data User
                    </h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="table-responsive">
                            <table class="table table-hover" id="table-data">
                                <thead>
                                <tr>

                                </tr>
                                </thead>
                                <tfoot>
                                <tr>

                                </tr>
                                </tfoot>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('admin.role.modal.modal')

@endsection

@section('script')
    <script src="{{asset('libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('libs/datatables.net-bs5/js/dataTables.bootstrap5.min.js')}}"></script>

    <script type="text/javascript">
        let dataColumns = [];

        let dataTableInit;

        let dataUrl = '{{route('admin.roles.get-data')}}'
        let columnUrl = '{{route('admin.roles.get-column')}}'

        function formatColumnName(columnName) {
            var formattedName = columnName.replace(/_/g, ' ');
            formattedName = formattedName.replace(/\b\w/g, function (match) {
                return match.toUpperCase();
            });
            return formattedName;
        }

        function createColumnHeader() {
            let tableHead = $("#table-data thead tr");
            let tableFoot = $("#table-data tfoot tr");
            $.each(dataColumns, function (index, column) {
                let formattedColumnName = formatColumnName(column.name);
                tableHead.append('<th>' + formattedColumnName + '</th>');
            });
            //
            // $.each(dataColumns, function (index, column) {
            //     let formattedColumnName = formatColumnName(column.name);
            //     tableFoot.append('<th>' + formattedColumnName + '</th>');
            // });
        }

        const setTableColor = () => {
            document.querySelectorAll('.dataTables_paginate .pagination').forEach(dt => {
                dt.classList.add('pagination-primary')
            })
        }

        function dataTableCreate() {
            dataTableInit = $('#table-data').DataTable({
                autoWidth: false,
                responsive: true,
                columns: dataColumns,
                ajax: {
                    url: dataUrl,
                    type: "GET",
                    error: function () {
                        errorAlert('Ada masalah saat mengambil data dari server. Silahkan muat ulang halaman')
                    }
                },
                language: {
                    url: '{{asset('js/datatables-id.json')}}',
                },
                processing: true,
                serverSide: true,
                // buttons: [
                //     'copy', 'excel', 'pdf'
                // ]
            })

            dataTableInit.on('draw', setTableColor);
        }

        function dataReload() {
            dataTableInit.destroy();

            dataTableCreate();
        }

        function getDT() {
            $.ajax({
                url: columnUrl,
                success: function (data) {
                    $.each(data, function (index, column) {
                        dataColumns.push({
                            data: column.data,
                            name: column.name,
                            searchable: column.searchable,
                            orderable: column.orderable,
                        })
                    })

                    createColumnHeader()

                    dataTableCreate()
                }
            });
        }

        document.addEventListener("DOMContentLoaded", function () {
            getDT();

            // $('input.form-control.[type="search"]').on('keyup', function () {
            //     var searchTerm = this.value.trim();
            //     var minimumWordLimit = 3;
            //
            //     if (searchTerm !== null && searchTerm.length < minimumWordLimit) {
            //         dataTableInit.search('').draw();
            //         return;
            //     }
            //
            //     dataTableInit.search(searchTerm).draw();
            // });
        });
    </script>
@endsection
