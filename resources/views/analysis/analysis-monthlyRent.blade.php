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
                                        {{-- <div class="col-sm-3">
                                            <div class="input-group input-group-merge">
                                                <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                                        class="ti ti-calendar"></i></span>
                                                <input type="date" class="form-control" id="basic-icon-default-fullname"
                                                    placeholder="John Doe" aria-label="John Doe"
                                                    aria-describedby="basic-icon-default-fullname2">
                                            </div>
                                        </div> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- วิเคราะห์รายรับค่าเช่ารายเดือน -->
                            <div class="col-sm-8">
                                <div class="card mb-3">
                                    {{-- <div class="card-header d-flex justify-content-between">
                                        <div class="card-title mb-0">
                                            <h5 class="mb-0">วิเคราะห์รายรับค่าเช่ารายเดือน</h5>
                                            <small class="text-muted">เดือนพฤษภาคม 2024</small>
                                        </div>
                                    </div> --}}
                                    <div class="card-header d-flex justify-content-between">
                                        <div class="card-title mb-0">
                                            <h5 class="mb-0">วิเคราะห์รายรับค่าเช่ารายเดือน</h5>
                                            <small class="text-muted">
                                                @php
                                                    \Carbon\Carbon::setLocale('th');
                                                    $thaiDate = \Carbon\Carbon::now()->subMonth()->translatedFormat('F Y');
                                                @endphp
                                                <h4>{{ $thaiDate }}</h4>
                                            </small>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <ul class="p-0 m-0">
                                            <li class="d-flex mb-3">
                                                <div class="avatar flex-shrink-0 me-4">
                                                    <span class="avatar-initial rounded bg-light-success"><i
                                                            class="ti ti-building-bank ti-26px"></i></span>
                                                </div>
                                                <div
                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                    <div class="me-2">
                                                        <h6 class="mb-0 fw">ผู้เช่าชำระค่าเช่าแล้ว</h6>
                                                    </div>
                                                    <div class="user-progress">
                                                        <h6 class="text-light-success mb-0">{{ $summary['all_receipt_last_month'] }} บาท</h6>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                        <div class="border-2 border-light border-top my-3"></div>
                                        <h2 class="text-center fw-semibold mb-0"><span class="h5">รวม&nbsp;
                                            </span>{{ $summary['all_receipt_last_month'] }}<span class="h5"> บาท</span></h2>
                                        <div class="border-2 border-light border-bottom my-3"></div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <h5>ผู้เช่าค้างชำระค่าเช่า</h5>
                                            <h6 class="text-danger text-end">รวมเป็นเงิน {{ $summary['overdue_this_month'] }} บาท</h6>
                                        </div>
                                        <div class="card card-body bg-light-primary border-0 shadow-none py-5">
                                            <h2 class="text-center fw-semibold mb-0 text-white"><span
                                                    class="h5 text-white">รวมสุทธิ
                                                </span>{{ $summary['all_rent_bill_last_month'] }}<span class="h5 text-white"> บาท</span></h2>
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
                                            <h5 class="mb-0" id="income-summary-title">สรุปรายรับค่าเช่ารายเดือน มกราคม/{{ date('Y') }} - ธันวาคม/{{ date('Y') }}</h5>
                                        </div>
                                        <div style="display: flex;align-items: center;gap: 10px;">
                                            <label for="year">ปี:</label>
                                            <select onchange="onYearChange(this)" name="year" id="selectpickerFloor" class="select2 form-select form-select-lg p_search" data-style="btn-default">
                                                @for ($year = date('Y'); $year >= 2000; $year--)
                                                    <option value="{{ $year }}">{{ $year }}</option>
                                                @endfor
                                            </select>
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
        series: [60, 30, 10],
        labels: ['ลูกค้าจ่ายตรงเวลา', 'จ่ายล่าช้าแบบนัดเวลา', 'จ่ายละช้าแบบไม่ได้นัดเวลา'],
        colors: ['#BCE29E', '#ffb975', '#FF9494'],
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

    var donutChart = new ApexCharts(document.querySelector("#chart01"), options);
    donutChart.render();
    </script>
    <script>
            let chart = null; // Global ตัวแปรกราฟ

        // ฟังก์ชันสร้างกราฟ (เรียกแค่ครั้งเดียวตอนโหลดหน้า)
        function initChart() {
            const options = {
                series: [{ data: [] }], // เริ่มต้นไม่มีข้อมูล
                chart: {
                    type: 'bar',
                    height: 380
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
                    categories: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
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

            chart = new ApexCharts(document.querySelector("#chart02"), options);
            chart.render();
        }

        // ฟังก์ชันอัปเดตข้อมูลในกราฟแบบเร็ว
        function renderChart(data) {
            if (chart) {
                chart.updateSeries([{ data: data }]); // ✅ อัปเดตข้อมูลกราฟ
            }
        }

        // ฟังก์ชันดึงข้อมูลจาก server (ผ่าน AJAX)
        function loadData(pages){
            $('.p_search').each(function() {
                var inputName = $(this).attr('name');
                var inputValue = $(this).val();
                searchData[inputName] = inputValue;
            });

            $.ajax({
                type: "GET",
                url: pages,
                data: searchData,
                success: function(data) {
                    renderChart(data); // อัปเดต chart ด้วยข้อมูลใหม่
                }
            });
        }

        // เมื่อเลือกปีจาก dropdown
        function onYearChange(selectElement) {
            const year = selectElement.value;

            // อัปเดตหัวข้อรายปี
            const titleElement = document.getElementById("income-summary-title");
            titleElement.textContent = `สรุปรายรับค่าเช่ารายเดือน มกราคม/${year} - ธันวาคม/${year}`;

            // โหลดข้อมูลใหม่
            loadData("dashboard/monthly-rent-income");
        }

        // ตัวแปร global
        var searchData = {};
        var page = "dashboard/monthly-rent-income";

        // เริ่มต้นเมื่อโหลดหน้า
        document.addEventListener("DOMContentLoaded", function() {
            initChart();     // 🔁 สร้างกราฟเปล่าไว้ก่อน
            loadData(page);  // 📦 โหลดข้อมูลจริงผ่าน AJAX
        });
    </script>
</body>

</html>