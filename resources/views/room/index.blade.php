<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template">

<head>
    @include('layout/inc_header')
    <title>Dashboard - CRM | Vuexy - Bootstrap Admin Template</title>
</head>

<div id="loadingOverlay" style="display: none;">
  <div class="spinner"></div>
</div>

<style>
  /* พื้นหลังทึบ */
  #loadingOverlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.8);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  /* สปินเนอร์หมุน */
  .spinner {
    border: 8px solid #f3f3f3;
    border-top: 8px solid #28c76f;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>

<style>
    .new_box .col-md-6 {
        padding: 5px 12px;
    }
    .table th {
        font-size: 15px;
        font-weight: bold;
        border: 1px solid #dbdade
    }
    .border-dbdade th {
        border: 1px solid #dbdade
    }
    .border-dbdade td {
        border: 1px solid #dbdade
    }
    .modalHeadDecor .modal-header {
        padding: 0;
    }

    .modalHeadDecor .modal-title {
        padding: 1.25rem 0.5rem 1.25rem 1.25rem;
        color: white;
        background-color: #54BAB9;
        position: relative;
    }

    .modalHeadDecor .modal-title::after {
        position: absolute;
        top: 0;
        right: -64px;
        content: '';
        width: 0;
        height: 0;
        border-top: 67px solid #54BAB9;
        border-right: 65px solid transparent;
    }

    #pills-tablayout button {
        background: transparent;
    }

    #pills-tablayout button.active {
        color: #54BAB9 !important;
    }

    .select-floor {
        width: 100px;
    }

    .box {
        display: none;
    }

    @media screen and (min-width:1024px) {
        .col-lg5 {
            width: calc(100%/5);
        }
    }


    @media screen and (max-width:767px) {
        .select-floor {
            width: 100%;
        }
    }
</style>

