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
                                                วิเคราะห์ค่าไฟ
                                            </h4>
                                        </div>
                                        
                                        <div class="col-sm-2 text-end">
                                            <div class="input-group input-group-merge">
                                                <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                                        class="ti ti-calendar"></i></span>
                                                <select onchange="onYearChange()" name="year" class="form-select form-select-lg p_search" data-style="btn-default">
                                                    @for ($year = date('Y'); $year >= 2010; $year--)
                                                        <option value="{{ $year }}">{{ $year }}</option>
                                                    @endfor
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <form id="insert_electricity_bill" enctype="multipart/form-data">
                                        <div class="row g-3">
                                            <div class="col-sm-6">
                                                <label for="use_unit"
                                                    class="form-label">จำนวนการใช้ไฟฟ้าทั้งหมด (หน่วย)</label> <span class="text-danger">*</span>
                                                <input type="text" name="use_unit" class="form-control" id="use_unit" placeholder="0" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="amount" class="form-label">รายจ่ายการไฟฟ้า
                                                    (บาท)</label> <span class="text-danger">*</span>
                                                <input type="text" name="amount" class="form-control" id="amount" placeholder="0" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="payment_date"
                                                    class="form-label">วันที่จ่าย</label> <span class="text-danger">*</span>
                                                <input type="text" name="payment_date" class="form-control datepicker" id="payment_date" placeholder="dd/mm/yyyy" autocomplete="off" required>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="slip"
                                                    class="form-label">ใบเสร็จการไฟฟ้า</label> <span class="text-danger">*</span>
                                                <input type="file" name="slip" class="form-control" id="slip" placeholder="0" required>
                                            </div>
                                            <div class="col-sm-12 text-center">
                                                <button type="submit" class="btn btn-main">บันทึก</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <!-- วิเคราะห์รายรับค่าเช่ารายเดือน -->
                            <div class="col-sm-12">
                                {{-- <ul class="nav nav-pills mb-3 nav-fill" role="tablist" id="tabMeter">
                                    <li class="nav-item">
                                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-pills-justified-tab1"
                                            aria-controls="navs-pills-justified-tab1" aria-selected="true">
                                            <i class="tf-icons ti ti-droplet me-1"></i> วิเคราะหค่าน้ำ
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab"
                                            data-bs-target="#navs-pills-justified-tab2"
                                            aria-controls="navs-pills-justified-tab2" aria-selected="false">
                                            <i class="tf-icons ti ti-plug me-1"></i> วิเคราะห์ค่าไฟ
                                        </button>
                                    </li>
                                </ul> --}}
                                <div class="tab-content bg-transparent p-0">
                                    <div class="tab-pane fade show active" id="navs-pills-justified-tab1"
                                        role="tabpanel">
                                        <div class="row g-3">
                                            <div class="col-sm-4">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="card-title mb-0">
                                                            <h5 class="mb-0">การใช้ไฟฟ้า</h5>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="chart01"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-8 d-flex align-items-stretch">
                                                <div class="card mb-3 w-100">
                                                    <div class="card-body">
                                                        <ul class="p-0 m-0">
                                                            <li class="d-flex mb-3">
                                                                <div class="avatar flex-shrink-0 me-4">
                                                                    <span
                                                                        class="avatar-initial rounded bg-light-danger"><i
                                                                            class="ti ti-cash-banknote ti-26px"></i></span>
                                                                </div>
                                                                <div
                                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                                    <div class="me-2">
                                                                        <h6 class="mb-0 fw-normal">
                                                                            รายรับค่าไฟฟ้าจากผู้เช่า
                                                                        </h6>
                                                                    </div>
                                                                    <div class="user-progress">
                                                                        <h6 class="text-light-danger mb-0 total_income">
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="d-flex mb-3">
                                                                <div class="avatar flex-shrink-0 me-4">
                                                                    <span
                                                                        class="avatar-initial rounded bg-light-success"><i
                                                                            class="ti ti-currency-dollar ti-26px"></i></span>
                                                                </div>
                                                                <div
                                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                                    <div class="me-2">
                                                                        <h6 class="mb-0 fw-normal">รายจ่ายการไฟฟ้า</h6>
                                                                    </div>
                                                                    <div class="user-progress">
                                                                        <h6 class="text-light-success mb-0 total_expense">
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="d-flex">
                                                                <div class="avatar flex-shrink-0 me-4">
                                                                    <span
                                                                        class="avatar-initial rounded bg-label-warning"><i
                                                                            class="ti ti-percentage ti-26px"></i></span>
                                                                </div>
                                                                <div
                                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                                    <div class="me-2">
                                                                        <h6 class="mb-0 fw-normal">กำไร/ขาดทุน
                                                                            ค่าไฟฟ้า</h6>
                                                                    </div>
                                                                    <div class="user-progress">
                                                                        <h6 class="text-warning mb-0 total_income-total_expense">
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="card-title mb-0">
                                                            <h5 class="mb-0">กำไร/ขาดทุนของค่าไฟฟ้า (บาท)</h5>
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
                                            <div class="col-sm-6">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="card-title mb-0">
                                                            <h5 class="mb-0">รายจ่ายการไฟฟ้า (บาท)</h5>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="chart03"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="card-title mb-0">
                                                            <h5 class="mb-0">รายรับจากผู้เช่า (บาท)</h5>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="chart04"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="card-title mb-0">
                                                            <h5 class="mb-0">การใช้ไฟฟ้าทั้งหมด (หน่วย)</h5>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="chart05"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="navs-pills-justified-tab2" role="tabpanel">
                                        <div class="row g-3">
                                            <div class="col-sm-4">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="card-title mb-0">
                                                            <h5 class="mb-0">การใช้ไฟ</h5>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="chart06"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-8 d-flex align-items-stretch">
                                                <div class="card mb-3 w-100">
                                                    <div class="card-body">
                                                        <ul class="p-0 m-0">
                                                            <li class="d-flex mb-3">
                                                                <div class="avatar flex-shrink-0 me-4">
                                                                    <span
                                                                        class="avatar-initial rounded bg-light-danger"><i
                                                                            class="ti ti-cash-banknote ti-26px"></i></span>
                                                                </div>
                                                                <div
                                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                                    <div class="me-2">
                                                                        <h6 class="mb-0 fw-normal">
                                                                            รายรับค่าไฟฟ้าจากผู้เช่า
                                                                        </h6>
                                                                    </div>
                                                                    <div class="user-progress">
                                                                        <h6 class="text-light-danger mb-0">
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="d-flex mb-3">
                                                                <div class="avatar flex-shrink-0 me-4">
                                                                    <span
                                                                        class="avatar-initial rounded bg-light-success"><i
                                                                            class="ti ti-currency-dollar ti-26px"></i></span>
                                                                </div>
                                                                <div
                                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                                    <div class="me-2">
                                                                        <h6 class="mb-0 fw-normal">รายจ่ายการประปา</h6>
                                                                    </div>
                                                                    <div class="user-progress">
                                                                        <h6 class="text-light-success mb-0">
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                            <li class="d-flex">
                                                                <div class="avatar flex-shrink-0 me-4">
                                                                    <span
                                                                        class="avatar-initial rounded bg-label-warning"><i
                                                                            class="ti ti-percentage ti-26px"></i></span>
                                                                </div>
                                                                <div
                                                                    class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
                                                                    <div class="me-2">
                                                                        <h6 class="mb-0 fw-normal">กำไร/ขาดทุน
                                                                            ค่าไฟฟ้า</h6>
                                                                    </div>
                                                                    <div class="user-progress">
                                                                        <h6 class="text-warning mb-0">
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="card-title mb-0">
                                                            <h5 class="mb-0">กำไร/ขาดทุนของค่าไฟ (บาท)</h5>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="chart07"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="card-title mb-0">
                                                            <h5 class="mb-0">รายจ่ายการไฟ (บาท)</h5>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="chart08"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="card-title mb-0">
                                                            <h5 class="mb-0">รายรับจากผู้เช่า (บาท)</h5>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="chart09"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="card mb-3">
                                                    <div class="card-header d-flex justify-content-between">
                                                        <div class="card-title mb-0">
                                                            <h5 class="mb-0">การใช้ไฟฟ้าทั้งหมด (หน่วย)</h5>
                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div id="chart10"></div>
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
    var pageIncomeExpense = "{{ $page_url }}/calculate-income-expense";
    function calculate_income_expense(pages){
        var searchDataIncomeExpense = {};
        $('.p_search').each(function() {
            var inputName = $(this).attr('name');
            var inputValue = $(this).val();
            searchDataIncomeExpense[inputName] = inputValue;
        });

        $.ajax({
            method: 'GET',
            url: pages,
            data: searchDataIncomeExpense,
            success: function(res) {
                // ✅ res ต้อง return array เช่น [120, 300]
                $('.total_income').html(res.total_income);
                $('.total_expense').html(res.total_expense);
                $('.total_income-total_expense').html(res.total_income_total_expense);
            }
        });

    }
    $('.datepicker').datepicker({
                        format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่
                        autoclose: true,      // ปิด datepicker เมื่อเลือกวันที่
                        todayHighlight: true  // ไฮไลต์วันที่ปัจจุบัน
                    });
    $('#insert_electricity_bill').on('submit', function(event) {
        event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
        if (!this.checkValidity()) {
            this.reportValidity();
            return console.log('ฟอร์มไม่ถูกต้อง');
        }

        Swal.fire({
            title: 'ยืนยันการดำเนินการ?',
            text: 'คุณต้องการ เพิ่มข้อมูล หรือไม่?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'ตกลง',
            cancelButtonText: 'ยกเลิก',
            showDenyButton: false,
            didOpen: () => {
                Swal.getConfirmButton().focus();
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // ใช้ FormData แทน serialize เพื่อส่งไฟล์ได้
                let form = document.getElementById('insert_electricity_bill');
                let formData = new FormData(form);
                formData.append('_token', '{{ csrf_token() }}'); // สำหรับ Laravel CSRF

                $.ajax({
                    url: '{{$page_url}}/insert-electricity-bill',
                    type: 'POST',
                    data: formData,
                    contentType: false, // ต้องมีเพื่อให้ส่ง multipart/form-data ได้
                    processData: false,
                    success: function(response) {
                        // return 1;
                        if (response == true) {
                            Swal.fire('เพิ่มข้อมูล เรียบร้อยแล้ว', '', 'success');
                            onYearChange();
                            $('#insert_electricity_bill')[0].reset();
                        }
                    },
                    error: function (xhr) {
                        if (xhr.responseJSON && xhr.responseJSON.errors) {
                            let messages = '';
                            $.each(xhr.responseJSON.errors, function (key, value) {
                                messages += value + '<br>';
                            });

                            Swal.fire({
                                title: 'เกิดข้อผิดพลาด',
                                html: messages,
                                icon: 'error',
                            });
                        } else {
                            Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                            console.error('เกิดข้อผิดพลาด:', xhr);
                        }
                    }
                });
            }
        });
    });

    var optionsELE = {
        series: [],
        labels: ['การใช้ไฟฟ้าของผู้เช่า', 'การใช้ไฟฟ้าทั้งหมด'],
        colors: ['#28C76F', '#56CA0099'],
        chart: {
            type: 'donut',
            height: '450px'
        },
        stroke: { show: false },
        dataLabels: {
            enabled: true,
            formatter: function(val) {
                return parseInt(val, 10) + '%';
            }
        },
        legend: {
            show: true,
            position: 'bottom',
            fontFamily: 'IBM Plex Sans Thai',
            itemMargin: { vertical: 3, horizontal: 10 },
            labels: { useSeriesColors: false }
        },
        plotOptions: {
            pie: {
                donut: {
                    labels: {
                        show: true,
                        name: { fontSize: '1.2rem', fontFamily: 'IBM Plex Sans Thai' },
                        value: {
                            fontSize: '1rem',
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
                            formatter: function(w) {
                                // สมมุติ series = [ใช้จริง, ใช้ทั้งหมด]
                                let tenant = w.globals.series[0];   // การใช้ไฟฟ้าของผู้เช่า
                                let total  = w.globals.series[1];   // การใช้ไฟฟ้าทั้งหมด

                                if (total === 0) return "0%";

                                // คำนวณเปอร์เซ็นต์
                                let percent = (tenant / total * 100).toFixed(2);
                                // return percent + " %";
                                return "100%";
                            }
                        }
                    }
                }
            }
        }
    };

    var chartELE = new ApexCharts(document.querySelector("#chart01"), optionsELE);
    chartELE.render();

    // ---- Ajax ดึงข้อมูล ----
    var pageELE = "{{ $page_url }}/calculate-ele-usage";
    var searchDataELE = {};

    // ฟังก์ชันดึงข้อมูลจาก server (ผ่าน AJAX)
    function ele_loadData(pages){
        $('.p_search').each(function() {
            var inputName = $(this).attr('name');
            var inputValue = $(this).val();
            searchDataELE[inputName] = inputValue;
        });

        $.ajax({
            method: 'GET',
            url: pages,
            data: searchDataELE,
            success: function(res) {
                // ✅ res ต้อง return array เช่น [120, 300]
                chartELE.updateSeries(res);
            }
        });
    }
