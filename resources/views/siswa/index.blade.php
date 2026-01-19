@extends('layouts.admin_new')
@section('style')
@endsection

@section('content')
    <div class="row g-6">
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="card card-border-shadow-primary h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded-3 bg-label-primary"><i
                                        class="ri-team-line ri-24px"></i></span>
                            </div>
                            <h4 class="mb-0">42</h4>
                        </div>
                        <h6 class="mb-0 fw-normal">Siswa Aktif</h6>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card card-border-shadow-warning h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded-3 bg-label-warning"><i
                                        class="ri-alert-line ri-24px"></i></span>
                            </div>
                            <h4 class="mb-0">8</h4>
                        </div>
                        <h6 class="mb-0 fw-normal">Vehicles with errors</h6>
                        <p class="mb-0">
                            <span class="me-1 fw-medium">-8.7%</span>
                            <small class="text-muted">than last week</small>
                        </p>
                    </div>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3">
                <div class="card card-border-shadow-success h-100">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-2">
                            <div class="avatar me-4">
                                <span class="avatar-initial rounded-3 bg-label-success"><i
                                        class="ri-alert-line ri-24px"></i></span>
                            </div>
                            <h4 class="mb-0">8</h4>
                        </div>
                        <h6 class="mb-0 fw-normal">Vehicles with errors</h6>
                        <p class="mb-0">
                            <span class="me-1 fw-medium">-8.7%</span>
                            <small class="text-muted">than last week</small>
                        </p>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-lg-6 col-xxl-6 mb-4 order-3 order-xxl-1">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2 mb-1">Tagihan Baru</h5>
                        <p class="text-body mb-0">Total number of deliveries 23.8k</p>
                    </div>
                </div>
                <div class="card-body">
                    <div id="tagihan_baru"></div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 col-xxl-6 mb-4 order-3 order-xxl-1">
            <div class="card">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <div class="card-title mb-0">
                        <h5 class="m-0 me-2 mb-1">Tagihan Dibayar</h5>
                        <p class="text-body mb-0">Total number of deliveries 23.8k</p>
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
                series1: config.colors.warning,
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
                        data: [38, 45, 33, 38, 32, 50, 48, 40, 42, 37]
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
                    categories: ['1 Jan', '2 Jan', '3 Jan', '4 Jan', '5 Jan', '6 Jan', '7 Jan', '8 Jan', '9 Jan', '10 Jan'],
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
                    min: 10,
                    max: 50,
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '13px',
                            fontFamily: 'Inter',
                            fontWeight: 400
                        },
                        formatter: function (val) {
                            return val + '%';
                        }
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
                        data: [38, 45, 33, 38, 32, 50, 48, 40, 42, 37]
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
                    categories: ['1 Jan', '2 Jan', '3 Jan', '4 Jan', '5 Jan', '6 Jan', '7 Jan', '8 Jan', '9 Jan', '10 Jan'],
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
                    min: 10,
                    max: 50,
                    labels: {
                        style: {
                            colors: labelColor,
                            fontSize: '13px',
                            fontFamily: 'Inter',
                            fontWeight: 400
                        },
                        formatter: function (val) {
                            return val + '%';
                        }
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
            const shipment = new ApexCharts(tagihanBaru, shipmentConfig);
            shipment.render();
        }
    </script>
@endsection
