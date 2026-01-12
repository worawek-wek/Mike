<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template">

<head>
    @include('layout/inc_header')
    <title>Dashboard - CRM | Vuexy - Bootstrap Admin Template</title>
</head>
<style>
table {
    border-collapse: unset;
  }
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
                                            
                                            <div class="col-sm-12 text-end">
                                                    <button
                                                        style="padding-right: 14px;padding-left: 14px;"
                                                        class="btn btn-warning buttons-collection waves-effect waves-light me-2"
                                                        tabindex="0" aria-controls="DataTables_Table_0"
                                                        type="button" aria-haspopup="dialog"
                                                        aria-expanded="false"
                                                        onclick="all_export_excel()">
                                                        <span>
                                                            <i class="ti ti-upload"></i> 
                                                            Excel ค่าน้ำ ค่าไฟฟ้า
                                                        </span>
                                                </button>
                                            </div>
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
                                                                <option value="20">20</option>
                                                                <option value="50">50</option>
                                                                <option value="100">100</option>
                                                                <option value="999999">ทั้งหมด</option>
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
                                                                    aria-expanded="false"
                                                                    onclick="water_export_excel()">
                                                                    <span>
                                                                        <i class="ti ti-upload"></i> 
                                                                        Excel ค่าน้ำ
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
                                                        <div class="mt-3" style="padding-right: unset !important;" id="movingMeterWaterRoom">
                                                            <button onclick="showMovingMeterRoomCount()"
                                                                    style="padding-right: 14px; padding-left: 14px;"
                                                                    class="btn btn-warning buttons-collection me-2">
                                                                    <i class="ti ti-alert-triangle me-1"></i>
                                                                        พบห้องว่างมีการเคลื่อนไหวมิเตอร์ (<span id="movingMeterWaterRoomCount"></span>)
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
                                                                <option value="20">20</option>
                                                                <option value="50">50</option>
                                                                <option value="100">100</option>
                                                                <option value="999999">ทั้งหมด</option>
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
                                                                    class="btn btn-warning buttons-collection btn-warning waves-effect waves-light me-2"
                                                                    tabindex="0" aria-controls="DataTables_Table_0"
                                                                    type="button" aria-haspopup="dialog"
                                                                    aria-expanded="false"
                                                                    onclick="electricity_export_excel()">
                                                                    <span>
                                                                        <i class="ti ti-upload"></i> 
                                                                        Excel ค่าไฟฟ้า
                                                                    </span>
                                                            </button>
                                                        </div>
                                                        <div class="mt-3" style="padding-right: unset !important;" id="movingMeterElectricityRoom">
                                                            <button onclick="showMovingMeterElectricityRoomCount()"
                                                                    style="padding-right: 14px; padding-left: 14px;"
                                                                    class="btn btn-warning buttons-collection me-2">
                                                                    <i class="ti ti-alert-triangle me-1"></i>
                                                                        พบห้องว่างมีการเคลื่อนไหวมิเตอร์ (<span id="movingMeterElectricityRoomCount"></span>)
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

        <div class="modal fade modalHeadDecor" id="change_meter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-header rounded-0">
                        <span class="modal-title">
                            <span class="h5" style="color: white;">&nbsp;เปลี่ยนมิเตอร์&nbsp;</span>
                        </span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="change_meter_form">
                        @csrf
                        <div class="col-md-12">
                            <div class="card shadow-none bg-transparent mb-3">
                                <div class="card-body p-5">
                                    <div class="row g-3">

                                        <!-- Radio: มิเตอร์น้ำเต็ม -->
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input name="ref_reason_id" class="form-check-input" type="radio" id="defaultRadio1" value="1" checked onclick="toggleReasonFields()">
                                                <label class="form-check-label" for="defaultRadio1">มิเตอร์น้ำเต็ม</label>
                                            </div>
                                        </div>

                                        <!-- Input + Button Group -->
                                        <div class="col-12 px-5 pb-3" id="div_reason1">
                                            <label for="max_meter" class="form-label">กรุณาเลือกค่าสูงสุดของมิเตอร์น้ำ</label>
                                            <div class="input-group">
                                                <!-- ปุ่มลบ -->
                                                <button class="btn" style="border: 2px solid #a69feb" type="button" id="btn-decrease">
                                                    <i class="tf-icons ti ti-minus"></i>
                                                </button>

                                                <!-- input -->
                                                <input readonly
                                                    name="meter_before_change[1]"
                                                    type="number"
                                                    class="form-control text-center"
                                                    value="9999"
                                                    id="max_meter"
                                                    style="background-color: rgba(75, 70, 92, 0.08);"
                                                />
                                                <input type="hidden" name="start_value_of_new_meter[1]" value="0">

                                                <!-- ปุ่มเพิ่ม -->
                                                <button class="btn" style="border: 2px solid #a69feb" type="button" id="btn-increase">
                                                    <i class="tf-icons ti ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Radio: เปลี่ยนมิเตอร์น้ำ -->
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input name="ref_reason_id" class="form-check-input" type="radio" id="defaultRadio2" value="2" onclick="toggleReasonFields()">
                                                <label class="form-check-label" for="defaultRadio2">เปลี่ยนมิเตอร์น้ำ</label>
                                            </div>
                                        </div>

                                        <!-- รายละเอียดเพิ่มเติม (เมื่อเลือก "เปลี่ยนมิเตอร์น้ำ") -->
                                        <div id="div_reason2" class="col-12 px-5" style="display:none;">
                                            <div class="mb-3">
                                                <label for="meter_before_change[2]" class="form-label">
                                                    กรุณากรอกหน่วยมิเตอร์ล่าสุดของมิเตอร์น้ำตัวเก่า<span class="text-danger"> *</span>
                                                </label>
                                                <input type="number" name="meter_before_change[2]" class="form-control text-center" id="meter_before_change" autocomplete="off" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="start_value_of_new_meter" class="form-label">
                                                    กรุณากรอกหน่วยมิเตอร์เริ่มต้นของมิเตอร์น้ำตัวใหม่<span class="text-danger"> *</span>
                                                </label>
                                                <input type="number" name="start_value_of_new_meter[2]" class="form-control text-center" id="start_value_of_new_meter" autocomplete="off" value="0" required>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer rounded-0 justify-content-center">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                            <button type="submit" class="btn btn-main">บันทึก</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
        <div class="modal fade modalHeadDecor" id="change_ele_meter" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-header rounded-0">
                        <span class="modal-title">
                            <span class="h5" style="color: white;">&nbsp;เปลี่ยนมิเตอร์&nbsp;</span>
                        </span>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="change_ele_meter_form">
                        @csrf
                        <div class="col-md-12">
                            <div class="card shadow-none bg-transparent mb-3">
                                <div class="card-body p-5">
                                    <div class="row g-3">

                                        <!-- Radio: มิเตอร์ไฟเต็ม -->
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input name="ref_reason_ele_id" class="form-check-input" type="radio" id="defaultRadio3" value="1" checked onclick="toggleReasonFieldsEle()">
                                                <label class="form-check-label" for="defaultRadio3">มิเตอร์ไฟเต็ม</label>
                                            </div>
                                        </div>

                                        <!-- Input + Button Group -->
                                        <div class="col-12 px-5 pb-3" id="div_reason3">
                                            <label for="max_meter" class="form-label">กรุณาเลือกค่าสูงสุดของมิเตอร์ไฟ</label>
                                            <div class="input-group">
                                                <!-- ปุ่มลบ -->
                                                <button class="btn" style="border: 2px solid #a69feb" type="button" id="btn-decrease">
                                                    <i class="tf-icons ti ti-minus"></i>
                                                </button>

                                                <!-- input -->
                                                <input readonly
                                                    name="meter_before_change[1]"
                                                    type="number"
                                                    class="form-control text-center"
                                                    value="9999"
                                                    id="max_meter"
                                                    style="background-color: rgba(75, 70, 92, 0.08);"
                                                />
                                                <input type="hidden" name="start_value_of_new_meter[1]" value="0">

                                                <!-- ปุ่มเพิ่ม -->
                                                <button class="btn" style="border: 2px solid #a69feb" type="button" id="btn-increase">
                                                    <i class="tf-icons ti ti-plus"></i>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Radio: เปลี่ยนมิเตอร์ไฟ -->
                                        <div class="col-12">
                                            <div class="form-check">
                                                <input name="ref_reason_ele_id" class="form-check-input" type="radio" id="defaultRadio4" value="2" onclick="toggleReasonFieldsEle()">
                                                <label class="form-check-label" for="defaultRadio4">เปลี่ยนมิเตอร์ไฟ</label>
                                            </div>
                                        </div>

                                        <!-- รายละเอียดเพิ่มเติม (เมื่อเลือก "เปลี่ยนมิเตอร์ไฟ") -->
                                        <div id="div_reason4" class="col-12 px-5" style="display:none;">
                                            <div class="mb-3">
                                                <label for="meter_before_change[2]" class="form-label">
                                                    กรุณากรอกหน่วยมิเตอร์ล่าสุดของมิเตอร์ไฟตัวเก่า<span class="text-danger"> *</span>
                                                </label>
                                                <input type="number" name="meter_before_change[2]" class="form-control text-center" id="meter_electricity_before_change" autocomplete="off" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="start_value_of_new_meter" class="form-label">
                                                    กรุณากรอกหน่วยมิเตอร์เริ่มต้นของมิเตอร์ไฟตัวใหม่<span class="text-danger"> *</span>
                                                </label>
                                                <input type="number" name="start_value_of_new_meter[2]" class="form-control text-center" id="start_value_of_new_meter" autocomplete="off" value="0" required>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer rounded-0 justify-content-center">
                            <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                            <button type="submit" class="btn btn-main">บันทึก</button>
                        </div>
                    </form>

                </div>
            </div>
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

    function getMovingMeterRoomCount(callback) {
        $.ajax({
            type: "GET",
            url: "meter/get-moving-meter-room-count",
            success: function(data) {

                if (data.water && data.water.length > 0) {
                    $('#movingMeterWaterRoom').show();
                    document.getElementById('movingMeterWaterRoomCount').innerText = data.water.length;
                } else {
                    $('#movingMeterWaterRoom').hide();
                }

                if (data.electricity && data.electricity.length > 0) {
                    $('#movingMeterElectricityRoom').show();
                    document.getElementById('movingMeterElectricityRoomCount').innerText = data.electricity.length;
                } else {
                    $('#movingMeterElectricityRoom').hide();
                }
                
                if (callback) callback(data);
            }
        });
    }
    

    function showMovingMeterRoomCount() {
        // alert(123);
        getMovingMeterRoomCount(function(room) {
            alertMovingMeterRoomCount(room.water);
        });
    }

    function showMovingMeterElectricityRoomCount() {
        // alert(123);
        getMovingMeterRoomCount(function(room) {
            alertMovingMeterRoomCount(room.electricity);
        });
    }

    function alertMovingMeterRoomCount(room) {
        const movingRooms = room || [];
        // console.log(room);
        const count = movingRooms.length;

        if (count > 0) {
            Swal.fire({
                icon: 'warning',
                title: 'ห้องที่มีการเคลื่อนไหวมิเตอร์',
                html: movingRooms.map(r => `${r}`).join('<br>'),
                confirmButtonText: 'ตกลง'
            });
        } else {
            Swal.fire({
                icon: 'info',
                title: 'ไม่มีห้องที่มีการเคลื่อนไหวมิเตอร์',
                confirmButtonText: 'ตกลง'
            });
        }
    }

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
                $('[data-bs-toggle="tooltip"]').tooltip();
                getMovingMeterRoomCount();
            }
        });

    }
    const input = document.getElementById("max_meter");
    const btnPlus = document.getElementById("btn-increase");
    const btnMinus = document.getElementById("btn-decrease");

    btnPlus.addEventListener("click", () => {
        let value = input.value;
        input.value = value + "9"; // เพิ่ม 9 ต่อท้าย
    });

    btnMinus.addEventListener("click", () => {
        let value = input.value;
        if (value.length > 1) {
            input.value = value.slice(0, -1); // ลบ 1 หลักด้านท้าย
        }
    });
    function toggleReasonFields() {
            const input_reason = document.querySelector('input[name="ref_reason_id"]:checked').value;
            const div_reason1 = document.getElementById('div_reason1');
            const div_reason2 = document.getElementById('div_reason2');
            // หากเลือก โอนเงิน (value=2) ให้แสดงฟอร์มเพิ่ม
            if (input_reason == '1') {
                div_reason1.style.display = 'block';
                div_reason2.style.display = 'none';
            } else {
                div_reason1.style.display = 'none';
                div_reason2.style.display = 'block';
            }
        }
    function toggleReasonFieldsEle() {
            const input_reason = document.querySelector('input[name="ref_reason_ele_id"]:checked').value;
            const div_reason3 = document.getElementById('div_reason3');
            const div_reason4 = document.getElementById('div_reason4');
            // หากเลือก โอนเงิน (value=2) ให้แสดงฟอร์มเพิ่ม
            if (input_reason == '1') {
                div_reason3.style.display = 'block';
                div_reason4.style.display = 'none';
            } else {
                div_reason3.style.display = 'none';
                div_reason4.style.display = 'block';
            }
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
                getMovingMeterRoomCount();
            }
        });
        // alert(page);
    }
    
    function all_export_excel(){
        var searchWaterData = {};
        var fullUrl = '{{$page_url}}/all/export/excel';

        window.open(fullUrl, '_blank');
    }
    function water_export_excel(){
        var searchWaterData = {};

        $('.p_water_search').each(function() {
            var inputName = $(this).attr('name');
            var inputValue = $(this).val();
            searchWaterData[inputName] = inputValue;
        });

        // แปลงเป็น query string
        var queryString = Object.keys(searchWaterData)
            .map(key => encodeURIComponent(key) + '=' + encodeURIComponent(searchWaterData[key]))
            .join('&');

        var fullUrl = '{{$page_url}}/water/export/excel' + '?' + queryString;

        window.open(fullUrl, '_blank');
    }
    
    function electricity_export_excel(){
        var searchElectricityData = {};

        $('.p_electricity_search').each(function() {
            var inputName = $(this).attr('name');
            var inputValue = $(this).val();
            searchElectricityData[inputName] = inputValue;
        });

        // แปลงเป็น query string
        var queryString = Object.keys(searchElectricityData)
            .map(key => encodeURIComponent(key) + '=' + encodeURIComponent(searchElectricityData[key]))
            .join('&');

        var fullUrl = '{{$page_url}}/electricity/export/excel' + '?' + queryString;

        window.open(fullUrl, '_blank');
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