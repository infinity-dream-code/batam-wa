@extends('layouts.admin')
@section('content')
    <!-- Page header -->
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <!-- Page pre-title -->
                    <div class="page-pretitle">
                        Manajemen Pengguna {{Auth::id()}}
                    </div>
                    <h2 class="page-title">
                        Manajemen Data Pengguna
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
                                Tambah Admin Baru
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
            <div class="card">
                <div class="card-body">
                    <div class="row text-end">
                        <div class="text-muted">
                            <label for="search">
                                Cari:
                            </label>
                            <div class="ms-2 d-inline-block">
                                <form id="searchForm" data-url="{{ route('admin.users.listapi') }}"
                                      method="get">
                                    <input class="form-control search-list" name="search" placeholder="cari...."
                                           id="search">
                                    <input type="hidden" name="route_name" class="route-name"
                                           value="PengaturanSimpanan">
                                    <input type="hidden" name="page" class="current-paginate">
                                    <input type="hidden" name="order" class="current-order-daftar-barang">
                                    <input type="hidden" name="order_state" class="current-order-state-daftar-barang"
                                           value="ASC">
                                    <input type="submit" class="d-none" value="submit">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="table-default" class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>NAK/username</th>
                            <th>role</th>
                            <th>Nama User</th>
                            <th colspan="3">Menu</th>
                        </tr>
                        </thead>
                        <tbody class="table-tbody">

                        </tbody>
                    </table>
                </div>
                <div class="card-footer d-flex justify-content-center" id="pagination-footer">
                    <ul class="pagination">

                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script src="{{asset('js/button.js')}}"></script>
    <script src="{{asset('js/tableApi.js')}}"></script>

    <script>
        var urlApi = "{{ route('admin.users.listapi') }}";

        @if(!Request::ajax())
        document.addEventListener("DOMContentLoaded", function () {
            @endif

            $(document).on('click', '.btn_page_detail', function (e) {
                e.preventDefault();

                let data = $(this).data('val')
                console.log(data)
                const showRoute = "{{route('admin.users.show',':id')}}"
                window.location.href = showRoute.replace(':id', data.id);
            })

            $("#searchForm").on('submit', function (e) {
                e.preventDefault();
                var dInput = $(this).find('#search').val();
                if (dInput.length > 3 || dInput.length === 0) {
                    $('.current-paginate').val(1);
                    $('.search-list').val(dInput);
                    setTimeout(function () {
                        table(urlApi)
                    }, 500)
                }
            })

            table(urlApi)
            @if(!Request::ajax())
        })
        @endif

    </script>

    @include('admin.users.modal.modalUser')
@endsection
