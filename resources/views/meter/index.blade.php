<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template">

<head>
    @include('layout/inc_header')
    <title>Dashboard - CRM | Vuexy - Bootstrap Admin Template</title>
</head>
<style>
.table th {
    font-size: 15px;
    font-weight: bold;
    border: 1px solid black
}
.table td {
    /* padding-top: 14px;
    padding-bottom: 14px; */
}
.modalHeadDecor .modal-header {
    padding: 0;
}

.modalHeadDecor .modal-title {
    padding: 1.25rem 1.5rem 1.25rem;
    color: white;
    background-color: #54BAB9;
    position: relative;
}

.modalHeadDecor .modal-title::after {
    position: absolute;
    top: 0;
    right: -65px;
    content: '';
    width: 0;
    height: 0;
    border-top: 65px solid #54BAB9;
    border-right: 65px solid transparent;
}
</style>

<link rel="stylesheet" href="assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="assets/vendor/libs/bootstrap-select/bootstrap-select.css" />

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
                                <div class="card mb-3">
                                    <div class="card-header border-bottom border-light">
                                        <div class="row g-3 justify-content-between">
                                            <div class="col-sm-12">
                                                <h4 class="mb-0">
                                                    <i class="tf-icons ti ti-id text-main ti-md"></i>
                                                    เลือกรอบจดมิเตอร์
                                                </h4>
                                            </div>
                                            {{-- <div class="col-sm-12">
                                                <ul class="nav nav-pills nav-fill " role="tablist">
                                                    <li class="nav-item">
                                                        <button type="button" class="nav-link active" role="tab"
                                                        style="background-color: #d6f4f7;color: black;"
                                                            data-bs-toggle="tab"
                                                            data-bs-target="#navs-pills-top-home"
                                                            aria-controls="navs-pills-top-home"
                                                            aria-selected="true">มิเตอร์น้ำ</button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button type="button" class="nav-link" role="tab"
                                                        style="background-color: #ffe2e3;color: black;"
                                                            data-bs-toggle="tab"
                                                            data-bs-target="#navs-pills-top-home"
                                                            aria-controls="navs-pills-top-home"
                                                            aria-selected="false">มิเตอร์ไฟ</button>
                                                    </li>
                                                </ul>
                                            </div> --}}
                                            
                                            <div class="col-sm-12" style="font-weight: 500;">
                                                <ul class="nav nav-pills nav-fill " role="tablist">
                                                    <li class="nav-item pe-4">
                                                        <button type="button" class="nav-link btn-info active" id="meter_water" role="tab"
                                                            data-bs-toggle="tab" data-bs-target="#navs-pills-top-home"
                                                            aria-controls="navs-pills-top-home"
                                                            aria-selected="true">
                                                            <span class="ti ti-droplet me-2"></span>
                                                            มิเตอร์น้ำ
                                                        </button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button type="button" class="nav-link btn-label-danger" id="meter_electricity" role="tab"
                                                            data-bs-toggle="tab"
                                                            data-bs-target="#navs-pills-top-profile"
                                                            aria-controls="navs-pills-top-profile"
                                                            aria-selected="false">
                                                            <span class="ti ti-plug me-2"></span>
                                                            มิเตอร์ไฟ
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body" style="padding: unset;">
                                        <div class="tab-content p-0">
                                            <div class="tab-pane fade show active" id="navs-pills-top-home"
                                                role="tabpanel">
                                                
                                                <div class="row border-bottom border-light p-3">
                                                    <div class="col-lg-3">
                                                        <div class="d-flex align-items-center mb-2 mb-md-0">
                                                            <label class="">Show</label>
                                                            <select onchange='loadWaterData("{{$page_url}}/water/datatable")' name="limit" class="form-select ms-2 me-2 p_water_search" style="width:100px">
                                                                <option value="10">10</option>
                                                                <option value="25">25</option>
                                                                <option value="50">50</option>
                                                                <option value="75">75</option>
                                                                <option value="100">100</option>
                                                            </select>
                                                            <ul class="nav nav-pills" id="pills-tablayout" role="tablist">
                                                                <li class="nav-item me-1" role="presentation">
                                                                    <button type="button"
                                                                        class="btn btn-icon btn-sm btn-label-secondary waves-effect"
                                                                        id="pills-home-tab" data-bs-toggle="pill"
                                                                        data-bs-target="#pills-home" type="button" role="tab"
                                                                        aria-controls="pills-home" aria-selected="true">
                                                                        <span class="ti ti-layout-grid ti-md"></span>
                                                                    </button>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <button type="button"
                                                                        class="btn btn-icon btn-sm btn-label-secondary waves-effect active"
                                                                        data-bs-toggle="pill" data-bs-target="#pills-profile"
                                                                        type="button" role="tab" aria-controls="pills-profile"
                                                                        aria-selected="false">
                                                                        <span class="ti ti-list ti-md"></span>
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                        <div class="col-md-3 select_off" style="padding-right: unset !important;">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                <select onchange='loadWaterData("{{$page_url}}/water/datatable")' name="building" id="selectpickerBuilding" class="select2 form-select form-select-lg p_water_search" data-style="btn-default">
                                                                            <option value="all">ทุกตึก</option>
                                                                            @foreach ($buildings as $b)
                                                                                <option value="{{ $b->id }}">{{ $b->name }}</option>
                                                                            @endforeach
                                                                </select>
                                                                </div>
                                                                <div class="col-md-6">
                                                                <select onchange='loadWaterData("{{$page_url}}/water/datatable")' name="floor" id="selectpickerFloor" class="select2 form-select form-select-lg p_water_search" data-style="btn-default" disabled>
                                                                            <option value="all">ทุกชั้น</option>
                                                                            @foreach ($floors as $f)
                                                                                <option value="{{ $f->id }}">{{ $f->name }}</option>
                                                                            @endforeach
                                                                </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2" style="padding-right: unset !important;">
                                                            <input name="month" type="month" class="form-control p_water_search" value="{{ date('Y-m') }}" onchange='loadWaterData("{{$page_url}}/water/datatable")'/>
                                                        </div>
                                                        <div class="col-md-2" style="padding-right: unset !important;">
                                                            <button
                                                                    style="padding-right: 14px;padding-left: 14px;"
                                                                    class="btn btn-warning buttons-collection waves-effect waves-light me-2"
                                                                    tabindex="0" aria-controls="DataTables_Table_0"
                                                                    type="button" aria-haspopup="dialog"
                                                                    aria-expanded="false">
                                                                    <span>
                                                                        <i class="ti ti-upload"></i> 
                                                                        ดาวน์โหลด Excel
                                                                    </span>
                                                            </button>
                                                        </div>
                                                        <div class="col-md-2" style="padding-right: unset !important;">
                                                            <button onclick="updateRoom()"
                                                                    style="padding-right: 14px;padding-left: 14px;"
                                                                    class="btn btn-success buttons-collection btn-label-success me-2"
                                                                    tabindex="0" aria-controls="DataTables_Table_0"
                                                                    type="button" aria-haspopup="dialog"
                                                                    aria-expanded="false">
                                                                    <span>
                                                                        <i class="ti ti-save"></i> 
                                                                        บันทึกทั้งหมด
                                                                    </span>
                                                            </button>
                                                        </div>
                                                    
                                                </div>
                                                <div class="card-body px-0 pt-0">
                                                    <div class="tab-content p-0" id="pills-tabContent">
                                                        <div class="tab-pane fade show" id="pills-home" role="tabpanel"
                                                            aria-labelledby="pills-home-tab" tabindex="0">
                                                            <div class="card card-body shadow-none" style="padding: 10px;line-height: 5px;">
                                                                <div class="row g-3 new_box" style="padding: 0px 30px;">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade show active water_table" id="pills-profile" role="tabpanel"
                                                            aria-labelledby="pills-profile-tab" tabindex="0">
                                                            
                                                            {{-- ตาราง มิเตอร์น้ำ อยู่ตรงนี้นะจ๊ะ --}}
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                                                
                                                <div class="row border-bottom border-light p-3">
                                                    <div class="col-lg-4">
                                                        <div class="d-flex align-items-center mb-2 mb-md-0">
                                                            <label class="">Show</label>
                                                            <select onchange='loadElectricityData("{{$page_url}}/electricity/datatable")' name="limit" class="form-select ms-2 me-2 p_electricity_search" style="width:100px">
                                                                <option value="10">10</option>
                                                                <option value="25">25</option>
                                                                <option value="50">50</option>
                                                                <option value="75">75</option>
                                                                <option value="100">100</option>
                                                            </select>
                                                            <ul class="nav nav-pills" id="pills-tablayout" role="tablist">
                                                                <li class="nav-item me-1" role="presentation">
                                                                    <button type="button"
                                                                        class="btn btn-icon btn-sm btn-label-secondary waves-effect"
                                                                        id="pills-home-tab" data-bs-toggle="pill"
                                                                        data-bs-target="#pills-home" type="button" role="tab"
                                                                        aria-controls="pills-home" aria-selected="true">
                                                                        <span class="ti ti-layout-grid ti-md"></span>
                                                                    </button>
                                                                </li>
                                                                <li class="nav-item" role="presentation">
                                                                    <button type="button"
                                                                        class="btn btn-icon btn-sm btn-label-secondary waves-effect active"
                                                                        data-bs-toggle="pill" data-bs-target="#pills-profile"
                                                                        type="button" role="tab" aria-controls="pills-profile"
                                                                        aria-selected="false">
                                                                        <span class="ti ti-list ti-md"></span>
                                                                    </button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                        <div class="col-md-1" style="padding-right: unset !important;"></div>
                                                        {{-- <div class="col-md-2" style="padding-right: unset !important;">
                                                        <select onchange='loadElectricityData("{{$page_url}}/electricity/datatable")' name="floor" id="selectpickerElectricityFloor" class="select2 form-select form-select-lg p_electricity_search" data-style="btn-default">
                                                                <option value="all">ทุกชั้น</option>
                                                                @foreach ($floors as $f)
                                                                    <option value="{{ $f->id }}">{{ $f->name }}</option>
                                                                @endforeach
                                                        </select>
                                                        </div> --}}
                                                        
                                                        <div class="col-md-1 select_off" style="padding-right: unset !important;">
                                                        <select onchange='loadElectricityData("{{$page_url}}/electricity/datatable")' name="building" id="selectpickerBuilding_2" class="select2 form-select form-select-lg p_electricity_search" data-style="btn-default">
                                                                    <option value="all">ทุกตึก</option>
                                                                    @foreach ($buildings as $b)
                                                                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                        <!-- Group -->
                                                        <div class="col-md-1 select_off" style="padding-right: unset !important;">
                                                        <select onchange='loadElectricityData("{{$page_url}}/electricity/datatable")' name="floor" id="selectpickerFloor_2" class="select2 form-select form-select-lg p_electricity_search" data-style="btn-default" disabled>
                                                                    <option value="all">ทุกชั้น</option>
                                                                    @foreach ($floors as $f)
                                                                        <option value="{{ $f->id }}">{{ $f->name }}</option>
                                                                    @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col-md-2" style="padding-right: unset !important;">
                                                            <input name="month" type="month" class="form-control p_electricity_search" value="{{ date('Y-m') }}" onchange='loadElectricityData("{{$page_url}}/electricity/datatable")'/>
                                                        </div>
                                                        <div class="col-md-3" style="padding-right: unset !important;">
                                                            <button
                                                                    style="padding-right: 14px;padding-left: 14px;"
                                                                    class="btn btn-success buttons-collection btn-label-warning waves-effect waves-light me-2"
                                                                    tabindex="0" aria-controls="DataTables_Table_0"
                                                                    type="button" aria-haspopup="dialog"
                                                                    aria-expanded="false">
                                                                    <span>
                                                                        <i class="ti ti-upload"></i> 
                                                                        ดาวน์โหลด Excel
                                                                    </span>
                                                            </button>
                                                        </div>
                                                    
                                                </div>
                                                <div class="card-body px-0 pt-0">
                                                    <div class="tab-content p-0" id="pills-tabContent">
                                                        <div class="tab-pane fade show" id="pills-home" role="tabpanel"
                                                            aria-labelledby="pills-home-tab" tabindex="0">
                                                            <div class="card card-body shadow-none" style="padding: 10px;line-height: 5px;">
                                                                <div class="row g-3 new_box" style="padding: 0px 30px;">
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="tab-pane fade show electricity_table active" id="pills-profile" role="tabpanel"
                                                            aria-labelledby="pills-profile-tab" tabindex="0">
                                                            
                                                            {{-- ตาราง มิเตอร์ไฟ อยู่ตรงนี้นะจ๊ะ --}}

                                                        </div>
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
    <!--add service  Modal -->
    <!-- / Layout wrapper -->
    @include('layout/inc_js')
    <script src="assets/vendor/libs/select2/select2.js"></script>
    <script src="assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="assets/js/forms-selects.js"></script>
