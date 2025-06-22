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
                                                วิเคราะห์มิเตอร์ผู้เช่า
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- วิเคราะห์รายรับค่าเช่ารายเดือน -->
                            <div class="col-sm-12">
                                <ul class="nav nav-pills mb-3 nav-fill" role="tablist" id="tabMeter">
                                    <li class="nav-item">
                                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-pills-justified-tab1"
                                            aria-controls="navs-pills-justified-tab1" aria-selected="true">
                                            <i class="tf-icons ti ti-droplet me-1"></i> วิเคราะห์มิเตอร์น้ำของผู้เช่า
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-pills-justified-tab2"
                                            aria-controls="navs-pills-justified-tab2" aria-selected="false">
                                            <i class="tf-icons ti ti-plug me-1"></i> วิเคราะห์มิเตอร์ไฟฟ้าของผู้เช่า
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content bg-transparent p-0">
                                    <div class="tab-pane fade show active" id="navs-pills-justified-tab1"
                                        role="tabpanel">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-sm-2">
                                                <button type="button"
                                                    class="btn rounded-pill btn-icon btn-outline-secondary waves-effect"><i
                                                        class="tf-icons ti ti-chevron-left"></i></button>
                                            </div>
                                            <div class="col-sm-8 text-center">
                                                <h5 class="mb-0">มิเติอร์น้ำชั้น1</h5>
                                            </div>
                                            <div class="col-sm-2 text-end">
                                                <button type="button"
                                                    class="btn rounded-pill btn-icon btn-outline-secondary waves-effect"><i
                                                        class="tf-icons ti ti-chevron-right"></i></button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="card-title mb-0">
                                                            <h4 class="mb-0">ห้อง A101</h4>
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
                                                        <div id="chart01"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="card-title mb-0">
                                                            <h4 class="mb-0">ห้อง A102</h4>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="chart02"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="card-title mb-0">
                                                            <h4 class="mb-0">ห้องแม่บ้าน/รปภ</h4>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="chart03"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="card-title mb-0">
                                                            <h4 class="mb-0">ห้อง A103</h4>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="chart04"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="navs-pills-justified-tab2" role="tabpanel">
                                        <div class="row align-items-center mb-3">
                                            <div class="col-sm-2">
                                                <button type="button"
                                                    class="btn rounded-pill btn-icon btn-outline-secondary waves-effect"><i
                                                        class="tf-icons ti ti-chevron-left"></i></button>
                                            </div>
                                            <div class="col-sm-8 text-center">
                                                <h5 class="mb-0">มิเติอร์ไฟฟ้าชั้น1</h5>
                                            </div>
                                            <div class="col-sm-2 text-end">
                                                <button type="button"
                                                    class="btn rounded-pill btn-icon btn-outline-secondary waves-effect"><i
                                                        class="tf-icons ti ti-chevron-right"></i></button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="card-title mb-0">
                                                            <h4 class="mb-0">ห้อง A101</h4>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="chartE01"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="card-title mb-0">
                                                            <h4 class="mb-0">ห้อง A102</h4>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="chartE02"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="card-title mb-0">
                                                            <h4 class="mb-0">ห้องแม่บ้าน/รปภ</h4>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="chartE03"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="card-title mb-0">
                                                            <h4 class="mb-0">ห้อง A103</h4>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="chartE04"></div>
                                                    </div>
                                                </div>
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
            data: [280, 200, 220, 180, 270, 250, 70, 90, 200, 150, 160, 100]
        }],
        chart: {
            height: 400,
            type: 'line',
            parentHeightOffset: 0,
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        colors: ['#00BAD1'],
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
            categories: [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '10',
                '11',
                '12'
            ],
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px',
                    fontFamily: 'IBM Plex sans thai, sans-serif',
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px',
                    fontFamily: 'IBM Plex sans thai, sans-serif',
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart01"), options);
    chart.render();
    </script>
    <script>
    var options = {
        series: [{
            data: [280, 200, 220, 180, 270, 250, 70, 90, 200, 150, 160, 100]
        }],
        chart: {
            height: 400,
            type: 'line',
            parentHeightOffset: 0,
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        colors: ['#00BAD1'],
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
            categories: [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '10',
                '11',
                '12'
            ],
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px',
                    fontFamily: 'IBM Plex sans thai, sans-serif',
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px',
                    fontFamily: 'IBM Plex sans thai, sans-serif',
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart02"), options);
    chart.render();
    </script>
    <script>
    var options = {
        series: [{
            data: [280, 200, 220, 180, 270, 250, 70, 90, 200, 150, 160, 100]
        }],
        chart: {
            height: 400,
            type: 'line',
            parentHeightOffset: 0,
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        colors: ['#00BAD1'],
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
            categories: [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '10',
                '11',
                '12'
            ],
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px',
                    fontFamily: 'IBM Plex sans thai, sans-serif',
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px',
                    fontFamily: 'IBM Plex sans thai, sans-serif',
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart03"), options);
    chart.render();
    </script>
    <script>
    var options = {
        series: [{
            data: [280, 200, 220, 180, 270, 250, 70, 90, 200, 150, 160, 100]
        }],
        chart: {
            height: 400,
            type: 'line',
            parentHeightOffset: 0,
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        colors: ['#00BAD1'],
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
            categories: [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '10',
                '11',
                '12'
            ],
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px',
                    fontFamily: 'IBM Plex sans thai, sans-serif',
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px',
                    fontFamily: 'IBM Plex sans thai, sans-serif',
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart04"), options);
    chart.render();
    </script>

    <script>
    var options = {
        series: [{
            data: [280, 200, 220, 180, 270, 250, 70, 90, 200, 150, 160, 100]
        }],
        chart: {
            height: 400,
            type: 'line',
            parentHeightOffset: 0,
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        colors: ['#FF4C51'],
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
            categories: [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '10',
                '11',
                '12'
            ],
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px',
                    fontFamily: 'IBM Plex sans thai, sans-serif',
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px',
                    fontFamily: 'IBM Plex sans thai, sans-serif',
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chartE01"), options);
    chart.render();
    </script>
    <script>
    var options = {
        series: [{
            data: [280, 200, 220, 180, 270, 250, 70, 90, 200, 150, 160, 100]
        }],
        chart: {
            height: 400,
            type: 'line',
            parentHeightOffset: 0,
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        colors: ['#FF4C51'],
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
            categories: [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '10',
                '11',
                '12'
            ],
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px',
                    fontFamily: 'IBM Plex sans thai, sans-serif',
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px',
                    fontFamily: 'IBM Plex sans thai, sans-serif',
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chartE02"), options);
    chart.render();
    </script>
    <script>
    var options = {
        series: [{
            data: [280, 200, 220, 180, 270, 250, 70, 90, 200, 150, 160, 100]
        }],
        chart: {
            height: 400,
            type: 'line',
            parentHeightOffset: 0,
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        colors: ['#FF4C51'],
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
            categories: [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '10',
                '11',
                '12'
            ],
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px',
                    fontFamily: 'IBM Plex sans thai, sans-serif',
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px',
                    fontFamily: 'IBM Plex sans thai, sans-serif',
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chartE03"), options);
    chart.render();
    </script>
    <script>
    var options = {
        series: [{
            data: [280, 200, 220, 180, 270, 250, 70, 90, 200, 150, 160, 100]
        }],
        chart: {
            height: 400,
            type: 'line',
            parentHeightOffset: 0,
            zoom: {
                enabled: false
            },
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            curve: 'straight'
        },
        colors: ['#FF4C51'],
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
            categories: [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '10',
                '11',
                '12'
            ],
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px',
                    fontFamily: 'IBM Plex sans thai, sans-serif',
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px',
                    fontFamily: 'IBM Plex sans thai, sans-serif',
                }
            }
        }
    };

    var chart = new ApexCharts(document.querySelector("#chartE04"), options);
    chart.render();
    </script>

</body>

</html>