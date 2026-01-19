@extends('layouts.admin_new')
@section('style')
@endsection

@section('content')
    <div class="row">
        <div class="col-12 col-md-6 column-gap-6">
            <div class="row row-cols-2 h-auto">
                <div class="col mb-6">
                    <div class="card card-border-shadow-primary h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-primary"><i
                                            class="ri-team-line ri-24px"></i></span>
                                </div>
                                <h4 class="mb-0">{{$total_siswa}}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Data Siswa</h6>
                        </div>
                        <a class="stretched-link" href="{{route('admin.master-data.data-siswa.index')}}"></a>
                    </div>
                </div>
                <div class="col mb-6">
                    <div class="card card-border-shadow-warning h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-warning"><i
                                            class="ri-school-line ri-24px"></i></span>
                                </div>
                                <h4 class="mb-0">{{$total_kelas}}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Data Kelas</h6>
                        </div>
                        <a class="stretched-link" href="{{route('admin.master-data.master-kelas.index')}}"></a>
                    </div>
                </div>
                <div class="col mb-6">
                    <div class="card card-border-shadow-info h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-info"><i
                                            class="ri-calendar-line ri-24px"></i></span>
                                </div>
                                <h4 class="mb-0">{{$total_tahun_aka}}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Data Tahun AKademik</h6>
                        </div>
                        <a class="stretched-link" href="{{route('admin.master-data.tahun-akademik.index')}}"></a>
                    </div>
                </div>
                <div class="col mb-6">
                    <div class="card card-border-shadow-secondary h-100">
                        <div class="card-body">
                            <div class="d-flex align-items-center mb-2">
                                <div class="avatar me-4">
                                    <span class="avatar-initial rounded-3 bg-label-secondary"><i
                                            class="ri-bill-line ri-24px"></i></span>
                                </div>
                                <h4 class="mb-0">{{$total_post}}</h4>
                            </div>
                            <h6 class="mb-0 fw-normal">Data Post</h6>
                        </div>
                        <a class="stretched-link" href="{{route('admin.master-data.master-post.index')}}"></a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title m-0">Pembayaran Baru</h5>
                </div>
                <div class="card-body py-3 mb-3" style="max-height: 350px;  overflow-y: auto;">
                    <ul class="timeline pb-0 mb-0">
                        @if(isset($tagihan_baru_dibayar))
                            @php
                                $codes = [
                                    '1140000' => 'Manual Cash',
                                    '1140001' => 'Manual BMI',
                                    '1140002' => 'Manual SALDO',
                                    '1140003' => 'Transfer Bank Lain',
                                    '1140004' => 'INFAQ',
                                    '1200001' => 'Loket Manual - Beasiswa',
                                    '1200002' => 'Loket Manual - Potongan',
                                ];
                            @endphp
                            @if($tagihan_baru_dibayar->count() == 0)
                                <li class="timeline-item timeline-item-transparent border-transparent">
                                    <span class="timeline-point timeline-point-gray"></span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-2">
                                            <h6 class="mb-0">Tidak ada tagihan yang baru dibayar</h6>
                                        </div>
                                    </div>
                                </li>
                            @endif
                            @foreach($tagihan_baru_dibayar as $item)
                                <li class="timeline-item timeline-item-transparent border-gray">
                                    <span class="timeline-point timeline-point-success"></span>
                                    <div class="timeline-event">
                                        <div class="timeline-header mb-2">
                                            <h6 class="mb-0">{{$item->BILLNM}}</h6>
                                            <small
                                                class="text-dark">{{ \Carbon\Carbon::parse($item->PAIDDT)->isoFormat('dddd, D MMMM YYYY')}}</small>
                                        </div>
                                        <p>@rupiah($item->PAIDAM)
                                            || {{isset($codes[$item->FIDBANK]) ? $codes[$item->FIDBANK] : 'Virtual Account'}}</p>
                                        <p class="mt-1 mb-2">{{$item->nama}} - {{$item->nis}} | kelas - Angkatan</p>
                                    </div>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-6 mb-6">
            <div class="card h-100">
                <div class="card-header">
                    <h5 class="card-title m-0">Tagihan</h5>
                </div>
                <div class="card-body h-100">
                    <div class="row mb-3">
                        <div class="d-flex justify-content-between flex-wrap gap-2">
                            <p class="d-block mb-0 text-body">Jumlah Tagihan</p>
                        </div>
                        <h4 class="mb-0">{{$jumlah_tagihan_cicil + $jumlah_tagihan_non_cicil}}</h4>
                    </div>
                    <div class="row mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-twitter rounded">
                                    <i class="ri-file-copy-2-line ri-24px"></i>
                                </div>
                            </div>
                            <div class="card-info">
                                <h5 class="mb-0">{{$jumlah_tagihan_cicil}}</h5>
                                <p class="mb-0">Tagihan Cicilan</p>
                            </div>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="d-flex align-items-center gap-3">
                            <div class="avatar">
                                <div class="avatar-initial bg-label-twitter rounded">
                                    <i class="ri-file-list-line ri-24px"></i>
                                </div>
                            </div>
                            <div class="card-info">
                                <h5 class="mb-0">{{$jumlah_tagihan_non_cicil}}</h5>
                                <p class="mb-0">Tagihan Non-Cicilan</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    @php
                        $total_tagihan = $jumlah_tagihan_cicil + $jumlah_tagihan_non_cicil;
                        if ($total_tagihan > 0) {
                            $persenDibayar = round($jumlah_tagihan_dibayar / $total_tagihan * 100, 2);
                            $persenBelumDibayar = round($jumlah_tagihan_belum_dibayar / $total_tagihan * 100, 2);
                        } else {
                            $persenDibayar = 0;
                            $persenBelumDibayar = 0;
                        }
                    @endphp
                    <div class="row">
                        <div class="col-4">
                            <div class="d-flex gap-2 align-items-center mb-2">
                                <div class="avatar avatar-xs flex-shrink-0">
                                    <div class="avatar-initial rounded bg-label-success">
                                        <i class="ri-check-line ri-24px"></i>
                                    </div>
                                </div>
                                <p class="mb-0">Dibayar {{$jumlah_tagihan_dibayar??0}}
                                    - {{$jumlah_tagihan_cicil + $jumlah_tagihan_non_cicil}}</p>
                            </div>
                            <h4 class="mb-2">{{$persenDibayar}}%</h4>
                        </div>
                        <div class="col-4">
                            <div class="divider divider-vertical">
                                <div class="divider-text">
                                    <span class="badge-divider-bg">*-*</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="d-flex gap-2 justify-content-end align-items-center mb-2">
                                <p class="mb-0">Belum Dibayar</p>
                                <div class="avatar avatar-xs flex-shrink-0">
                                    <div class="avatar-initial rounded bg-label-danger">
                                        <i class="ri-close-line ri-16px"></i>
                                    </div>
                                </div>
                            </div>
                            <h4 class="mb-2">{{$persenBelumDibayar}}%</h4>
                        </div>
                    </div>
                    <div class="d-flex align-items-center mt-4">
                        <div class="progress w-100 rounded" style="height: 12px;">
                            <div class="progress-bar bg-success" style="width: {{$persenDibayar}}%" role="progressbar"
                                 aria-valuenow="{{$persenDibayar}}" aria-valuemin="0" aria-valuemax="100"></div>
                            <div class="progress-bar bg-danger" role="progressbar"
                                 style="width: {{$persenBelumDibayar}}%" aria-valuenow="{{$persenBelumDibayar}}"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-6 col-xxl-6 mb-6 order-3 order-xxl-1">
            <div class="card h-100">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2 mb-1">Tagihan Baru</h5>
                        <p class="text-body mb-0">Total tagihan baru</p>
                    </div>
                </div>
                <div class="card-body">
                    <div id="tagihan_baru"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xxl-6 mb-7 order-3 order-xxl-1">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2 mb-1">Tagihan Dibayar</h5>
                        <p class="text-body mb-0">Total tagihan yang dibayar</p>
                    </div>
                </div>
                <div class="card-body">
                    <div id="tagihan_dibayar"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
    <script src="{{asset('main/vendor/libs/apex-charts/apexcharts.js')}}"></script>

    <script>
        let labelColor, headingColor, currentTheme, bodyColor;

        if (isDarkStyle) {
            labelColor = config.colors_dark.textMuted;
            headingColor = config.colors_dark.headingColor;
            bodyColor = config.colors_dark.bodyColor;
            currentTheme = 'dark';
        } else {
            labelColor = config.colors.textMuted;
            headingColor = config.colors.headingColor;
            bodyColor = config.colors.bodyColor;
            currentTheme = 'light';
        }

        // Chart Colors
        const chartColors = {
            donut: {
                series1: config.colors.success,
                series2: '#43ff64e6',
                series3: '#43ff6473',
                series4: '#43ff6433'
            },
            line: {
                series1: config.colors.success,
                series2: config.colors.primary,
                series3: '#7367f029'
            }
        };
    </script>
    <script>
        const shipmentEl = document.querySelector('#tagihan_baru'),
            shipmentConfig = {
                series: [
                    {
                        name: 'Tagihan Baru',
                        type: 'column',
                        data: [
                            @foreach($chartTagihanDibuat as $item)
                                {{$item['count']}},
                            @endforeach
                        ]
                    },
                ],
                chart: {
                    height: 270,
                    type: 'bar',
                    stacked: false,
                    parentHeightOffset: 0,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                legend: {
                    show: true,
                    position: 'bottom',
                    markers: {
                        width: 8,
                        height: 8,
                        offsetX: -3
                    },
                    height: 40,
                    offsetY: 10,
                    itemMargin: {
                        horizontal: 10,
                        vertical: 0
                    },
                    fontSize: '15px',
                    fontFamily: 'Inter',
                    fontWeight: 400,
                    labels: {
                        colors: headingColor,
                        useSeriesColors: false
                    },
                    offsetY: 10
                },
                grid: {
                    strokeDashArray: 8
                },
                colors: [chartColors.line.series1],
                fill: {
                    opacity: [1, 1]
                },
                plotOptions: {
                    bar: {
                        columnWidth: '30%',
                        startingShape: 'rounded',
                        endingShape: 'rounded',
                        borderRadius: 4
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    tickAmount: 10,
                    categories: [
                        @foreach($chartTagihanDibuat as $item)
                            '{{$item['date']??'-'}}',
                        @endforeach
                    ],
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '13px',
                            fontFamily: 'Inter',
                            fontWeight: 400
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    tickAmount: 4,
                    min: 1,
                    max: 100,
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '13px',
                            fontFamily: 'Inter',
                            fontWeight: 400
                        },
                        // formatter: function (val) {
                        //     return val + '%';
                        // }
                    }
                },
                responsive: [
                    {
                        breakpoint: 1400,
                        options: {
                            chart: {
                                height: 270
                            },
                            xaxis: {
                                labels: {
                                    style: {
                                        fontSize: '10px'
                                    }
                                }
                            },
                            legend: {
                                itemMargin: {
                                    vertical: 0,
                                    horizontal: 10
                                },
                                fontSize: '13px',
                                offsetY: 12
                            }
                        }
                    },
                    {
                        breakpoint: 1399,
                        options: {
                            chart: {
                                height: 415
                            },
                            plotOptions: {
                                bar: {
                                    columnWidth: '50%'
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 982,
                        options: {
                            plotOptions: {
                                bar: {
                                    columnWidth: '30%'
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 480,
                        options: {
                            chart: {
                                height: 250
                            },
                            legend: {
                                offsetY: 7
                            }
                        }
                    }
                ]
            };
        if (typeof shipmentEl !== undefined && shipmentEl !== null) {
            const shipment = new ApexCharts(shipmentEl, shipmentConfig);
            shipment.render();
        }
    </script>
    <script>
        const tagihanBaru = document.querySelector('#tagihan_dibayar'),
            tagihanBaruConfig = {
                series: [
                    {
                        name: 'Tagihan Baru',
                        type: 'column',
                        data: [
                            @foreach($chartTagihanDibayar as $item)
                                {{$item['count']??0}},
                            @endforeach
                        ]
                    },
                ],
                chart: {
                    height: 270,
                    type: 'bar',
                    stacked: false,
                    parentHeightOffset: 0,
                    toolbar: {
                        show: false
                    },
                    zoom: {
                        enabled: false
                    }
                },
                legend: {
                    show: true,
                    position: 'bottom',
                    markers: {
                        width: 8,
                        height: 8,
                        offsetX: -3
                    },
                    height: 40,
                    offsetY: 10,
                    itemMargin: {
                        horizontal: 10,
                        vertical: 0
                    },
                    fontSize: '15px',
                    fontFamily: 'Inter',
                    fontWeight: 400,
                    labels: {
                        colors: headingColor,
                        useSeriesColors: false
                    },
                    offsetY: 10
                },
                grid: {
                    strokeDashArray: 8
                },
                colors: [chartColors.line.series2],
                fill: {
                    opacity: [1, 1]
                },
                plotOptions: {
                    bar: {
                        columnWidth: '30%',
                        startingShape: 'rounded',
                        endingShape: 'rounded',
                        borderRadius: 4
                    }
                },
                dataLabels: {
                    enabled: false
                },
                xaxis: {
                    tickAmount: 10,
                    categories: [
                        @foreach($chartTagihanDibayar as $item)
                            '{{$item['date']??'-'}}',
                        @endforeach
                    ],
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '13px',
                            fontFamily: 'Inter',
                            fontWeight: 400
                        }
                    },
                    axisBorder: {
                        show: false
                    },
                    axisTicks: {
                        show: false
                    }
                },
                yaxis: {
                    tickAmount: 4,
                    min: 1,
                    max: 100,
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '13px',
                            fontFamily: 'Inter',
                            fontWeight: 400
                        },
                        // formatter: function (val) {
                        //     return val + '%';
                        // }
                    }
                },
                tooltip: {
                    enabled: true,
                    y: {
                        formatter: function (val) {
                            return val; // Display percentage value in tooltip
                        }
                    },
                    custom: function ({series, seriesIndex,}) {
                        return '<div class="custom-tooltip">' +
                            '<span>' + options.labels[seriesIndex] + '</span>' +
                            '<br>' +
                            '<span>Jumlah :' + series[seriesIndex] + '</span>' +
                            '</div>';
                    }
                },
                responsive: [
                    {
                        breakpoint: 1400,
                        options: {
                            chart: {
                                height: 270
                            },
                            xaxis: {
                                labels: {
                                    style: {
                                        fontSize: '10px'
                                    }
                                }
                            },
                            legend: {
                                itemMargin: {
                                    vertical: 0,
                                    horizontal: 10
                                },
                                fontSize: '13px',
                                offsetY: 12
                            }
                        }
                    },
                    {
                        breakpoint: 1399,
                        options: {
                            chart: {
                                height: 415
                            },
                            plotOptions: {
                                bar: {
                                    columnWidth: '50%'
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 982,
                        options: {
                            plotOptions: {
                                bar: {
                                    columnWidth: '30%'
                                }
                            }
                        }
                    },
                    {
                        breakpoint: 480,
                        options: {
                            chart: {
                                height: 250
                            },
                            legend: {
                                offsetY: 7
                            }
                        }
                    }
                ]
            };
        if (typeof tagihanBaru !== undefined && tagihanBaru !== null) {
            const shipment = new ApexCharts(tagihanBaru, tagihanBaruConfig);
            shipment.render();
        }
    </script>

    {{$chartTagihanDibuat}}
@endsection
