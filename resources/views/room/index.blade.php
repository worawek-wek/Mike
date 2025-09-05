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
    .table-detail {
        border-collapse: collapse; /* รวมเส้นขอบของตาราง */
        border-radius: 5px;
        overflow: hidden;
    }
    .table-detail th, .table-detail td {
        border: 1px solid #d9d9d9 !important; /* กำหนดเส้นขอบของ th และ td */
    }
    .table-detail th {
        vertical-align: middle;
        font-weight: 500;
        font-size: 14px;
        color: black !important;
    }
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
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<!-- ก่อน </body> -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
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
                                                        <h4 class="text-white mr-2 my-auto">{{ $summary['overdueRoomCount'] }} ห้อง</h4>
                                                        @if ($summary['overdueRoomCount'] > 0)
                                                            <a href="dashboard/overdue" class="btn bg-label-warning text-black">รายละเอียด</a>
                                                        @endif
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
                                                            <div class="avatar me-2"
                                                                @if ($summary['overdueRoomCount'] > 0)
                                                                    onclick="location.href='/dashboard/overdue';"
                                                                @else
                                                                    style="cursor: unset;"
                                                                @endif
                                                            >
                                                            <span class="avatar-initial rounded bg-label-danger"><i class="ti ti-report-money ti-md"></i></span>
                                                            </div>
                                                            <h4 class="ms-1 mb-0">{{ $summary['overdueRoomCount'] }} ห้อง</h4>
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
                                                        aria-expanded="false" data-bs-toggle="modal" data-bs-target="#roomRentalContract"
                                                        onclick="roomRentalContract()">
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
                    <div class="modal-body" id="formRoomRentalContract">
                        
                    </div>
                    <div class="modal-footer rounded-0 justify-content-center">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" id="submit_insert_contract" class="btn btn-main" disabled >บันทึก</button>
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
                        <button type="submit" id="submit_reservation_form_all" class="btn btn-main" disabled>บันทึก</button>
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

                                {{-- จ่ายค่าจองห้อง แสดง ตรงนี้ --}}
                                
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="imageModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body p-3">
                    <img id="previewImage" src="" class="img-fluid w-100" alt="Preview">
                </div>
                <div class="modal-footer rounded-0 justify-content-center">
                    <button type="button" class="btn btn-label-secondary text-black" data-bs-dismiss="modal">ปิด</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modalHeadDecor" id="move-out-upload" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">อัพโหลดหลักฐาน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="asset_upload_image_move_out" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="room_has_asset_id">
                    <div class="modal-body px-5">
                        <div class="row mt-1">
                            <label for="image" class="col-sm-12 col-form-label text-black">
                            <strong>อัพโหลดรูปภาพก่อนย้ายออก</strong>
                            <input class="form-control mt-1" type="file" id="image_move_out" name="image_move_out" accept="image/*" onchange="previewImageMoveOutImage(event)">
                            </label>
                        </div>

                        <div class="row mt-2">
                            <div class="col-sm-12">
                            <img id="image_move_out_preview" alt="Preview" style="display: none;" class="img-thumbnail">
                            </div>
                        </div>
                        
                        <script>
                            function previewImageMoveOutImage(event) {
                                const input = event.target;
                                const preview = document.getElementById('image_move_out_preview');
                            
                                if (input.files && input.files[0]) {
                                    const reader = new FileReader();
                            
                                    reader.onload = function(e) {
                                    preview.src = e.target.result;
                                    preview.style.display = 'block';
                                    };
                            
                                    reader.readAsDataURL(input.files[0]);
                                } else {
                                    preview.src = '#';
                                    preview.style.display = 'none';
                                }
                            }
                        </script>
                    </div>
                    <div class="modal-footer rounded-0 justify-content-center">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-main">อัพโหลด</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
