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
                                        <div class="col-sm-6">
                                            <h4 class="mb-0">
                                                <i class="tf-icons ti ti-circle-half-2 text-main ti-md"></i>
                                                วิเคราะห์ค่าเช่ารายเดือน
                                            </h4>
                                        </div>
                                        <div class="col-sm-3">
                                            <div class="input-group input-group-merge">
                                                <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                                        class="ti ti-calendar"></i></span>
                                                <input type="date" class="form-control" id="basic-icon-default-fullname"
                                                    placeholder="John Doe" aria-label="John Doe"
                                                    aria-describedby="basic-icon-default-fullname2">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- วิเคราะห์รายรับค่าเช่ารายเดือน -->
                            <div class="col-sm-8">
                                <div class="card mb-3">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="card-title mb-0">
                                            <h5 class="mb-0">วิเคราะห์รายรับค่าเช่ารายเดือน</h5>
                                            <small class="text-muted">เดือนพฤษภาคม 2024</small>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="p-0 m-0">
                                            <li class="d-flex mb-3">
                                                <div class="avatar flex-shrink-0 me-4">
                                                    <span class="avatar-initial rounded bg-light-danger"><i
                                                            class="ti ti-building-bank ti-26px"></i></span>
                                                </div>
                                                <div
                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2">
                                                        <h6 class="mb-0 fw-normal">ชำระผ่านการโอนเงิน</h6>
                                                        <small class="text-muted fw-normal d-block">
                                                            80 ห้อง
                                                        </small>
                                                    </div>
                                                    <div class="user-progress">
                                                        <h6 class="text-light-danger mb-0">5,401 บาท</h6>
                                                    </div>
                                                </div>
                                            </li>
                                            <li class="d-flex mb-3">
                                                <div class="avatar flex-shrink-0 me-4">
                                                    <span class="avatar-initial rounded bg-light-success"><i
                                                            class="ti ti-currency-dollar ti-26px"></i></span>
                                                </div>
                                                <div
                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2">
                                                        <h6 class="mb-0 fw-normal">ชำระด้วยเงินสด</h6>
                                                        <small class="text-muted fw-normal d-block">
                                                            45 ห้อง
                                                        </small>
                                                    </div>
                                                    <div class="user-progress">
                                                        <h6 class="text-light-success mb-0">17,871 บาท</h6>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="border-2 border-light border-top my-3"></div>
                                        <h2 class="text-center fw-semibold mb-0"><span class="h5">รวม
                                            </span>933,584<span class="h5"> บาท</span></h2>
                                        <div class="border-2 border-light border-bottom my-3"></div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <h5>ผู้เช่าค้างชำระค่าเช่า</h5>
                                            <h6 class="text-danger text-end">รวมเป็นเงิน 910,312 บาท</h6>
                                        </div>
                                        <div class="card card-body bg-light-primary border-0 shadow-none py-5">
                                            <h2 class="text-center fw-semibold mb-0 text-white"><span
                                                    class="h5 text-white">รวมสุทธิ
                                                </span>933,584<span class="h5 text-white"> บาท</span></h2>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- รายได้แยกตามประเภทการชำระ -->
                            <div class="col-sm-4 d-flex align-items-stretch">
                                <div class="card mb-3 w-100">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="card-title mb-0">
                                            <h5 class="mb-0">รายได้แยกตามประเภทการชำระ</h5>
                                            <small class="text-muted"></small>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div id="chart01"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- Sales last 6 months -->
                            <div class="col-md-12 mb-4">
                                <div class="card h-100">
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="card-title mb-0">
                                            <h5 class="mb-0">สรุปรายรับค่าเช่ารายเดือน มิถุนายน/2023 - พฤษภาคม/2024</h5>
                                        </div>
                                            {{-- <div class="input-group input-group-merge">
                                                <span class="input-group-text" id="basic-addon-search31"><i
                                                        class="ti ti-calendar-event"></i></span>
                                                <input type="text" id="bs-rangepicker-basic" class="form-control">
                                            </div> --}}
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
                                    <div class="card-body">
                                        <div id="chart02"></div>
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
        series: [72, 28],
        labels: ['โอนเงิน', 'เงินสด'],
        colors: ['#FF9494', '#BCE29E'],
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
                        total: {
                            show: true,
                            fontSize: '1rem',
                            fontFamily: 'IBM Plex Sans Thai',
                            color: '#2F2B3D',
                            fontWeight: 600,
                            label: 'ภาพรวมรายได้',
                            formatter: function(w) {
                                return '72%';
                            }
                        }
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

    var chart = new ApexCharts(document.querySelector("#chart01"), options);
    chart.render();
    </script>
    <script>
    var options = {
        series: [{
            data: [400, 100, 220, 260, 180, 110, 40, 150, 180, 250, 320, 0]
        }],
        chart: {
            type: 'bar',
            height: 380,
        },
        plotOptions: {
            bar: {
                borderRadius: 8,
                horizontal: false,
                columnWidth: '20px',
                startingShape: 'rounded',
            },
        },
        dataLabels: {
            enabled: false
        },
        colors: ['#BCE29E'],
        grid: {
            borderColor: '#ececed',
            xaxis: {
                lines: {
                    show: true
                }
            },
            padding: {
                top: -20
            }
        },
        xaxis: {
            categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10','11', '12'],
        },
        yaxis: {
            title: {
                text: '฿ (บาท)',
                style: {
                    fontSize: '12px',
                    fontFamily: 'IBM plex sans thai',
                    fontWeight: 600,
                },
            }
        },
        fill: {
            opacity: 1
        },
        tooltip: {
            y: {
                formatter: function(val) {
                    return "฿ " + val
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart02"), options);
    chart.render();
    </script>
</body>

</html>