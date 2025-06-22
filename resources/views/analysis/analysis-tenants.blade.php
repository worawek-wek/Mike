<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template">

<head>
    @include('layout/inc_header')
    <title>Dashboard - CRM | Vuexy - Bootstrap Admin Template</title>

</head>

<body>
    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            @include('layout/inc_sidemenu')
            <!-- / Menu -->

            <!-- Layout container -->
            <div class="layout-page">
                <!-- Navbar -->

                @include('layout/inc_topmenu')

                <!-- / Navbar -->

                <!-- Content wrapper -->
                <div class="content-wrapper">
                    <!-- Content -->

                    <div class="container-xxl flex-grow-1 container-p-y">
                        <div class="row ">
                            <div class="col-sm-12">
                                <div class="card card-body mb-3">
                                    <div class="row g-3 justify-content-between">
                                        <div class="col-sm-12">
                                            <h4 class="mb-0">
                                                <i class="tf-icons ti ti-circle-half-2 text-main ti-md"></i>
                                                วิเคราะห์การเข้า-ออกผู้เช่า
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- วิเคราะห์รายรับค่าเช่ารายเดือน -->
                            <div class="col-sm-12">
                                <div class="card mb-3">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="card-title mb-0">
                                            <h5 class="mb-0">ข้อมูลการเข้า-ออกของผู้เช่า</h5>
                                        </div>
                                        <div class="btn-group">
                                            {{-- <button type="button" class="btn btn-label-secondary waves-effect">12
                                                เดือนย้อนหลัง</button>
                                            <button type="button"
                                                class="btn btn-label-secondary dropdown-toggle dropdown-toggle-split waves-effect"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <span class="visually-hidden">Toggle Dropdown</span>
                                            </button>
                                            <ul class="dropdown-menu" style="">
                                                <li><a class="dropdown-item waves-effect"
                                                        href="javascript:void(0);">January</a></li>
                                                <li><a class="dropdown-item waves-effect"
                                                        href="javascript:void(0);">February</a></li>
                                                <li><a class="dropdown-item waves-effect"
                                                        href="javascript:void(0);">March</a></li>
                                                <li><a class="dropdown-item waves-effect"
                                                        href="javascript:void(0);">April</a></li>
                                                <li><a class="dropdown-item waves-effect"
                                                        href="javascript:void(0);">May</a></li>
                                                <li><a class="dropdown-item waves-effect"
                                                        href="javascript:void(0);">June</a></li>
                                                <li><a class="dropdown-item waves-effect"
                                                        href="javascript:void(0);">July</a></li>
                                                <li><a class="dropdown-item waves-effect"
                                                        href="javascript:void(0);">August</a></li>
                                                <li><a class="dropdown-item waves-effect"
                                                        href="javascript:void(0);">September</a></li>
                                                <li><a class="dropdown-item waves-effect"
                                                        href="javascript:void(0);">October</a></li>
                                                <li><a class="dropdown-item waves-effect"
                                                        href="javascript:void(0);">November</a></li>
                                                <li><a class="dropdown-item waves-effect"
                                                        href="javascript:void(0);">December</a></li>
                                            </ul> --}}
                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                <label for="yearSelect">ปี</label>
                                            
                                            <select id="yearSelect" class="form-control"></select>

                                                <script>
                                                const yearSelect = document.getElementById("yearSelect");
                                                const currentYear = new Date().getFullYear();

                                                for (let year = currentYear; year >= 2020; year--) {
                                                    let option = new Option(year, year);
                                                    yearSelect.add(option);
                                                }
                                                </script>
                                        </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="chart01"></div>
                                    </div>
                                </div>
                            </div>
                            <!-- รายได้แยกตามประเภทการชำระ -->
                            <div class="col-sm-4 d-flex align-items-stretch">
                                <div class="card mb-3 w-100">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="card-title mb-0">
                                            <h5 class="mb-0">รายได้รวม</h5>
                                            <small class="text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="chart02"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-8 d-flex align-items-stretch">
                                <div class="card mb-3 w-100">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="card-title mb-0">
                                            <h5 class="mb-0">อายุ</h5>
                                            <small class="text-muted"></small>
                                        </div>

                                    </div>
                                    <div class="card-body">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">ไม่ระบุ</h6>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="progress" style="height: 8px">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: 25%;background-color:#FF7878" aria-valuenow="25"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <p class="mb-0 text-muted">25%</p>
                                            </div>
                                        </div>
                                        <div class="row align-items-center mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">30-34 ปี</h6>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="progress" style="height: 8px">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: 30%;background-color:#C6D57E" aria-valuenow="30"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <p class="mb-0 text-muted">30%</p>
                                            </div>
                                        </div>
                                        <div class="row align-items-center mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">25-29 ปี</h6>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="progress" style="height: 8px">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: 50%;background-color:#CAB8FF" aria-valuenow="50"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <p class="mb-0 text-muted">50%</p>
                                            </div>
                                        </div>
                                        <div class="row align-items-center mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">10-24 ปี</h6>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="progress" style="height: 8px">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: 10%;background-color:#F6AE99" aria-valuenow="10"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <p class="mb-0 text-muted">10%</p>
                                            </div>
                                        </div>
                                        <div class="row align-items-center mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">35-39 ปี</h6>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="progress" style="height: 8px">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: 15%;background-color:#FFC4E1" aria-valuenow="15"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <p class="mb-0 text-muted">15%</p>
                                            </div>
                                        </div>
                                        <div class="row align-items-center mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">40-49 ปี</h6>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="progress" style="height: 8px">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: 15%;background-color:#B5EAEA" aria-valuenow="15"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <p class="mb-0 text-muted">15%</p>
                                            </div>
                                        </div>
                                        <div class="row align-items-center mb-3">
                                            <div class="col-sm-2">
                                                <h6 class="mb-0">50 ปีขึ้นไป</h6>
                                            </div>
                                            <div class="col-sm-9">
                                                <div class="progress" style="height: 8px">
                                                    <div class="progress-bar" role="progressbar"
                                                        style="width: 5%;background-color:#F1CA89" aria-valuenow="5"
                                                        aria-valuemin="0" aria-valuemax="100"></div>
                                                </div>
                                            </div>
                                            <div class="col-sm-1">
                                                <p class="mb-0 text-muted">5%</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- / Content -->

                    <!-- Footer -->
                    @include('layout/inc_footer')
                    <!-- / Footer -->

                    <div class="content-backdrop fade"></div>
                </div>
                <!-- Content wrapper -->
            </div>
            <!-- / Layout page -->
        </div>

        <!-- Overlay -->
        <div class="layout-overlay layout-menu-toggle"></div>

        <!-- Drag Target Area To SlideIn Menu On Small Screens -->
        <div class="drag-target"></div>
    </div>
    <!-- / Layout wrapper -->
    @include('layout/inc_js')
    <script>
    var options = {
        series: [{
                name: "ผู้เช่าเข้า",
                data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
            },
            {
                name: "ผู้เช่าออก",
                data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
            },
        ],
        chart: {
            height: 350,
            type: 'line',
            zoom: {
                enabled: false
            },
        },
        dataLabels: {
            enabled: false
        },
        colors: ['#BCE29E', '#FFB3B3'],
        stroke: {
            width: [2, 2],
            curve: 'smooth'
        },
        legend: {
            tooltipHoverFormatter: function(val, opts) {
                return val + ' - <strong>' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] +
                    '</strong>'
            }
        },
        markers: {
            size: 0,
            hover: {
                sizeOffset: 6
            }
        },
        xaxis: {
            categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9',
                '10', '11', '12'
            ],
        },
        tooltip: {
            y: [{
                    title: {
                        formatter: function(val) {
                            return val + " (mins)"
                        }
                    }
                },
                {
                    title: {
                        formatter: function(val) {
                            return val + " per session"
                        }
                    }
                },
                {
                    title: {
                        formatter: function(val) {
                            return val;
                        }
                    }
                }
            ]
        },
        grid: {
            borderColor: '#f1f1f1',
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart01"), options);
    chart.render();
    </script>
    <script>
    var options = {
        series: [60, 28, 12],
        labels: ['หญิง', 'ชาย', 'ไม่ระบุ'],
        colors: ['#FFB3B3', '#8CC0DE', '#F1F0F2'],
        chart: {
            type: 'donut',
            height: '450px'
        },
        stroke: {
            show: false,
            curve: 'straight'
        },
        dataLabels: {
            enabled: true,
            formatter: function(val, opt) {
                return parseInt(val, 10) + '%';
            }
        },
        legend: {
            show: true,
            position: 'bottom',
            fontFamily: 'IBM Plex Sans Thai',
            markers: {
                offsetX: -3
            },
            itemMargin: {
                vertical: 3,
                horizontal: 10
            },
            labels: {
                useSeriesColors: false,
            }
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show: true,
                        name: {
                            fontSize: '2rem',
                            fontFamily: 'IBM Plex Sans Thai'
                        },
                        value: {
                            fontSize: '1.2rem',
                            fontFamily: 'IBM Plex Sans Thai',
                            formatter: function(val) {
                                return parseInt(val, 10) + '%';
                            }
                        },

                    }
                }
            }
        },
        responsive: [{
                breakpoint: 992,
                options: {
                    chart: {
                        height: 380
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            useSeriesColors: false
                        }
                    }
                }
            },
            {
                breakpoint: 576,
                options: {
                    chart: {
                        height: 320
                    },
                    plotOptions: {
                        pie: {
                            donut: {
                                labels: {
                                    show: true,
                                    name: {
                                        fontSize: '1.5rem'
                                    },
                                    value: {
                                        fontSize: '1rem'
                                    },
                                    total: {
                                        fontSize: '1.5rem'
                                    }
                                }
                            }
                        }
                    },
                    legend: {
                        position: 'bottom',
                        labels: {
                            useSeriesColors: false
                        }
                    }
                }
            },
            {
                breakpoint: 420,
                options: {
                    chart: {
                        height: 280
                    },
                    legend: {
                        show: false
                    }
                }
            },
            {
                breakpoint: 360,
                options: {
                    chart: {
                        height: 250
                    },
                    legend: {
                        show: false
                    }
                }
            }
        ]
    };

    var chart = new ApexCharts(document.querySelector("#chart02"), options);
    chart.render();
    </script>



</body>

</html>