</script>

<script>
    var options02 = {
        series: [{
            data: [] // เริ่มต้นว่าง รอ AJAX โหลด
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
        colors: ['#98EAE9'],
        grid: {
            borderColor: '#ececed',
            xaxis: {
                lines: { show: true }
            },
            padding: { top: -20 }
        },
        xaxis: {
            categories: ['1','2','3','4','5','6','7','8','9','10','11','12'],
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
                    return "฿ " + Math.floor(val).toLocaleString();
                }
            }
        }
    };

    // ---- สร้าง instance ของกราฟ ----
    var chart02 = new ApexCharts(document.querySelector("#chart02"), options02);
    chart02.render();

    // ---- Ajax ดึงข้อมูล ----
    var page = "{{ $page_url }}/calculate-ele-profit-loss";
    var searchData = {};

    // ฟังก์ชันดึงข้อมูลจาก server (ผ่าน AJAX)
    function income_loadData(pages){
        $('.p_search').each(function() {
            var inputName = $(this).attr('name');
            var inputValue = $(this).val();
            searchData[inputName] = inputValue;
        });

        $.ajax({
            method: 'GET',
            url: pages,
            data: searchData,
            success: function(res) {
                chart02.updateSeries([{ data: res }]);
                // chart04.updateSeries([{ data: res }]); // ถ้ามี chart อื่นก็ใช้ได้
            }
        });
    }