{{-- <link rel="stylesheet" href="assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="assets/vendor/libs/bootstrap-select/bootstrap-select.css" /> --}}

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
                                    <div class="card-header">
                                        <div class="row g-3 justify-content-between">
                                            <div class="col-sm-12">
                                                <h4 class="mb-0">
                                                    <i class="tf-icons ti ti-sitemap text-main ti-xl me-2"></i>
                                                    ผังห้อง
                                                </h4>
                                            </div>
                                        <div class="col-xl-12 col-lg-5 col-12">
                                            <div class="card bg-light-danger">
                                            <div class="d-flex align-items-end row">
                                                <div class="col-7" style="line-height: 2.2;">
                                                <div class="card-body text-nowrap">
                                                    <h5 class="text-white card-title mb-0">มีห้องที่ค้างชำระ</h5>
                                                    <p class="text-white mb-2">จำนวน</p>
                                                    <div style="display: flex;align-items: center;gap: 10px;">
                                                        <h4 class="text-white mr-2 my-auto">{{ $summary['all_overdue'] }} ห้อง</h4>
                                                        <a href="dashboard/overdue" class="btn bg-label-warning text-black">รายละเอียด</a>
                                                    </div>
                                                </div>
                                                </div>
                                                <div class="col-5 text-center text-sm-left">
                                                <div class="card-body pb-0 px-0 px-md-4 pt-2" align="right">
                                                    <img
                                                    src="../../assets/img/illustrations/girl-with-laptop.png"
                                                    height="155"
                                                    alt="view sales" />
                                                </div>
                                                </div>
                                            </div>
                                            </div>
                                        </div>
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="card card-border-shadow-primary">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center mb-2 pb-1">
                                                            <div class="avatar me-2" style="cursor: unset;">
                                                            <span class="avatar-initial rounded bg-label-primary"><i class="ti ti-chart-pie-2 ti-md"></i></span>
                                                            </div>
                                                            <h4 class="ms-1 mb-0"><span id="percent">{{ $summary['percent'] }}</span> %</h4>
                                                        </div>
                                                        <p class="mb-1">อัตราการเข้าพัก</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="card card-border-shadow-warning">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center mb-2 pb-1">
                                                            <div class="avatar me-2" style="cursor: unset;">
                                                            <span class="avatar-initial rounded bg-label-info"><i class="ti ti-calendar-time ti-md"></i></span>
                                                            </div>
                                                            <h4 class="ms-1 mb-0"><span id="all_booking_room">{{ $summary['all_booking_room'] }}</span> ห้อง</h4>
                                                        </div>
                                                        <p class="mb-1">ห้องจอง</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="card card-border-shadow-danger">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center mb-2 pb-1">
                                                            <div class="avatar me-2" onclick="location.href='/dashboard/overdue';">
                                                            <span class="avatar-initial rounded bg-label-danger"><i class="ti ti-report-money ti-md"></i></span>
                                                            </div>
                                                            <h4 class="ms-1 mb-0">{{ $summary['all_overdue'] }} ห้อง</h4>
                                                        </div>
                                                        <p class="mb-1">ค้างชำระ</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-lg-3">
                                                <div class="card card-border-shadow-info">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center mb-2 pb-1">
                                                            <div class="avatar me-2" style="cursor: unset;">
                                                            <span class="avatar-initial rounded bg-label-success"><i class="ti ti-door ti-md"></i></span>
                                                            </div>
                                                            <h4 class="ms-1 mb-0"><span id="vacant_room">{{ $summary['vacant_room'] }}</span> ห้อง</h4>
                                                        </div>
                                                        <p class="mb-1">ห้องว่าง</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                                    <div class="row border-bottom border-top border-light p-3">
                                        <div class="row mt-3">
                                            <div class="col-md-3" style="padding-right: unset !important;">
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                                                    <input
                                                        name="search"
                                                        type="text"
                                                        class="form-control p_search"
                                                        placeholder="Search..."
                                                        aria-label="Search..."
                                                        oninput="loadData('{{$page_url}}/datatable')"
                                                        aria-describedby="basic-addon-search31" />
                                                  </div>
                                            </div>
                                            <div class="col-md-3 select_off" style="padding-right: unset !important;">
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <select onchange='loadData("{{$page_url}}/datatable")' name="building" id="selectpickerBuilding" class="select2 form-select form-select-lg p_search" data-style="btn-default">
                                                                <option value="all">ทุกตึก</option>
                                                                @foreach ($buildings as $b)
                                                                    <option value="{{ $b->id }}">{{ $b->name }}</option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <select onchange='loadData("{{$page_url}}/datatable")' name="floor" id="selectpickerFloor" class="select2 form-select form-select-lg p_search" data-style="btn-default" disabled>
                                                                <option value="all">ทุกชั้น</option>
                                                                @foreach ($floors as $f)
                                                                    <option value="{{ $f->id }}">{{ $f->name }}</option>
                                                                @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6 text-end" style="padding-right: unset !important;">
                                                <button
                                                        style="padding-right: 14px;padding-left: 14px;"
                                                        class="btn btn-success buttons-collection btn-warning waves-effect waves-light me-2"
                                                        tabindex="0" aria-controls="DataTables_Table_0"
                                                        type="button" aria-haspopup="dialog"
                                                        {{-- aria-expanded="false"
                                                        data-bs-toggle="modal" data-bs-target="#deposit" --}}
                                                        onclick="window.open('{{$page_url}}/export/excel', '_blank')"
                                                        >
                                                <span>
                                                <i class="ti ti-upload"></i> ดาวน์โหลด Excel</span>
                                                </button>
                                                <button
                                                        style="padding-right: 14px;padding-left: 14px;margin-right: 0px;"
                                                        class="btn btn-info buttons-collection btn-info"
                                                        tabindex="0" aria-controls="DataTables_Table_0"
                                                        type="button" aria-haspopup="dialog"
                                                        aria-expanded="false" data-bs-toggle="modal" data-bs-target="#insertRenter"
                                                        onclick="reserve()"
                                                        >
                                                    <span><i class="ti ti-plus"></i> จองห้อง</span>
                                                </button>
                                                <button
                                                        style="padding-right: 14px;padding-left: 14px;margin-right: 0px;"
                                                        class="btn btn-success buttons-collection btn-success"
                                                        tabindex="0" aria-controls="DataTables_Table_0"
                                                        type="button" aria-haspopup="dialog"
                                                        aria-expanded="false" data-bs-toggle="modal" data-bs-target="#roomRentalContract">
                                                    <span><i class="ti ti-plus"></i> ทำสัญญาเช่า</span>
                                                </button>
                                                <button
                                                        style="padding-right: 14px;padding-left: 14px;margin-right: 0px;"
                                                        class="btn btn-danger buttons-collection btn-danger"
                                                        tabindex="0" aria-controls="DataTables_Table_0"
                                                        type="button" aria-haspopup="dialog"
                                                        aria-expanded="false" data-bs-toggle="modal" data-bs-target="#roomRentalReservation">
                                                    <span><i class="ti ti-plus"></i> ชำระค่าจอง</span>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 mt-4">
                                            <div class="d-flex align-items-center mb-2 mb-md-0">
                                                <label class="">Show</label>
                                                <select onchange='loadData("{{$page_url}}/datatable")' name="limit" class="form-select ms-2 me-2 p_search" style="width:100px">
                                                    <option value="10">10</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                    <option value="150">150</option>
                                                </select>
                                                <ul class="nav nav-pills" id="pills-tablayout" role="tablist">
                                                    <li class="nav-item me-1" role="presentation">
                                                        <button type="button" onclick="ch_div('pills-home')"
                                                            class="btn btn-icon btn-sm btn-label-secondary waves-effect"
                                                            id="pills-home-tab" data-bs-toggle="pill"
                                                            data-bs-target="#pills-home" type="button" role="tab"
                                                            aria-controls="pills-home" aria-selected="true">
                                                            <span class="ti ti-layout-grid ti-md"></span>
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button type="button" onclick="ch_div('pills-profile')"
                                                            class="btn btn-icon btn-sm btn-label-secondary waves-effect active"
                                                            data-bs-toggle="pill" data-bs-target="#pills-profile"
                                                            type="button" role="tab" aria-controls="pills-profile"
                                                            aria-selected="false">
                                                            <span class="ti ti-list ti-md"></span>
                                                        </button>
                                                    </li>
                                                </ul>
                                                {{-- <ul class="nav nav-pills" id="pills-tablayout" role="tablist">
                                                    <li class="nav-item me-1" role="presentation">
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-label-secondary waves-effect active"
                                                            id="pills-home-tab" data-bs-toggle="pill"
                                                            data-bs-target="#pills-home" type="button" role="tab"
                                                            aria-controls="pills-home" aria-selected="true">
                                                            <span class="ti ti-layout-grid ti-md"></span>
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-label-secondary waves-effect"
                                                            data-bs-toggle="pill" data-bs-target="#pills-profile"
                                                            type="button" role="tab" aria-controls="pills-profile"
                                                            aria-selected="false">
                                                            <span class="ti ti-list ti-md"></span>
                                                        </button>
                                                    </li>
                                                </ul> --}}
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="card-body px-0 pt-0">
                                        <div class="tab-content p-0" id="pills-tabContent">
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
    <!--set rent Modal -->
    <div class="modal fade modalHeadDecor" id="insertRenter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">เพิ่มการจอง</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="insert_renter">
                    @csrf
                <div class="modal-body" id="reserve">
                    {{-- @include('room/room-reserve-form') --}}
                </div>
                <div class="modal-footer rounded-0 justify-content-center">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-main">บันทึก</button>
                </div>
                </form>
            </div>
        </div>
    </div>
<div class="modal fade modalHeadDecor" id="roomRentalContract" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">ทำสัญญาเช่าหลายห้อง</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="insert_contract">
                    @csrf
                    <div class="modal-body">
                        <div class="p-2">
                            <label class="h5 mb-1">เลือกข้อมูลจากผู้เช่า</label>
                                <select name="ref_renter_id" id="select2Renter" class="select2 form-select form-select-lg" onchange="get_room_rental_contract(this.value)" required>
                                    <option selected disabled hidden value="no">เลือกข้อมูลจากผู้เช่า</option>
                                    @foreach ($renter_contract as $rent)
                                        <option value="{{ $rent->renter->id }}">{{ $rent->renter->prefix.' '.$rent->renter->name.' '.$rent->renter->surname }}</option>
                                    @endforeach
                                </select>
                                
                        </div>
                        <div id="room-rental-contract">

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
<div class="modal fade modalHeadDecor" id="roomRentalReservation" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">ชำระค่าจองหลายห้อง</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="reservation_form_all" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="p-2">
                            <label class="h5 mb-1">เลือกข้อมูลจากผู้เช่า</label>
                                <select name="ref_renter_id" id="select2Renter2" class="select2 form-select form-select-lg" onchange="get_room_rental_reservation(this.value)" required>
                                    <option selected hidden value="no">เลือกข้อมูลจากผู้เช่า</option>
                                    @foreach ($renter as $rent)
                                        <option {{$rent->contracts_id}} value="{{ $rent->id }}">{{ $rent->prefix.' '.$rent->name.' '.$rent->surname }}</option>
                                    @endforeach
                                </select>
                                
                        </div>
                        <div id="room-rental-reservation">

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
    <div class="modal fade modalHeadDecor" id="insurance" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document" id="view">
            
        </div>
    </div>

    <div class="modal fade modalHeadDecor" id="editAssetModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <span class="modal-title">
                        <span class="h5" style="color: white;">&nbsp;แก้ไขข้อมูลทรัพย์สิน&nbsp;</span>
                    </span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-md-12" style="padding-right: unset !important;">
                    <div class="card shadow-none bg-transparent mb-3">
                        <div class="modal-body px-5">
                
                            <form method="POST" enctype="multipart/form-data" id="formAssetModal">
                                
                            </form>
            <!-- ชื่อทรัพย์สิน + โทรทัศน์ -->

                        </div>
                    </div>
                </div>
                <div class="modal-footer border-0 justify-content-end">
                    {{-- <button type="button" class="btn btn-light" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-info text-white">บันทึก</button> --}}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade modalHeadDecor" id="deposit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <span class="modal-title">
                        <span class="h5" style="color: white;">&nbsp;ชำระค่าประกัน&nbsp;</span>
                    </span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-md-12" style="padding-right: unset !important;">
                    <div class="card shadow-none bg-transparent mb-3">
                        <div class="card-body">
                            <form id="deposit_form">
                                {{-- @include('room/room-deposit-form') --}}

                                {{-- จ่ายค่าประกันห้อง แสดง ตรงนี้ --}}
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modalHeadDecor" id="reservation" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <span class="modal-title">
                        <span class="h5" style="color: white;">&nbsp;ชำระค่าจองห้อง&nbsp;</span>
                    </span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="col-md-12" style="padding-right: unset !important;">
                    <div class="card shadow-none bg-transparent mb-3">
                        <div class="card-body">
                            <form id="reservation_form">
                                {{-- @include('room/room-reservation-form') --}}

                                {{-- จ่ายค่าประกันห้อง แสดง ตรงนี้ --}}
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
    {{-- ///////////////////////////////////////////////////////////// --}}
    @include('room/add-renter')
    {{-- ///////////////////////////////////////////////////////////// --}}


    <!-- / Layout wrapper -->
    @include('layout/inc_js')
    {{-- <script src="assets/vendor/libs/select2/select2.js"></script>
    <script src="assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="assets/js/forms-selects.js"></script> --}}
    <script>
        
        var page = "{{$page_url}}/datatable";
        var searchData = {};
        loadData(page);
        
        var ch = "pills-profile";
        function ch_div(id_ch){
            ch = id_ch;
        }
        function openDe(rent_bill_id, contract_id){
            $.ajax({
                type: "GET",
                url: "{{$page_url}}/get-deposit",
                data:{
                    rent_bill_id: rent_bill_id,
                    contract_id: contract_id
                },
                success: function(data) {
                    $("#deposit_form").html(data);
                    var myModal = new bootstrap.Modal(document.getElementById('deposit'));
                        myModal.show();
                }
            });
            // var myModal = new bootstrap.Modal(document.getElementById('deposit'));
            //     myModal.show();
        }

        function openReservation(rent_bill_id){
            $.ajax({
                type: "GET",
                url: "{{$page_url}}/get-reservation",
                data:{
                    rent_bill_id: rent_bill_id
                },
                success: function(data) {
                    $("#reservation_form").html(data);
                    var myModal = new bootstrap.Modal(document.getElementById('reservation'));
                        myModal.show();
                }
            });
            // var myModal = new bootstrap.Modal(document.getElementById('reservation'));
            //     myModal.show();
        }
        // function exportExcel(){
            
        // }
        function view(id){
            $.ajax({
                type: "GET",
                url: "{{$page_url}}/"+id,
                success: function(data) {
                    $("#view").html(data);
                    // $('#select2District').select2('destroy');

                    $('#change_room').select2({
                        placeholder: 'ย้ายห้อง',
                        allowClear: true,
                        dropdownParent: $('#insurance'), // 💥 สำคัญมาก ถ้าอยู่ใน modal
                        width: '100%'
                    });
                    $('#select2month').select2({
                        placeholder: 'เลือกเดือน',
                        allowClear: true,
                        dropdownParent: $('#insurance'), // 💥 สำคัญมาก ถ้าอยู่ใน modal
                        width: '100%'
                    });
                    // setTimeout(() => {
                    //     alert(154)
                    $('#select2RenterMove').select2({
                            dropdownParent: $('#insurance'), // 💥 สำคัญมาก ถ้าอยู่ใน modal
                        });

                        // $('#select2RenterMove').select2({
                        //     placeholder: 'เลือกข้อมูลจากผู้เช่า',
                        //     allowClear: true,
                        //     dropdownParent: $('#insurance'), // 💥 สำคัญมาก ถ้าอยู่ใน modal
                        //     width: '100%'
                        // });
                    // }, 100);
                    $('#select2RenterContract2').select2({
                        placeholder: 'เลือกข้อมูลจากผู้เช่า',
                        allowClear: true,
                        dropdownParent: $('#insurance'), // 💥 สำคัญมาก ถ้าอยู่ใน modal
                        width: '100%'
                    });
                }
            });
        }

        function reserve(){
            document.getElementById('loadingOverlay').style.display = 'flex';
            $.ajax({
                type: "GET",
                url: "{{$page_url}}/reserve",
                success: function(data) {
                    $("#reserve").html(data);
                    // $('#select2Basic').select2();
                    $('#select2Basic').select2({
                        placeholder: 'เลือกอำเภอ',
                        allowClear: true,
                        dropdownParent: $('#insertRenter'), // 💥 สำคัญมาก ถ้าอยู่ใน modal
                        width: '100%'
                    });
                    $('#select2District99').select2({
                        placeholder: 'เลือกอำเภอ',
                        allowClear: true,
                        dropdownParent: $('#insertRenter'), // 💥 สำคัญมาก ถ้าอยู่ใน modal
                        width: '100%'
                    });
                    $('#select2Subdistrict').select2({
                        placeholder: 'เลือกตำบล',
                        allowClear: true,
                        dropdownParent: $('#insertRenter'), // 💥 สำคัญมาก ถ้าอยู่ใน modal
                        width: '100%'
                    });
                    
                    $('#bs-datepicker-format').datepicker({
                        format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่
                        autoclose: true,      // ปิด datepicker เมื่อเลือกวันที่
                        todayHighlight: true  // ไฮไลต์วันที่ปัจจุบัน
                    });
                    $('#bs-datepicker-format2').datepicker({
                        format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่
                        autoclose: true,      // ปิด datepicker เมื่อเลือกวันที่
                        todayHighlight: true  // ไฮไลต์วันที่ปัจจุบัน
                    });
                    $('#exampleFormControlInput13').datepicker({
                        format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่
                        autoclose: true,      // ปิด datepicker เมื่อเลือกวันที่
                        todayHighlight: true  // ไฮไลต์วันที่ปัจจุบัน
                    });
                    $('#exampleFormControlInput33').datepicker({
                        format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่
                        autoclose: true,      // ปิด datepicker เมื่อเลือกวันที่
                        todayHighlight: true  // ไฮไลต์วันที่ปัจจุบัน
                    });
                    
                    document.getElementById('loadingOverlay').style.display = 'none';
                }
            });
        }
        
        function getDetailAsset(room_id, asset_id){
            $.ajax({
                type: "GET",
                url: "{{$page_url}}/asset/"+room_id+"/"+asset_id,
                success: function(data) {
                    $("#formAssetModal").html(data);
                    var myModal = new bootstrap.Modal(document.getElementById('editAssetModal'));
                        myModal.show();
                    // $('#select2District').select2('destroy');
                }
            });
        }
        function get_room_rental_contract(id){
            $.ajax({
                type: "GET",
                url: "{{ $page_url }}/get-room-rental-contract/"+id,
                success: function(data) {
                    $("#room-rental-contract").html(data);
                }
            });
        }
        function get_room_rental_reservation(id){
            if(id == 'no'){
                $("#room-rental-reservation").html('');
            }
            $.ajax({
                type: "GET",
                url: "{{ $page_url }}/get-room-rental-reservation/"+id,
                success: function(data) {

                    $('#select2RenterReservation').select2();

                    $("#room-rental-reservation").html(data);
                }
            });
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
                    $("#pills-tabContent").html(data);
                    $('#'+ch).addClass('active');
                    
                    // $("#table-data").html(data);
                }
            });
            // alert(page);
        }
        function summary(){
            // alert(page);
            $.ajax({
                type: "GET",
                url: 'room/summary',
                success: function(data) {
                    // $("#pills-tabContent").html(data);
                    $('#all_booking_room').html(data.all_booking_room);
                    $('#vacant_room').html(data.vacant_room);
                    // $('#').html(data.);
                    $('#percent').html(data.percent);
                    
                    // $("#table-data").html(data);
                }
            });
            // alert(page);
        }
        function room_selected() {
            document.getElementById('loadingOverlay').style.display = 'flex';
             $.ajax({
                url: '/room/selected', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                type: 'get',
                data: $('#insert_renter .room-selected:checked').serialize(),
                success: function(response) {
                        document.getElementById('loadingOverlay').style.display = 'none';
                        $("#room-selected").html(response);
                        // Swal.fire('เพิ่มการจองเรียบร้อยแล้ว', '', 'success');
                        // $('#addserviceModal').modal('hide');
                        // setTimeout(function() {
                        //   location.reload();
                        // }, 4000);
                },
                error: function(error) {
                    Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                    console.error('เกิดข้อผิดพลาด:', error);
                }
            });
        };
        $('#select2District').select2();
        $('#select2District99').select2();
        $('#select2Subdistrict').select2();
        
        $('#insert_renter').on('submit', function(event) {  // อันนี้คือ เพิ่มการจอง
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            const selectChannel = document.querySelector('input[name="select_channel"]:checked').value;

            if($('#check_selected').val() == 0 && selectChannel == 2){
                return Swal.fire('! โปรดเลือกห้องเช่า', '', 'warning');
            }
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการเพิ่ม การจอง หรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                showDenyButton: false,
                didOpen: () => {
                    // โฟกัสที่ปุ่ม confirm
                    Swal.getConfirmButton().focus();
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/room', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response == true){
                                $('#insertRenter').modal('hide');
                                $('#insert_renter')[0].reset();
                                loadData(page);
                                summary();
                                Swal.fire('เพิ่มการจองเรียบร้อยแล้ว', '', 'success');
                            }else{
                                Swal.fire({ html: `<div style="color:red; font-size: 20px;">${response.message}</div>`, icon: 'error'} );
                            }
                        },
                        error: function(error) {
                            Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                            console.error('เกิดข้อผิดพลาด:', error);
                        }
                    });
                } else if (result.isDismissed) {
                    // Swal.fire('ยกเลิกการดำเนินการ', '', 'info');
                }
            });
        });
        $('#insert_renterAddRenter').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการเพิ่ม ผู้เช่า หรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                showDenyButton: false,
                didOpen: () => {
                    // โฟกัสที่ปุ่ม confirm
                    Swal.getConfirmButton().focus();
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/room/insert_renter', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response == true){
                                // $('#insertRenter').modal('hide');
                                $('#insert_renterAddRenter')[0].reset();
                                loadData(page);
                                summary();
                                Swal.fire('เพิ่มผู้เช่าเรียบร้อยแล้ว', '', 'success');
                            }
                        },
                        error: function(error) {
                            Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                            console.error('เกิดข้อผิดพลาด:', error);
                        }
                    });
                } else if (result.isDismissed) {
                    // Swal.fire('ยกเลิกการดำเนินการ', '', 'info');
                }
            });
        });
        
        $('#insert_contract').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการเพิ่ม สัญญา หรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                showDenyButton: false,
                didOpen: () => {
                    // โฟกัสที่ปุ่ม confirm
                    Swal.getConfirmButton().focus();
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/room/insert_contract', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response.success == true){
                                $('#roomRentalContract').modal('hide');
                                $('#insert_contract')[0].reset();
                                loadData(page);
                                summary();
                                Swal.fire('เพิ่มสัญญาเรียบร้อยแล้ว', '', 'success').then((result) => {
                                    location.reload();
                                });
                                // $('#room-rental-contract').html('');
                            }
                        },
                        error: function(error) {
                            Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                            console.error('เกิดข้อผิดพลาด:', error);
                        }
                    });
                } else if (result.isDismissed) {
                    // Swal.fire('ยกเลิกการดำเนินการ', '', 'info');
                }
            });
        });

        $('#deposit_form').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if (!this.checkValidity()) {
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }

            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ ชำระเงิน หรือไม่?',
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
                    let form = document.getElementById('deposit_form');
                    let formData = new FormData(form);
                    formData.append('_token', '{{ csrf_token() }}'); // สำหรับ Laravel CSRF

                    $.ajax({
                        url: '{{$page_url}}/receipt',
                        type: 'POST',
                        data: formData,
                        contentType: false, // ต้องมีเพื่อให้ส่ง multipart/form-data ได้
                        processData: false,
                        success: function(response) {
                            // return 1;
                            if (response == true) {
                                var modalEl = document.getElementById('deposit');
                                var modalInstance = bootstrap.Modal.getInstance(modalEl); // <-- ดึง instance ที่เปิดอยู่
                                if (modalInstance) {
                                    modalInstance.hide(); // <-- ซ่อน modal ที่เปิดอยู่จริง
                                }
                                Swal.fire('ชำระเงิน เรียบร้อยแล้ว', '', 'success');
                                loadData(page);
                                get_contract();
                            }
                        },
                        error: function(error) {
                            Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                            console.error('เกิดข้อผิดพลาด:', error);
                        }
                    });
                }
            });
        });

        $('#reservation_form').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ

            if (!this.checkValidity()) {
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }

            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ ชำระเงิน ค่าจองห้อง หรือไม่?',
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
                    let form = document.getElementById('reservation_form');
                    let formData = new FormData(form);
                    formData.append('_token', '{{ csrf_token() }}'); // สำหรับ Laravel CSRF

                    $.ajax({
                        url: '{{$page_url}}/receipt',
                        type: 'POST',
                        data: formData,
                        contentType: false, // ต้องมีเพื่อให้ส่ง multipart/form-data ได้
                        processData: false,
                        success: function(response) {
                            if (response == true) {
                                var modalEl = document.getElementById('reservation');
                                var modalInstance = bootstrap.Modal.getInstance(modalEl); // <-- ดึง instance ที่เปิดอยู่
                                if (modalInstance) {
                                    modalInstance.hide(); // <-- ซ่อน modal ที่เปิดอยู่จริง
                                }
                                Swal.fire('ชำระเงิน ค่าจองห้อง เรียบร้อยแล้ว', '', 'success');
                                loadData(page);
                            }
                        },
                        error: function(error) {
                            Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                            console.error('เกิดข้อผิดพลาด:', error);
                        }
                    });
                }
            });
        });
        
        $('#reservation_form_all').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ

            if (!this.checkValidity()) {
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }

            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ ชำระเงิน ค่าจองห้อง หรือไม่?',
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
                    let form = document.getElementById('reservation_form_all');
                    let formData = new FormData(form);
                    formData.append('_token', '{{ csrf_token() }}'); // สำหรับ Laravel CSRF

                    $.ajax({
                        url: '{{$page_url}}/receipt/all',
                        type: 'POST',
                        data: formData,
                        contentType: false, // ต้องมีเพื่อให้ส่ง multipart/form-data ได้
                        processData: false,
                        success: function(response) {
                            if (response == true) {
                                var modalEl = document.getElementById('roomRentalReservation');
                                var modalInstance = bootstrap.Modal.getInstance(modalEl); // <-- ดึง instance ที่เปิดอยู่
                                if (modalInstance) {
                                    modalInstance.hide(); // <-- ซ่อน modal ที่เปิดอยู่จริง
                                }
                                Swal.fire('ชำระเงิน ค่าจองห้อง เรียบร้อยแล้ว', '', 'success');
                                loadData(page);
                            }
                        },
                        error: function(error) {
                            Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                            console.error('เกิดข้อผิดพลาด:', error);
                        }
                    });
                }
            });
        });

        $(document).ready(function() {
            $('#select2Basic').change(function() {
                var provinceId = $(this).val();
                
                // เคลียร์ dropdown สำหรับอำเภอและตำบล
                $('#select2District99').empty().append('<option selected disabled hidden value="">เลือกอำเภอ</option>');
                $('#select2Subdistrict').empty().append('<option selected disabled hidden value="">เลือกตำบล</option>');

                if (provinceId) {
                    $.ajax({
                        url: '/get-districts/' + provinceId,
                        type: 'GET',
                        success: function(data) {
                            data.forEach(function(district) {
                                $('#select2District99').append('<option value="' + district.id + '">' + district.name_in_thai + '</option>');
                            });
                        }
                    });
                }
            });

            $('#select2District99').change(function() {
                var districtId = $(this).val();
                
                // เคลียร์ dropdown สำหรับตำบล
                $('#select2Subdistrict').empty().append('<option selected disabled hidden value="">เลือกตำบล</option>');

                if (districtId) {
                    $.ajax({
                        url: '/get-subdistricts/' + districtId,
                        type: 'GET',
                        success: function(data) {
                            data.forEach(function(subdistrict) {
                                $('#select2Subdistrict').append('<option value="' + subdistrict.id + '">' + subdistrict.name_in_thai + '</option>');
                            });
                        }
                    });
                }
            });

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
            
            $('#select2Subdistrict').change(function() {
                var subdistrictsid = $(this).val();
                if (subdistrictsid) {
                    $.ajax({
                        url: '/get-zipcode/' + subdistrictsid,
                        type: 'GET',
                        success: function(data) {
                            $('#zipcode').val(data);
                        }
                    });
                }
            });
        });
        

    </script>
    
    {{-- <script>
                                                
        var modalElement = document.getElementById('roomRentalContract');
        var insuranceModal = new bootstrap.Modal(modalElement);

        modalElement.addEventListener('hidden.bs.modal', function () {
            // console.log("Modal is hidden");
            document.querySelector('.select_off').style.display = 'block';
        });
        modalElement.addEventListener('shown.bs.modal', function () {
            // console.log("Modal is hidden");
            document.querySelector('.select_off').style.display = 'none';
        });
        </script> --}}
</body>

</html>