<div class="modal fade modalHeadDecor" id="addRenter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0">
                <h5 class="modal-title" id="exampleModalLabel1">เพิ่มผู้เช่าห้อง</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form_renterAddRenter">
                @csrf
            <div class="modal-body" id="bodyAddRenter">
                {{-- Form เพิ่มผู้เช่าห้อง อยู่ตรงนี้ นะจ๊ะ --}}
            </div>
            <div class="modal-footer rounded-0 justify-content-center">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-main">บันทึก</button>
            </div>
            </form>
        </div>
    </div>
</div>
    <div class="modal fade modalHeadDecor" id="move-out-edit-meter" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0" id="view-edit-meter">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">เพิ่มค่าน้ำ-ค่าไฟ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="asset_upload_image_move_out" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="id" id="room_has_asset_id">
                    <div class="modal-body px-5">
                        <table class="table table-detail table-bordered" id="edit-meter-table">
                            <thead>
                                <tr align="center">
                                    <th width="30%">รายการ</th>
                                    <th>หน่วยก่อนหน้า</th>
                                    <th>หน่วยล่าสุด</th>
                                    <th width="25%">หน่วยที่ใช้</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr align="center" style="background: #ecfcff;">
                                    <td>มิเตอร์น้ำ</td>
                                    <td>
                                        <input type="number" class="form-control water-old" oninput="calculateUsed(this)" />
                                    </td>
                                    <td>
                                        <input type="number" class="form-control water-new" oninput="calculateUsed(this)" />
                                    </td>
                                    <td>
                                        <input type="number" class="form-control water-used" readonly />
                                    </td>
                                </tr>
                                <tr align="center" style="background: #ffeeec;">
                                    <td>มิเตอร์ไฟ</td>
                                    <td>
                                        <input type="number" class="form-control electric-old" oninput="calculateUsed(this)" />
                                    </td>
                                    <td>
                                        <input type="number" class="form-control electric-new" oninput="calculateUsed(this)" />
                                    </td>
                                    <td>
                                        <input type="number" class="form-control electric-used" readonly />
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="modal-footer rounded-0 justify-content-center">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="button" class="btn btn-main" onclick="addWaterElectric()">คำนวณ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    {{-- ///////////////////////////////////////////////////////////// --}}
    {{-- @include('room/add-renter') --}}
    {{-- ///////////////////////////////////////////////////////////// --}}


    <!-- / Layout wrapper -->
    @include('layout/inc_js')
    <script>
        let tomProvince = null;
        let tomDistrict = null;
        let tomSubdistrict = null;

        let tomProvince2 = null;
        let tomDistrict2 = null;
        let tomSubdistrict2 = null;

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
// function แสดงรูป ทรัพย์สิน ในย้ายออก
        function showImage(src) {
            document.getElementById('previewImage').src = src;

            // ดึง modal instance
            const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            imageModal.show();
        }

        function showUploadImage(id) {
            document.getElementById("asset_upload_image_move_out").reset();
            document.getElementById('image_move_out_preview').style.display = 'none';

            document.getElementById('room_has_asset_id').value = id;
            // ดึง modal instance

            const imageModal = new bootstrap.Modal(document.getElementById('move-out-upload'));
            imageModal.show();
        }
        function addRenter(room_id, renter_id = null) {
            
            const imageModal = new bootstrap.Modal(document.getElementById('addRenter'));
            imageModal.show();

            $.ajax({
                type: "GET",
                url: "{{$page_url}}/get-form-add-renter/"+room_id+"/"+renter_id,
                success: function(data) {
                    $("#bodyAddRenter").html(data);

                    tomProvince2 = new TomSelect("#select2BasicAddRenter", {
                                    create: false,
                                    maxItems: 1,
                                    allowEmptyOption: true,
                                    sortField: { field: "text", direction: "asc" }
                                });

                    tomDistrict2 = new TomSelect("#select2DistrictAddRenter", {
                                    create: false,
                                    maxItems: 1,
                                    allowEmptyOption: true,
                                    sortField: { field: "text", direction: "asc" }
                                });

                    tomSubdistrict2 = new TomSelect("#select2SubdistrictAddRenter", {
                                    create: false,
                                    maxItems: 1,
                                    allowEmptyOption: true,
                                    sortField: { field: "text", direction: "asc" }
                                });
                }
            });
        }

        function openReservation(rent_bill_id){ // show form ชำระค่าจอง
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
        function get_room_rental_reservation(id){ // Show form ชำระค่าจอง หลายห้อง
            if(id == 'no'){
                $("#room-rental-reservation").html('');
                $('#submit_reservation_form_all').prop('disabled', true);
                return false;
            }
            $.ajax({
                type: "GET",
                url: "{{ $page_url }}/get-room-rental-reservation/"+id,
                success: function(data) {

                    $("#room-rental-reservation").html(data);
                    $('#submit_reservation_form_all').prop('disabled', false);

                }
            });
        }
        // function exportExcel(){
            
        // }
        var view_id = 0;
        function view(id){
            view_id = id;
            $.ajax({
                type: "GET",
                url: "{{$page_url}}/"+id,
                success: function(data) {
                    $("#view").html(data);
                    // $('#select2District').select2('destroy');

                    // setTimeout(() => {
                    //     new TomSelect('#select2RenterMove');
                    // }, 1000);
                    new TomSelect("#change_room", {
                                    create: false,
                                    maxItems: 1,
                                    allowEmptyOption: true,
                                    sortField: { field: "text", direction: "asc" }
                                });
                    // $('#change_room').select2({
                    //     placeholder: 'ย้ายห้อง',
                    //     allowClear: true,
                    //     dropdownParent: $('#insurance'), // 💥 สำคัญมาก ถ้าอยู่ใน modal
                    //     width: '100%'
                    // });
                    $('#select2month').select2({
                        placeholder: 'เลือกเดือน',
                        allowClear: true,
                        dropdownParent: $('#insurance'), // 💥 สำคัญมาก ถ้าอยู่ใน modal
                        width: '100%'
                    });
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
                    document.getElementById('loadingOverlay').style.display = 'none';
                    
                    tomProvince = new TomSelect("#select2Basic", {
                                    create: false,
                                    maxItems: 1,
                                    allowEmptyOption: true,
                                    sortField: { field: "text", direction: "asc" }
                                });

                    tomDistrict = new TomSelect("#select2District99", {
                                    create: false,
                                    maxItems: 1,
                                    allowEmptyOption: true,
                                    sortField: { field: "text", direction: "asc" }
                                });

                    tomSubdistrict = new TomSelect("#select2Subdistrict", {
                                    create: false,
                                    maxItems: 1,
                                    allowEmptyOption: true,
                                    sortField: { field: "text", direction: "asc" }
                                });

                    setTimeout(() => {
                        // $('#bs-datepicker-format').datepicker({
                        //     format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่
                        //     autoclose: true,      // ปิด datepicker เมื่อเลือกวันที่
                        //     todayHighlight: true  // ไฮไลต์วันที่ปัจจุบัน
                        // });
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
                    }, 2000);
                    
                }
            });
        }
        
        function roomRentalContract(){
            document.getElementById('loadingOverlay').style.display = 'flex';
            $.ajax({
                type: "GET",
                url: "{{$page_url}}/form-room-rental-contract",
                success: function(data) {
                    $("#formRoomRentalContract").html(data);
                    document.getElementById('loadingOverlay').style.display = 'none';
                    $('#submit_insert_contract').prop('disabled', true);
                    
                    $('#select2Renter').select2({
                        placeholder: 'เลือกข้อมูลจากผู้เช่า',
                        allowClear: true,
                        dropdownParent: $('#roomRentalContract'), // 💥 สำคัญมาก ถ้าอยู่ใน modal
                        width: '100%'
                    });

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
            
            if(id == 'no'){
                $("#room-rental-contract").html('');
                $('#submit_insert_contract').prop('disabled', true);
                return false;
            }

            $.ajax({
                type: "GET",
                url: "{{ $page_url }}/get-room-rental-contract/"+id,
                success: function(data) {
                    $("#room-rental-contract").html(data);
                $('#submit_insert_contract').prop('disabled', false);
                }
            });
        }
        function get_room_rental_move_out(id){
            $.ajax({
                type: "GET",
                url: "{{ $page_url }}/get-room-rental-move-out/"+id,
                success: function(data) {
                    $("#renter_name").val(data.renter.prefix+' '+data.renter.name+' '+data.renter.surname)
                    $("#renter_address").val(data.renter_address)
                    $("#renter_phone").val(data.renter.phone)
                    $("#renter_id_card_number").val(data.renter.id_card_number)
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
            let roomText = $('#room_text').val().trim();

            if (selectChannel == '1' && roomText === '') {
                Swal.fire('! โปรดเลือกห้องเช่า', '', 'warning');
                return false;
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
                            if(response.message == null){
                                
                                var modalEl = document.getElementById('insertRenter');
                                var modalInstance = bootstrap.Modal.getInstance(modalEl); // <-- ดึง instance ที่เปิดอยู่
                                if (modalInstance) {
                                    modalInstance.hide(); // <-- ซ่อน modal ที่เปิดอยู่จริง
                                }
                                // $('#insertRenter').modal('hide');
                                $('#roomRentalReservation').modal('show');
                                get_room_rental_reservation(response);
                                $('#insert_renter')[0].reset();
                                loadData(page);
                                summary();
                                // Swal.fire('เพิ่มการจองเรียบร้อยแล้ว', '', 'success');
                                
                                Swal.fire('เพิ่มการจองเรียบร้อยแล้ว', '', 'success').then((result) => {
                                    // location.reload();
                                });
                            }else{
                                Swal.fire({ html: `<div style="color:red; font-size: 20px;">${response.message}</div>`, icon: 'error'} );
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
                } else if (result.isDismissed) {
                    // Swal.fire('ยกเลิกการดำเนินการ', '', 'info');
                }
            });
        });
        //  เพิ่ม หรือ แก้ไข ผู้เช่า
        $('#form_renterAddRenter').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            var title = 'เพิ่ม';
            if($('#renter_edit').val() != null){
                var title = 'แก้ไข';
            }
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ'+title+' ผู้เช่า หรือไม่?',
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
                        url: '/room/insert-or-update-renter', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response == true){
                                var modalAR = document.getElementById('addRenter');
                                var modalFormRenter = bootstrap.Modal.getInstance(modalAR); // <-- ดึง instance ที่เปิดอยู่
                                if (modalFormRenter) {
                                    modalFormRenter.hide(); // <-- ซ่อน modal ที่เปิดอยู่จริง
                                }
                                // $('#insertRenter').modal('hide');
                                $('#form_renterAddRenter')[0].reset();
                                view(view_id);
                                loadData(page);
                                summary();
                                Swal.fire(title+'ผู้เช่าเรียบร้อยแล้ว', '', 'success');
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
                } else if (result.isDismissed) {
                    // Swal.fire('ยกเลิกการดำเนินการ', '', 'info');
                }
            });
        });
        
        function deleteRenter(room_id, renter_id){
                Swal.fire({
                    title: 'ยืนยันการดำเนินการ?',
                    text: 'คุณต้องการลบผู้เช่าหรือไม่?',
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
                            url: 'renter/'+renter_id+'/'+room_id, // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                            type: 'DELETE',
                            data: {
                                _token : "{{ csrf_token() }}"
                            },
                            success: function(response) {
                                if(response == true){
                                    loadData(page);
                                    view(view_id);
                                    Swal.fire('ลบผู้เช่าเรียบร้อยแล้ว', '', 'success');

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
        }

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
                                // $('#roomRentalContract').modal('hide');
                                $('#insert_contract')[0].reset();
                                loadData(page);
                                summary();
                                Swal.fire('เพิ่มสัญญาเรียบร้อยแล้ว', '', 'success').then((result) => {
                                    location.reload();
                                });
                                summary()

                                // $('#room-rental-contract').html('');
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
                                summary()
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
        $('#asset_upload_image_move_out').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if (!this.checkValidity()) {
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }

            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ อัพโหลดรูปก่อนย้ายออก หรือไม่?',
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
                    let form = document.getElementById('asset_upload_image_move_out');
                    let formData = new FormData(form);
                    formData.append('_token', '{{ csrf_token() }}'); // สำหรับ Laravel CSRF

                    $.ajax({
                        url: '{{$page_url}}/asset/asset-upload-image-move-out',
                        type: 'POST',
                        data: formData,
                        contentType: false, // ต้องมีเพื่อให้ส่ง multipart/form-data ได้
                        processData: false,
                        success: function(response) {
                            if (response.success == true) {
                                var modalEl = document.getElementById('move-out-upload');
                                var modalInstance = bootstrap.Modal.getInstance(modalEl); // <-- ดึง instance ที่เปิดอยู่
                                if (modalInstance) {
                                    modalInstance.hide(); // <-- ซ่อน modal ที่เปิดอยู่จริง
                                }

                                Swal.fire('อัพโหลดรูปก่อนย้ายออก เรียบร้อยแล้ว', '', 'success');
                                loadData(page);
                                summary()
                                var room_has_asset_id = $('#room_has_asset_id').val();
                                $('#id_image_move_out'+room_has_asset_id).html(response.button);
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
                                Swal.fire('ชำระเงิน ค่าจองห้อง เรียบร้อยแล้ว', '', 'success').then((result) => {
                                    location.reload();
                                });
                                loadData(page);
                                summary()
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
                                Swal.fire('ชำระเงิน ค่าจองห้อง เรียบร้อยแล้ว', '', 'success').then((result) => {
                                    location.reload();
                                });
                                loadData(page);
                                summary()
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
        
        // $('#payment_bill').on('submit', function(event) {
        //     event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
        //     if(!this.checkValidity()) {
        //         // ถ้าฟอร์มไม่ถูกต้อง
        //         this.reportValidity();
        //         return console.log('ฟอร์มไม่ถูกต้อง');
        //     }
        //     // return alert(123);
        //     Swal.fire({
        //         title: 'ยืนยันการดำเนินการ?',
        //         text: 'คุณต้องการ บันทึกการเปลี่ยนแปลง หรือไม่?',
        //         icon: 'warning',
        //         showCancelButton: true,
        //         confirmButtonText: 'ตกลง',
        //         cancelButtonText: 'ยกเลิก',
        //         showDenyButton: false,
        //         didOpen: () => {
        //             // โฟกัสที่ปุ่ม confirm
        //             Swal.getConfirmButton().focus();
        //         }
        //     }).then((result) => {
        //         if (result.isConfirmed) {

        //             var formData = new FormData($('#payment_bill')[0]);

        //             $.ajax({
        //                 url: 'bill/payment_bill', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
        //                 type: 'POST',
        //                 data: formData,
        //                 processData: false,
        //                 contentType: false,
        //                 success: function(response) {
        //                     if(response == true){
        //                         // $('#invoice').modal('hide');
        //                         // summary();
        //                         loadData(page);
        //                         Swal.fire('บันทึกเรียบร้อยแล้ว', '', 'success');
        //                     }
        //                 },
        //                 error: function(error) {
        //                     Swal.fire('เกิดข้อผิดพลาด', '', 'error');
        //                     console.error('เกิดข้อผิดพลาด:', error);
        //                 }
        //             });
        //         } else if (result.isDismissed) {
        //             // Swal.fire('ยกเลิกการดำเนินการ', '', 'info');
        //         }
        //     });
        // });

        $(document).ready(function() {
            $('#select2Basic').on('change', function () {
                const provinceId = $(this).val();

                // ล้างอำเภอ
                tsDistrict.clear();         // ล้างค่าที่เลือก
                tsDistrict.clearOptions();  // ลบ options ทั้งหมด
                tsDistrict.addOption({value: "", text: "เลือกอำเภอ"}); // เพิ่ม default

                if (provinceId) {
                    $.ajax({
                        url: '/get-districts/' + provinceId,
                        type: 'GET',
                        success: function (data) {
                            let newOptions = data.map(d => ({ value: d.id, text: d.name_in_thai }));
                            tsDistrict.addOptions(newOptions);
                            tsDistrict.refreshOptions(false);
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
