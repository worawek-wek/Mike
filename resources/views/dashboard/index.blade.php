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
                            <div class="col-xl-4 mb-4 col-lg-5 col-12">
                              <div class="card bg-light-danger">
                                <div class="d-flex align-items-end row">
                                  <div class="col-6" style="line-height: 2.2;">
                                    <div class="card-body text-nowrap">
                                      <h5 class="text-white card-title mb-0">มีห้องที่ค้างชำระ</h5>
                                      <p class="text-white mb-2">จำนวน</p>
                                      <h4 class="text-white mb-2">{{ $summary['all_overdue'] }} ห้อง</h4>
                                      <a href="dashboard/overdue" class="btn bg-label-warning text-black">รายละเอียด</a>
                                    </div>
                                  </div>
                                  <div class="col-5 text-center text-sm-left">
                                        <img src="../../assets/img/illustrations/girl-with-laptop.png" width="100%">
                                  </div>
                                </div>
                              </div>
                            </div>
                            <!-- View sales -->
            
                            <!-- Statistics -->
                            <div class="col-xl-8 mb-4 col-lg-7 col-12">
                              <div class="card h-100">
                                <div class="card-header">
                                  <div class="d-flex justify-content-between mb-3">
                                    <h5 class="card-title mb-0">สถิติ</h5>
                                    <small class="text-muted">Updated 1 month ago</small>
                                  </div>
                                </div>
                                <div class="card-body" style="padding-top: 28px;">
                                  <div class="row gy-3">
                                    <div class="col-md-3 col-6">
                                      <div class="d-flex align-items-center">
                                        <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;cursor: unset;">
                                            <span class="avatar-initial rounded bg-label-primary">
                                                <i class="ti ti-chart-pie-2 ti-md"></i>
                                            </span>
                                        </div>
                                        <div class="card-info">
                                          <h5 class="mb-0">{{ $summary['percent'] }} %</h5>
                                          <small>อัตราการเข้าพัก</small>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                      <div class="d-flex align-items-center">
                                        <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;cursor: unset;">
                                            <span class="avatar-initial rounded bg-label-info">
                                                <i class="ti ti-calendar-time ti-md"></i>
                                            </span>
                                        </div>
                                        <div class="card-info">
                                          <h5 class="mb-0">{{ $summary['all_booking_room'] }} ห้อง</h5>
                                          <small>ห้องจอง</small>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                      <div class="d-flex align-items-center">
                                        <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;" onclick="location.href='/dashboard/overdue';">
                                            <span class="avatar-initial rounded bg-label-danger">
                                                <i class="ti ti-report-money ti-md"></i>
                                            </span>
                                        </div>
                                        <div class="card-info">
                                          <h5 class="mb-0">{{ $summary['all_overdue'] }} ห้อง</h5>
                                          <small>ค้างชำระ</small>
                                        </div>
                                      </div>
                                    </div>
                                    <div class="col-md-3 col-6">
                                      <div class="d-flex align-items-center">
                                        <div class="avatar flex-shrink-0 me-3" style="width: 2.8rem;height: 2.8rem;cursor: unset;">
                                            <span class="avatar-initial rounded bg-label-success">
                                                <i class="ti ti-door ti-md"></i>
                                            </span>
                                        </div>
                                        <div class="card-info">
                                          <h5 class="mb-0">{{ $summary['vacant_room'] }} ห้อง</h5>
                                          <small>ห้องว่าง</small>
                                        </div>
                                      </div>
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
                                                        <h6 class="mb-0 fw">ชำระผ่านการโอนเงิน</h6>
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
                                                        <h6 class="mb-0 fw">ชำระด้วยเงินสด</h6>
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
                                            </span>{{ $summary['confirm_by_ceo_this_month'] }}<span class="h5"> บาท</span></h2>
                                        <div class="border-2 border-light border-bottom my-3"></div>
                                        <div
                                            class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                            <h5>ผู้เช่าค้างชำระค่าเช่า</h5>
                                            <h6 class="text-danger text-end">รวมเป็นเงิน {{ $summary['overdue_this_month'] }} บาท</h6>
                                        </div>
                                        <div class="card card-body bg-light-primary border-0 shadow-none py-5">
                                            <h2 class="text-center fw-semibold mb-0 text-white"><span
                                                    class="h5 text-white">รวมสุทธิ
                                                </span>{{ $summary['confirm_by_ceo_this_month'] }}<span class="h5 text-white"> บาท</span></h2>
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
                                        <div>
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

    var donutChart = new ApexCharts(document.querySelector("#chart01"), options);
    donutChart.render();
    </script>
    <script>
        
        var page = "{{$page_url}}/datatable";
        var searchData = {};

        loadData(page);
        // onYearChange(2025)
        function onYearChange(selectElement) {
            const year = selectElement.value;
            
            // อัปเดตหัวข้อ
            const titleElement = document.getElementById("income-summary-title");
            titleElement.textContent = `สรุปรายรับค่าเช่ารายเดือน มกราคม/${year} - ธันวาคม/${year}`;

            // เรียก AJAX โหลดข้อมูลใหม่ (ใส่ page_url ของคุณให้ถูก)
            loadData("{{ $page_url }}/datatable");
        }
        function loadData(pages){
            $('.p_search').each(function() {
                var inputName = $(this).attr('name'); // ดึงชื่อ attribute 'name' ของ input
                var inputValue = $(this).val(); // ดึงค่า value ของ input
                
                searchData[inputName] = inputValue; // เก็บข้อมูลลงในออบเจ็กต์ searchData
            });

            // alert(page);
            page = pages;
            $.ajax({
                type: "GET",
                url: pages,
                data: searchData,
                success: function(data) {
                    // $("#pills-profile").html(data);
                    renderChart(data)
                    // summary()
                }
            });
            // alert(page);
        }

    let chart; // ให้เป็นตัวแปร global เพื่อสามารถ update ได้

        function renderChart(data) {
            var options = {
                series: [{
                    data: data // ใช้ข้อมูลจาก Ajax
                }],
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
    </script>
</body>

</html>