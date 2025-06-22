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
    padding-top: 14px;
    padding-bottom: 14px;
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
                                    <div class="card-header border-bottom border-bottom">
                                        <div class="row g-3 justify-content-between">
                                            <div class="col-sm-12">
                                                <h4 class="mb-0">
                                                    <i class="tf-icons ti ti-car text-main ti-md"></i>
                                                    ยานพาหนะ
                                                </h4>
                                            </div>
                                            <div class="col-sm-12">
                                                <ul class="nav nav-pills nav-fill " role="tablist">
                                                    <li class="nav-item me-4">
                                                        <button type="button" class="nav-link active" role="tab"
                                                        style="background-color: #d6f4f7;color: black;"
                                                            data-bs-toggle="tab" data-bs-target="#navs-pills-top-home"
                                                            aria-controls="navs-pills-top-home"
                                                            aria-selected="true">ข้อมูลรถปัจจุบัน</button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button type="button" class="nav-link" role="tab"
                                                        style="background-color: #ffe2e3;color: black;"
                                                            data-bs-toggle="tab"
                                                            data-bs-target="#navs-pills-top-profile"
                                                            aria-controls="navs-pills-top-profile"
                                                            aria-selected="false">ข้อมูลรถห้องย้ายออก</button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content p-0">
                                            <div class="tab-pane fade show active" id="navs-pills-top-home"
                                                role="tabpanel">
                                                
                                                <div class="row mt-4">
                                                    <div class="col-md-4">
                                                        <select onchange="loadCurrentData('{{$page_url}}/current/datatable')" id="selectpickerBasic" name="ref_type_id" class="form-select me-2 p_current_search" data-style="btn-default">
                                                                <option value="all">ประเภทรถ</option>
                                                                @foreach ($type as $type_row)
                                                                    <option value="{{ $type_row->id }}">{{ $type_row->name }}</option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                                                            <input
                                                            oninput="loadCurrentData('{{$page_url}}/current/datatable')"
                                                            name="room"
                                                            type="text"
                                                            class="form-control p_current_search"
                                                            placeholder="ค้นหาตามหมายเลขห้อง"
                                                            aria-label="ค้นหาตามหมายเลขห้อง"
                                                            aria-describedby="basic-addon-search31" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                                                            <input
                                                            oninput="loadCurrentData('{{$page_url}}/current/datatable')"
                                                            name="car_registration"
                                                            type="text"
                                                            class="form-control p_current_search"
                                                            placeholder="ค้นหาตามทะเบียนรถ"
                                                            aria-label="ค้นหาตามทะเบียนรถ"
                                                            aria-describedby="basic-addon-search31" />
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="row border-bottom border-light p-3">
                                                    <div class="col-lg-4">
                                                        <div class="d-flex align-items-center mb-2 mb-md-0">
                                                            <label class="">Show</label>
                                                            <select name="" class="form-select ms-2 me-2" style="width:100px">
                                                                <option value="10">10</option>
                                                                <option value="25">25</option>
                                                                <option value="50">50</option>
                                                                <option value="75">75</option>
                                                                <option value="100">100</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 flex text-end" style="padding-right: unset !important;">
                                                        <button
                                                                style="padding-right: 14px;padding-left: 14px;"
                                                                class="btn btn-success buttons-collection btn-warning waves-effect waves-light me-2"
                                                                tabindex="0" aria-controls="DataTables_Table_0"
                                                                type="button" aria-haspopup="dialog"
                                                                aria-expanded="false"
                                                                onclick="window.open('{{$page_url}}/current/export/excel', '_blank')">
                                                                <span>
                                                                    <i class="ti ti-upload"></i> 
                                                                    ดาวน์โหลด Excel
                                                                </span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body px-0 pt-0">
                                                    <div class="tab-content p-0" id="pills-tabContent">
                                                        <div class="tab-pane fade show active current_table" id="pills-profile" role="tabpanel"
                                                            aria-labelledby="pills-profile-tab" tabindex="0">
                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                                                <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                                                aria-labelledby="pills-profile-tab" tabindex="0">
                                                
                                                <div class="row mt-4">
                                                    <div class="col-md-4">
                                                        <select onchange="loadOldData('{{$page_url}}/old/datatable')" id="selectpickerBasic" name="ref_type_id" class="form-select me-2 p_old_search" data-style="btn-default">
                                                                <option value="all">ประเภทรถ</option>
                                                                @foreach ($type as $type_row)
                                                                    <option value="{{ $type_row->id }}">{{ $type_row->name }}</option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                                                            <input
                                                            oninput="loadOldData('{{$page_url}}/old/datatable')"
                                                            name="room"
                                                            type="text"
                                                            class="form-control p_old_search"
                                                            placeholder="ค้นหาตามหมายเลขห้อง"
                                                            aria-label="ค้นหาตามหมายเลขห้อง"
                                                            aria-describedby="basic-addon-search31" />
                                                        </div>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                                                            <input
                                                            oninput="loadOldData('{{$page_url}}/old/datatable')"
                                                            name="car_registration"
                                                            type="text"
                                                            class="form-control p_old_search"
                                                            placeholder="ค้นหาตามทะเบียนรถ"
                                                            aria-label="ค้นหาตามทะเบียนรถ"
                                                            aria-describedby="basic-addon-search31" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row border-bottom border-light p-3">
                                                    <div class="col-lg-5">
                                                        <div class="d-flex align-items-center mb-2 mb-md-0">
                                                            <label class="">Show</label>
                                                            <select name="" class="form-select ms-2 me-2" style="width:100px">
                                                                <option value="10">10</option>
                                                                <option value="25">25</option>
                                                                <option value="50">50</option>
                                                                <option value="75">75</option>
                                                                <option value="100">100</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    {{-- <div class="col-md-3 mt-1" style="padding-right: unset !important;font-weight: 500;" align="right">
                                                        <span style="font-size: 22px" class="me-2">พฤษภาคม 2024</span>
                                                    </div>
                                                    <div class="col-md-2" style="padding-right: unset !important;">
                                                        <input type="month" class="form-control" id="exampleFormControlInput1" placeholder="" />
                                                    </div> --}}
                                                    <div class="col-md-7 text-end" style="padding-right: unset !important;">
                                                        <button
                                                                style="padding-right: 14px;padding-left: 14px;"
                                                                class="btn btn-success buttons-collection btn-warning waves-effect waves-light me-2"
                                                                tabindex="0" aria-controls="DataTables_Table_0"
                                                                type="button" aria-haspopup="dialog"
                                                                aria-expanded="false"
                                                                onclick="window.open('{{$page_url}}/old/export/excel', '_blank')">
                                                                <span>
                                                                    <i class="ti ti-upload"></i> 
                                                                    ดาวน์โหลด Excel
                                                                </span>
                                                        </button>
                                                    </div>
                                                </div>
                                                    <div class="card-body px-0 pt-0">
                                                    <div class="tab-content p-0" id="pills-tabContent">
                                                        <div class="tab-pane fade show active old_table" id="pills-profile" role="tabpanel"
                                                            aria-labelledby="pills-profile-tab" tabindex="0">
                                                            
                                                            {{-- table ใบเสร็จรับเงิน อยู่ตรงนี้นะจ๊ะ --}}

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
    <script src="assets/vendor/libs/select2/select2.js"></script>
    <script src="assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="assets/js/forms-selects.js"></script>