</body>

</html>
<script>
    var water_page = "{{$page_url}}/water/datatable";
    var electricity_page = "{{$page_url}}/electricity/datatable";
    var searchWaterData = {};
    var searchElectricityData = {};


    loadWaterData(water_page);
    loadElectricityData(electricity_page);
    
    function loadWaterData(pages){
        
        $('.p_water_search').each(function() {
            var inputName = $(this).attr('name'); // ดึงชื่อ attribute 'name' ของ input
            var inputValue = $(this).val(); // ดึงค่า value ของ input
            
            searchWaterData[inputName] = inputValue; // เก็บข้อมูลลงในออบเจ็กต์ searchWaterData
        });

        water_page = pages;

        $.ajax({
            type: "GET",
            url: water_page,
            data: searchWaterData,
            success: function(data) {
                $(".water_table").html(data);
            }
        });

    }

    function loadElectricityData(pages){
        
        $('.p_electricity_search').each(function() {
            var inputName = $(this).attr('name'); // ดึงชื่อ attribute 'name' ของ input
            var inputValue = $(this).val(); // ดึงค่า value ของ input
            
            searchElectricityData[inputName] = inputValue; // เก็บข้อมูลลงในออบเจ็กต์ searchElectricityData
        });

        electricity_page = pages;

        $.ajax({
            type: "GET",
            url: electricity_page,
            data: searchElectricityData,
            success: function(data) {
                $(".electricity_table").html(data);
            }
        });
        // alert(page);
    }

            $('#selectpickerBuilding').change(function() {
                var building = $(this).val();
                
                // เคลียร์ dropdown สำหรับตำบล
                $('#selectpickerFloor').empty().append('<option value="all">ทุกชั้น</option>');

                if(building == 'all'){
                    $('#selectpickerFloor').prop('disabled', true);
                    return;
                }
                if (building) {
                    $.ajax({
                        url: '/get-floors/' + building,
                        type: 'GET',
                        success: function(data) {
                            $('#selectpickerFloor').prop('disabled', false);
                            data.forEach(function(floor) {
                                $('#selectpickerFloor').append('<option value="' + floor.id + '">' + floor.name + '</option>');
                            });
                        }
                    });
                }
            });
            $('#selectpickerBuilding_2').change(function() {
                var building = $(this).val();
                
                // เคลียร์ dropdown สำหรับตำบล
                $('#selectpickerFloor_2').empty().append('<option value="all">ทุกชั้น</option>');

                if(building == 'all'){
                    $('#selectpickerFloor_2').prop('disabled', true);
                    return;
                }
                if (building) {
                    $.ajax({
                        url: '/get-floors/' + building,
                        type: 'GET',
                        success: function(data) {
                            $('#selectpickerFloor_2').prop('disabled', false);
                            data.forEach(function(floor) {
                                $('#selectpickerFloor_2').append('<option value="' + floor.id + '">' + floor.name + '</option>');
                            });
                        }
                    });
                }
            });
            
    $('#meter_water').on('click', function() {
        $('.nav-link').removeClass('active btn-danger');
        $('#meter_electricity').addClass('btn-label-danger');
        $(this).removeClass('btn-label-info');
        $(this).addClass('active btn-info');
    });
    $('#meter_electricity').on('click', function() {
        $('.nav-link').removeClass('active btn-info');
        $('#meter_water').addClass('btn-label-info');
        $(this).removeClass('btn-label-danger');
        $(this).addClass('active btn-danger');
    });
</script>