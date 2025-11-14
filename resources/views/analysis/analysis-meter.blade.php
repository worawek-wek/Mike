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
                                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" onclick="remember_type('navs-pills-justified-tab1')"
                                            data-bs-target="#navs-pills-justified-tab1"
                                            aria-controls="navs-pills-justified-tab1" aria-selected="true">
                                            <i class="tf-icons ti ti-droplet me-1"></i> วิเคราะห์มิเตอร์น้ำของผู้เช่า
                                        </button>
                                    </li>
                                    <li class="nav-item">
                                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" onclick="remember_type('navs-pills-justified-tab2')"
                                            data-bs-target="#navs-pills-justified-tab2"
                                            aria-controls="navs-pills-justified-tab2" aria-selected="false">
                                            <i class="tf-icons ti ti-plug me-1"></i> วิเคราะห์มิเตอร์ไฟฟ้าของผู้เช่า
                                        </button>
                                    </li>
                                </ul>
                                <div class="tab-content bg-transparent p-0" id="data">
                                    
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
        var searchData = {};
        loadChartData(1);
        var type = 'navs-pills-justified-tab1';
        function remember_type(t) {
            type = t;
        }
        function loadChartData(floor) {

            $.ajax({
                method: 'GET',
                url: "{{ $page_url }}/get-room-floor",
                data: {
                    ref_floor_id : floor
                },
                success: function(res) {
                    $("#data").html(res);
                    // เอาปุ่มตาม id ที่ตรงกับ type
                    document.querySelectorAll('.tab-pane').forEach(function (pane) {
                        pane.classList.remove('show', 'active');
                    });

                    // เซ็ต tab-pane ตาม id = type
                    var targetPane = document.getElementById(type);
                    if (targetPane) {
                        targetPane.classList.add('show', 'active');
                    }

                    // ทำให้ปุ่ม nav-link ที่ชี้ไปยัง pane นั้น active ด้วย
                    document.querySelectorAll('.nav-link').forEach(function (link) {
                        link.classList.remove('active');
                    });
                    var activeBtn = document.querySelector('[data-bs-target="#' + type + '"]');
                    if (activeBtn) {
                        activeBtn.classList.add('active');
                    }
                }
            });
        }
        </script>

</body>

</html>