</script>

<script>
    var options = {
        series: [{
            data: [] // ← เริ่มต้นให้ว่างไว้ แล้วไปโหลดจริงจาก AJAX
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
            categories: ['1','2','3','4','5','6','7','8','9','10','11','12'],
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

    // --- สร้าง instance ของ chart03 ---
    var chart03 = new ApexCharts(document.querySelector("#chart03"), options);
    chart03.render();

    // ---- Ajax ดึงข้อมูล ----
    var pageExpense = "{{ $page_url }}/electricity-expenses";
    var searchData = {};

    // ฟังก์ชันดึงข้อมูลสำหรับ chart03
    function expense_loadData(pages) {
        $('.p_search').each(function() {
            var inputName = $(this).attr('name');
            var inputValue = $(this).val();
            searchData[inputName] = inputValue;
        });

        $.ajax({
            method: 'GET',
            url: pages,
            data: searchData,
            success: function(res) {
                chart03.updateSeries([{ data: res }]);
            }
        });
    }

</script>
<script>
        var options04 = {
        series: [
            {
                name: 'รายรับที่เก็บได้',
                data: [] // ← ให้เริ่มว่าง
            },
            {
                name: 'ค้างชำระ',
                data: [] // ← ให้เริ่มว่าง
            }
        ],
        chart: {
            height: 400,
            type: 'area',
            parentHeightOffset: 0,
            toolbar: { show: false }
        },
        dataLabels: { enabled: false },
        stroke: {
            show: false,
            curve: 'straight'
        },
        legend: {
            show: true,
            position: 'top',
            horizontalAlign: 'right',
            labels: {
                colors: '#444050',
                useSeriesColors: false
            }
        },
        grid: {
            borderColor: '#ececed',
            xaxis: { lines: { show: true } }
        },
        colors: ['#4dcbdb', '#98eae9'],
        xaxis: {
            categories: ['1','2','3','4','5','6','7','8','9','10','11','12'],
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px'
                }
            }
        },
        fill: { opacity: 1, type: 'solid' },
        tooltip: { shared: false }
    };

    // --- สร้าง instance ของ chart04 ---
    var chart04 = new ApexCharts(document.querySelector("#chart04"), options04);
    chart04.render();

    // ---- Ajax ดึงข้อมูล ----
    var pageIncomeDebt = "{{ $page_url }}/renter-income-baht"; // endpoint ของ chart04
    var searchData = {};

    function chart04_loadData(pages) {
        $('.p_search').each(function() {
            var inputName = $(this).attr('name');
            var inputValue = $(this).val();
            searchData[inputName] = inputValue;
        });

        $.ajax({
            method: 'GET',
            url: pages,
            data: searchData,
            success: function(res) {
                // res ต้องเป็น { income: [...], debt: [...] }
                chart04.updateSeries([
                    { name: 'รายรับที่เก็บได้', data: res.total_income },
                    { name: 'ค้างชำระ', data: res.total_overdue }
                ]);
            }
        });
    }
</script>
<script>
    var chartOptions05 = {
        series: [
            { name: 'โดยผู้เช่า', data: [] },
            { name: 'โดยส่วนกลาง', data: [] }
        ],
        chart: {
            height: 400,
            type: 'area',
            parentHeightOffset: 0,
            toolbar: { show: false }
        },
        dataLabels: { enabled: false },
        stroke: { show: false, curve: 'straight' },
        legend: {
            show: true,
            position: 'top',
            horizontalAlign: 'right',
            labels: { colors: '#444050', useSeriesColors: false }
        },
        grid: {
            borderColor: '#ececed',
            xaxis: { lines: { show: true } }
        },
        colors: ['#beb2f6', '#cbc2f1'],
        xaxis: {
            categories: ['1','2','3','4','5','6','7','8','9','10','11','12'],
            axisBorder: { show: false },
            axisTicks: { show: false },
            labels: { style: { colors: '#444050', fontSize: '13px' } }
        },
        yaxis: {
            labels: { style: { colors: '#444050', fontSize: '13px' } }
        },
        fill: { opacity: 1, type: 'solid' },
        tooltip: { shared: false }
    };

    // สร้าง chart instance
    var chart05 = new ApexCharts(document.querySelector("#chart05"), chartOptions05);
    chart05.render();

    // ---- AJAX ดึงข้อมูล ----
    var page05 = "{{ $page_url }}/electricity-usage-unit"; // backend ส่งข้อมูล
    var searchData05 = {}; // ถ้ามี filter เช่น ปี หรือ branch

    function loadChart05Data(url){
        $('.p_search').each(function() {
            var inputName = $(this).attr('name');
            var inputValue = $(this).val();
            searchData05[inputName] = inputValue;
        });

        $.ajax({
            method: 'GET',
            url: url,
            data: searchData05,
            success: function(res) {
                // res ต้องเป็น object แบบ { tenant: [...12ค่า], common: [...12ค่า] }
                chart05.updateSeries([
                    { name: 'โดยผู้เช่า', data: res.total_by_renter },
                    { name: 'โดยส่วนกลาง', data: res.total_elect }
                ]);
            }
        });
    }

    onYearChange();
    function onYearChange() {
        calculate_income_expense(pageIncomeExpense)
        ele_loadData(pageELE);
        income_loadData(page);
        expense_loadData(pageExpense);
        chart04_loadData(pageIncomeDebt);
        loadChart05Data(page05);
    }
</script>
    <!--ไฟ-->
<script>
    var options = {
        series: [28, 28, 42],
        labels: ['การใช้ไฟฟ้าของผู้เช่า', 'การใช้ไฟฟ้าของส่วนกลาง', 'การใช้ไฟฟ้าทั้งหมด'],
        colors: ['#28C76F', '#56CA00', '#56CA0099'],
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
                            label: 'AVG. Exceptions',
                            formatter: function(w) {
                                return '30%';
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

    var chart = new ApexCharts(document.querySelector("#chart06"), options);
    chart.render();
</script>
<script>
    var options = {
        series: [{
            data: [400, 100, 220, 260, 180, 110]
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
        colors: ['#98EAE9'],
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
            categories: ['7/12', '8/12', '9/12', '10/12', '11/12', '12/12'],
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

    var chart = new ApexCharts(document.querySelector("#chart07"), options);
    chart.render();
</script>
<script>
    var options = {
        series: [{
            data: [400, 100, 220, 260, 180, 110]
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
            categories: ['7/12', '8/12', '9/12', '10/12', '11/12', '12/12'],
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

    var chart = new ApexCharts(document.querySelector("#chart08"), options);
    chart.render();
</script>
<script>
    var options = {
        series: [{
                name: 'รายรับที่เก็บได้',
                data: [100, 120, 90, 170, 130, 160, 140, 240, 220, 180, 270, 280]
            },
            {
                name: 'ค้างชำระ',
                data: [60, 80, 70, 150, 80, 100, 90, 180, 160, 140, 200, 220, 275]
            }
        ],
        chart: {
            height: 400,
            type: 'area',
            parentHeightOffset: 0,
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: false,
            curve: 'straight'
        },
        legend: {
            show: true,
            position: 'top',
            horizontalAlign: 'right',
            labels: {
                colors: '#444050',
                useSeriesColors: false
            }
        },
        grid: {
            borderColor: '#ececed',
            xaxis: {
                lines: {
                    show: true
                }
            }
        },
        colors: ['#4dcbdb', '#98eae9'],
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
                    fontSize: '13px'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px'
                }
            }
        },
        fill: {
            opacity: 1,
            type: 'solid'
        },
        tooltip: {
            shared: false
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart09"), options);
    chart.render();
</script>
<script>
    var options = {
        series: [{
                name: 'โดยผู้เช่า',
                data: [100, 120, 90, 170, 130, 160, 140, 240, 220, 180, 270, 280, 375]
            },
            {
                name: 'โดยส่วนกลาง',
                data: [60, 80, 70, 110, 80, 100, 90, 180, 160, 140, 200, 220, 275]
            }
        ],
        chart: {
            height: 400,
            type: 'area',
            parentHeightOffset: 0,
            toolbar: {
                show: false
            }
        },
        dataLabels: {
            enabled: false
        },
        stroke: {
            show: false,
            curve: 'straight'
        },
        legend: {
            show: true,
            position: 'top',
            horizontalAlign: 'right',
            labels: {
                colors: '#444050',
                useSeriesColors: false
            }
        },
        grid: {
            borderColor: '#ececed',
            xaxis: {
                lines: {
                    show: true
                }
            }
        },
        colors: ['#beb2f6', '#cbc2f1'],
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
                    fontSize: '13px'
                }
            }
        },
        yaxis: {
            labels: {
                style: {
                    colors: '#444050',
                    fontSize: '13px'
                }
            }
        },
        fill: {
            opacity: 1,
            type: 'solid'
        },
        tooltip: {
            shared: false
        }
    };

    var chart = new ApexCharts(document.querySelector("#chart10"), options);
    chart.render();
</script>
</body>

</html>