</body>
    
<script>
    var current_page = "{{$page_url}}/current/datatable";
    var old_page = "{{$page_url}}/old/datatable";
    var searchCurrentData = {};
    var searchOldData = {};


    loadCurrentData(current_page);
    loadOldData(old_page);

    function loadCurrentData(pages){
        
        $('.p_current_search').each(function() {
            var inputName = $(this).attr('name'); // ดึงชื่อ attribute 'name' ของ input
            var inputValue = $(this).val(); // ดึงค่า value ของ input
            
            searchCurrentData[inputName] = inputValue; // เก็บข้อมูลลงในออบเจ็กต์ searchCurrentData
        });

        current_page = pages;

        $.ajax({
            type: "GET",
            url: current_page,
            data: searchCurrentData,
            success: function(data) {
                $(".current_table").html(data);
            }
        });

    }

    function loadOldData(pages){
        
        $('.p_old_search').each(function() {
            var inputName = $(this).attr('name'); // ดึงชื่อ attribute 'name' ของ input
            var inputValue = $(this).val(); // ดึงค่า value ของ input
            
            searchOldData[inputName] = inputValue; // เก็บข้อมูลลงในออบเจ็กต์ searchOldData
        });

        old_page = pages;

        $.ajax({
            type: "GET",
            url: old_page,
            data: searchOldData,
            success: function(data) {
                $(".old_table").html(data);
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
            
       
    $('#tab_current').on('click', function() {
        $('.nav-link').removeClass('active btn-success');
        $('#tab_old').addClass('btn-label-success');
        $(this).removeClass('btn-label-primary');
        $(this).addClass('active btn-primary');
    });
    $('#tab_old').on('click', function() {
        $('.nav-link').removeClass('active btn-primary');
        $('#tab_current').addClass('btn-label-primary');
        $(this).removeClass('btn-label-success');
        $(this).addClass('active btn-success');
    });
    
</script>

</html>