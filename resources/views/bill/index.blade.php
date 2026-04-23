@php
    $permission_bill_confirm_payment = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 23)->where('status', 0)->first();
@endphp

<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template">

<head>
    @include('layout/inc_header')
    <title>Dashboard - CRM | Vuexy - Bootstrap Admin Template</title>
</head>
<style>
    .new_box .col-md-6 {
        padding: 5px 12px;
    }
    .table th {
        font-size: 15px;
        font-weight: bold;
    }
    /* .table td {
        padding-top: 14px;
        padding-bottom: 14px;
    } */
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

<link rel="stylesheet" href="assets/vendor/libs/select2/select2.css" />
<link rel="stylesheet" href="assets/vendor/libs/bootstrap-select/bootstrap-select.css" />

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
                                                    <i class="tf-icons ti ti-sitemap text-main ti-xl" style="margin-right: 10px;"></i>
                                                    เลือกรอบบิล
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-header row pt-0 g-3">
                                        <div class="col-sm-5 col-lg-5 text-warning">
                                            <div class="card card-border-shadow-warning">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center pb-1">
                                                        <h4 class="ms-1 mb-0 text-warning" id="confirm_by_employee">
                                                        </h4>
                                                    </div>
                                                    <h5 class="mb-0 d-flex">รอคอนเฟิร์ม
                                                        <button type="button"
                                                            class="btn btn-main btn-sm rounded-2 ms-auto d-write change_status_all_check"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editserviceModal"
                                                            onclick="waitingForConfirmation()">
                                                            รายละเอียด
                                                        </button>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-5 col-lg-5">
                                            <div class="card card-border-shadow-success">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center pb-1">
                                                        <h4 class="ms-1 mb-0 text-success" id="confirm_by_ceo">
                                                        </h4>
                                                    </div>
                                                    <h5 class="mb-0 d-flex">ยอดในบัญชี
                                                        {{-- <button type="button"
                                                            class="btn btn-warning btn-sm rounded-2 mx-5 d-write"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#model-clear-balance"
                                                            onclick="getFormClearBalance()">
                                                            <i class="ti ti-refresh me-1"></i>
                                                            เคลียร์ยอด
                                                        </button> --}}
                                                        <button type="button"
                                                            class="btn btn-main btn-sm rounded-2 ms-auto d-write"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#model-confirmation"
                                                            onclick="confirmation()">
                                                            รายละเอียด
                                                        </button>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-5 col-lg-5">
                                            <div class="card card-border-shadow-success">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center pb-1">
                                                        <h4 class="ms-1 mb-0 text-success" id="transfer_wait_for_confirm">
                                                            {{-- 0.00 บาท --}}
                                                        </h4>
                                                    </div>
                                                    <h5 class="mb-0">โอนเงิน</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-5 col-lg-5 text-warning">
                                            <div class="card card-border-shadow-warning">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center pb-1">
                                                        <h4 class="ms-1 mb-0 text-warning" id="cash_wait_for_confirm" >
                                                            {{-- 0.00 บาท --}}
                                                        </h4>
                                                    </div>
                                                    <h5 class="mb-0">เงินสด</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row border-bottom border-light p-3">
                                        <div class="row">
                                                <div class="col-md-3" style="padding-right: unset !important;">
                                                    <select onchange='loadData("{{$page_url}}/datatable")' name="ref_status_id" id="selectpickerStatus" class="select2 form-select form-select-lg p_search" data-style="btn-default">
                                                        <option value="all">สถานะบิล</option>
                                                        @foreach ($status_rent_bill as $sta_tus)
                                                            <option value="{{ $sta_tus->id }}">{{ $sta_tus->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3" style="padding-right: unset !important;">
                                                    <div class="input-group input-group-merge">
                                                        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                                                        <input
                                                            name="room_name"
                                                            type="text"
                                                            class="form-control p_search"
                                                            placeholder="ค้นหาตามหมายเลขห้อง"
                                                            aria-label="ค้นหาตามหมายเลขห้อง"
                                                            oninput="loadData('{{$page_url}}/datatable')"
                                                            aria-describedby="basic-addon-search31" />
                                                    </div>
                                                </div>
                                                <!-- Group -->
                                                <div class="col-md-3" style="padding-right: unset !important;">
                                                    <div class="input-group input-group-merge">
                                                        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                                                        <input
                                                            name="invoice_number"
                                                            type="text"
                                                            class="form-control p_search"
                                                            placeholder="ค้นหาตามใบแจ้งหนี้/ใบเสร็จรับเงิน"
                                                            aria-label="ค้นหาตามใบแจ้งหนี้/ใบเสร็จรับเงิน"
                                                            oninput="loadData('{{$page_url}}/datatable')"
                                                            aria-describedby="basic-addon-search31" />
                                                      </div>
                                                </div>
                                                <div class="col-md-3" style="padding-right: unset !important;">
                                                    <div class="input-group input-group-merge">
                                                        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                                                        <input
                                                            name="room_rent"
                                                            type="text"
                                                            class="form-control p_search"
                                                            placeholder="ค้นหาตามยอดเงินรวม"
                                                            aria-label="ค้นหาตามยอดเงินรวม"
                                                            oninput="loadData('{{$page_url}}/datatable')"
                                                            aria-describedby="basic-addon-search31" />
                                                      </div>
                                                </div>
                                    </div>
                                    <div class="row border-top mt-3 border-light p-3">
                                            <div class="col-md-2" style="padding-right: unset !important;">
                                            <select onchange='loadData("{{$page_url}}/datatable")' name="building" id="selectpickerBuilding" class="select2 form-select form-select-lg p_search" data-style="btn-default">
                                                    <option value="all">ทุกตึก</option>
                                                    @foreach ($buildings as $b)
                                                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                                                    @endforeach
                                            </select>
                                            </div>
                                            <!-- Group -->
                                            <div class="col-md-2" style="padding-right: unset !important;">
                                            <select onchange='loadData("{{$page_url}}/datatable")' name="floor" id="selectpickerFloor" class="select2 form-select form-select-lg p_search" data-style="btn-default">
                                                    <option value="all">ทุกชั้น</option>
                                                    @foreach ($floors as $f)
                                                        <option value="{{ $f->id }}">{{ $f->name }}</option>
                                                    @endforeach
                                            </select>
                                            </div>
                                            <div class="col-md-8 text-end" style="padding-right: unset !important;">
                                                @if(Auth::user()->user_has_branch->position->id == 1)
                                                    <button
                                                            class="btn btn-sm btn-success buttons-collection waves-effect waves-light d-write change_status_all_check me-2"
                                                            tabindex="0" aria-controls="DataTables_Table_0"
                                                            type="button" aria-haspopup="dialog"
                                                            aria-expanded="false" data-bs-toggle="modal" data-bs-target="#123"
                                                            onclick="changeStatusByInvoiceCheck()"
                                                            >
                                                        <span><i class="ti ti-check"></i> ชำระเงิน</span>
                                                    </button>
                                                    <button @if($permission_bill_confirm_payment) style="display: none !important;" @endif
                                                            class="btn btn-sm btn-info buttons-collection waves-effect waves-light d-write me-2"
                                                            tabindex="0" aria-controls="DataTables_Table_0"
                                                            type="button" aria-haspopup="dialog"
                                                            aria-expanded="false"
                                                            onclick="confirmBillAll()"
                                                            >
                                                        <span><i class="ti ti-send"></i> คอนเฟิร์มบิลทั้งหมด</span>
                                                    </button>
                                                @endif
                                                <button 
                                                        style="padding-right: 14px;padding-left: 14px;"
                                                        class="btn btn-sm btn-success buttons-collection btn-warning waves-effect waves-light me-2 d-write"
                                                        tabindex="0" aria-controls="DataTables_Table_0"
                                                        type="button" aria-haspopup="dialog"
                                                        aria-expanded="false"
                                                        onclick="printExcel()">
                                                    <span>
                                                    <i class="ti ti-upload"></i> ดาวน์โหลด Excel</span>
                                                </button>
                                                <button
                                                        style="padding-right: 14px;padding-left: 14px;"
                                                        class="btn btn-sm btn-label-primary buttons-collection waves-effect waves-light me-2 d-write"
                                                        tabindex="0" aria-controls="DataTables_Table_0"
                                                        type="button" aria-haspopup="dialog"
                                                        aria-expanded="false"
                                                        onclick="window.open('{{$page_url}}/export/excel-summary', '_blank')"
                                                        {{-- onclick="printPdfBill()" --}}
                                                        >
                                                    <span>
                                                    <i class="ti ti-file-upload"></i> พิมพ์ใบสรุปบิล</span>
                                                </button>
                                                <button
                                                        style="padding-right: 14px;padding-left: 14px;"
                                                        class="btn btn-sm btn-label-danger buttons-collection waves-effect waves-light me-2 d-write"
                                                        tabindex="0" aria-controls="DataTables_Table_0"
                                                        type="button" aria-haspopup="dialog"
                                                        aria-expanded="false"
                                                        onclick="printPdfMany('all')"
                                                        >
                                                    <span>
                                                    <i class="ti ti-file-upload"></i> พิมพ์หลายห้อง</span>
                                                </button>
                                            </div>
                                </div>
                                <div class="row mt-4">
                                        <div class="col-lg-4">
                                            <div class="d-flex align-items-center mb-2 mb-md-0">
                                                <label class="">Show</label>
                                                <select onchange='loadData("{{$page_url}}/datatable")' name="limit" class="form-select ms-2 me-2 p_search" style="width:100px">
                                                    <option value="25">25</option>
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
                                            </div>
                                        </div>
                                        <div class="col-md-2 mt-1" style="padding-right: unset !important;">
                                            <h4 id="thai-month-label">{{-- แสดงเดือนที่เลือก--}}</h4>
                                        </div>
                                        <div class="col-md-2" style="padding-right: unset !important;">
                                            <input onchange='loadData("{{$page_url}}/datatable")' name="month" type="month" class="form-control p_search" id="exampleFormControlInput1" placeholder="" value="{{ session('month') ?? date('Y-m') }}" />
                                        </div>
                                        <div class="col-md-4 text-end" style="padding-right: unset !important;">
                                            <button
                                                    class="btn btn-sm btn-primary buttons-collection waves-effect waves-light d-write me-2"
                                                    tabindex="0" aria-controls="DataTables_Table_0"
                                                    type="button" aria-haspopup="dialog"
                                                    aria-expanded="false" data-bs-toggle="modal" data-bs-target="#modal-payment-bill-all"
                                                    {{-- onclick="checkCheckInvoice()" --}}
                                                    >
                                                <span><i class="ti ti-cash"></i> ชำระเงินหลายห้อง</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="card-body px-0 pt-0">
                                    <div class="tab-content p-0" id="pills-tabContent">
                                        
                                        {{-- table อยู่ตรงนี้ครับ --}}

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
    <div class="modal fade modalHeadDecor" id="invoice" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0" id="viewInvoice">
                
            </div>
        </div>
    </div>
    {{-- <div class="modal fade modalHeadDecor" id="model-clear-balance" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">เคลียร์ยอด</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="get-form-clear-balance">
                    
                </div>
            </div>
        </div>
    </div> --}}
    <div class="modal fade modalHeadDecor" id="model-confirmation" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">ยอดในบัญชี</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="confirmation">
                    
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modalHeadDecor" id="editserviceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">รอคอนเฟิร์ม</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detail">
                    
                </div>
                @if(Auth::user()->user_has_branch->position->id == 1)
                    <div class="modal-footer rounded-0 justify-content-center" @if($permission_bill_confirm_payment) style="display: none;" @endif>
                        <button class="btn btn-success buttons-collection waves-effect waves-light change_status_all_check"
                                type="button"
                                onclick="changeStatusAllCheck()"
                                disabled
                                >
                            <span><i class="ti ti-check"></i> ชำระเงิน</span>
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="modal fade modalHeadDecor" id="modal-payment-bill-all" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">ชำระค่าเช่าหลายห้อง</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="payment_bill_form_all" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                                <div class="p-2">
                                    <label class="h5 mb-1">เลือกข้อมูลจากผู้เช่า</label>
                                    <select name="ref_renter_id" id="select2Renter2" onchange="checkCheckInvoice(this.value)" required>
                                        <option selected hidden value="no">เลือกข้อมูลจากผู้เช่า</option>
                                        @foreach ($renter as $rent)
                                            <option {{$rent->contracts_id}} value="{{ $rent->id }}">{{ $rent->prefix.' '.$rent->name.' '.$rent->surname }}</option>
                                        @endforeach
                                    </select>
                                        
                                </div>
                        <div class="p-2"><label class="h5 mb-1 d-block">เลือกรายการจากใบแจ้งหนี้</label>
                            <div class="d-flex flex-wrap gap-4">


                                <div class="form-check form-check-inline">
                                    <input class="form-check-input bill-list-checkbox" type="checkbox"
                                        value="payment_list_not_paid"
                                        id="payment_list_not_paid1"
                                        checked
                                        >
                                    <label class="form-check-label" for="payment_list_not_paid1">
                                        เต็มจำนวน
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input bill-list-checkbox list-check-box" type="checkbox"
                                        value="payment_rent_room_array"
                                        id="payment_rent_room_array1"
                                        >
                                    <label class="form-check-label" for="payment_rent_room_array1">
                                        ค่าเช่าห้อง
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input bill-list-checkbox list-check-box" type="checkbox"
                                        value="payment_meter_array"
                                        id="payment_meter_array1"
                                        >
                                    <label class="form-check-label" for="payment_meter_array1">
                                        ค่าน้ำ-ค่าไฟฟ้า
                                    </label>
                                </div>

                                <div class="form-check form-check-inline">
                                    <input class="form-check-input bill-list-checkbox list-check-box" type="checkbox"
                                        value="payment_parking_fee_array"
                                        id="payment_parking_fee_array1"
                                        >
                                    <label class="form-check-label" for="payment_parking_fee_array1">
                                        ค่าที่จอดรถ
                                    </label>
                                </div>
                                
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input bill-list-checkbox list-check-box" type="checkbox"
                                        value="payment_other_array"
                                        id="payment_other_array1"
                                        >
                                    <label class="form-check-label" for="payment_other_array1">
                                        อื่น ๆ
                                    </label>
                                </div>

                            </div>
                        </div>
                        <div id="div-form-payment-rent-bill-all" class="p-2">
                            <div colspan="20" class="text-center text-muted py-4">
                                <i class="ti ti-file-search" style="font-size: 24px;"></i><br>
                                โปรดเลือกรายการ.!
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer rounded-0 justify-content-center">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" id="submit_payment_bill_form_all" class="btn btn-main" disabled>บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <iframe id="print-iframe" style="display: none;"></iframe>    
    <!-- / Layout wrapper -->
    @include('layout/inc_js')
    <script>

            setInterval(() => {
                loadData(page);
            }, 60000);

            new TomSelect("#select2Renter2", {
                            create: false,
                            maxItems: 1,
                            allowEmptyOption: true,
                            sortField: { field: "text", direction: "asc" }
                        });
        // เมื่อเลือก "เต็มจำนวน"
            document.getElementById("payment_list_not_paid1").addEventListener("change", function () {
                if (this.checked) {
                    // ยกเลิกการเลือกอย่างอื่นทั้งหมด
                    document.querySelectorAll(".list-check-box").forEach(ch => ch.checked = false);
                }
                payMultipleRentBills();
            });

            // เมื่อเลือก option อื่น ๆ
            document.querySelectorAll(".list-check-box").forEach(ch => {
                ch.addEventListener("change", function () {
                    if (this.checked) {
                        document.getElementById("payment_list_not_paid1").checked = false; // ยกเลิก "เต็มจำนวน"
                    }
                    payMultipleRentBills();
                });
            });
        // new TomSelect(".select-room-payment-bill", {
        //     create: false,
        //     maxItems: 1,
        //     allowEmptyOption: true,
        //     sortField: { field: "text", direction: "desc" }
        // });
        let invoice_ids = [];
        function checkCheckInvoice(id) // modal ชำระเงินหลายห้อง
        {                               // ดึงห้องที่ ติ๊ก มาแสดง
            // let invoice_ids = [];
            // $('.ids_invoice:checked').each(function() {
            //     invoice_ids.push($(this).val());
            // });

            // if (invoice_ids.length === 0) {
            //     Swal.fire('กรุณาเลือกอย่างน้อย 1 รายการ', '', 'warning');
            //     return;
            // }
            
            if(id == 'no'){
                $("#room-move-out").html('');
                $('#submit_payment_bill_form_all').prop('disabled', true);
                return false;
            }
            $.ajax({
                type: "GET",
                url: "{{ $page_url }}/get-room-rent-bill/"+id,
                success: function(data) {
                    invoice_ids = data;
                    payMultipleRentBills('payment_list_not_paid')

                }
            });
            // alert(123)
            // var myModal = new bootstrap.Modal(document.getElementById('modal-payment-bill-all'));
            //     myModal.show();

        }
        let delete_list_id = [];
        function payMultipleRentBills() // modal ชำระเงินหลายห้อง
        {                               // ดึงห้องที่ ติ๊ก มาแสดง
            // let invoice_ids = [];
            // $('.ids_invoice:checked').each(function() {
            //     invoice_ids.push($(this).val());
            // });

            let list = [];
            $('.bill-list-checkbox:checked').each(function() {
                list.push($(this).val());
            });

            $.ajax({
                type: "GET",
                url: "{{$page_url}}/get-room-for-payment",
                data: {
                    invoice_ids: invoice_ids,
                    list: list,
                    delete_list_id: delete_list_id
                },
                success: function(data) {
                    // $("#div-form-payment-rent-bill-all").html(data.html);
                    $("#div-form-payment-rent-bill-all").html(data);
                    // if(data.have == 1){
                    //     $('#submit_payment_bill_form_all').prop('disabled', false);
                    // }else{
                    //     $('#submit_payment_bill_form_all').prop('disabled', true);
                    // }
                }
            });
        }
        function deleteBillRoom(id){
            if ($('.billReserveRoom').length > 1) {
                delete_list_id.push(id);
                $("#billReserveRoom"+id).remove();
                document.getElementById("check-table-"+id).checked = false; // ยกเลิก "เต็มจำนวน"
                payMultipleRentBills();
            } else {
                Swal.fire('ไม่สามารถลบได้', 'การชำระค่าจองต้องมีอย่างน้อย 1 ห้อง', 'warning');
            }
        }
        function printPdf(id) {
            $.ajax({
                url: '/pdf/invoice/'+id,
                type: 'GET',
                success: function(html) {
                    const iframe = document.getElementById('print-iframe');
                    const doc = iframe.contentWindow.document;
                    doc.open();
                    doc.write(html);
                    doc.close();

                    // รอโหลดก่อนค่อยพิมพ์
                    iframe.onload = function () {
                        iframe.contentWindow.focus();
                        iframe.contentWindow.print();
                    };
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
        function printPdfReceipt(id) {
            $.ajax({
                url: '/pdf/receipt/'+id,
                type: 'GET',
                success: function(html) {
                    const iframe = document.getElementById('print-iframe');
                    const doc = iframe.contentWindow.document;
                    doc.open();
                    doc.write(html);
                    doc.close();

                    // รอโหลดก่อนค่อยพิมพ์
                    iframe.onload = function () {
                        iframe.contentWindow.focus();
                        iframe.contentWindow.print();
                    };
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
        function printPdfMany(id) {
            let url = '/pdf/invoice/'+id;

            if(id == "all"){
                let ids = $('.ids_invoice:checked').map((i, el) => el.value).get();
                if (ids.length === 0){
                    return Swal.fire('โปรดเลือกรายการใบแจ้งหนี้', '', 'warning');
                }
                url = '/pdf/invoice_all/'+ids;
            }

            $.ajax({
                url: url,
                type: 'GET',
                success: function(html) {
                    const iframe = document.getElementById('print-iframe');
                    const doc = iframe.contentWindow.document;
                    doc.open();
                    doc.write(html);
                    doc.close();

                    // รอโหลดก่อนค่อยพิมพ์
                    iframe.onload = function () {
                        iframe.contentWindow.focus();
                        iframe.contentWindow.print();
                    };
                },
                error: function(xhr) {
                    alert('เกิดข้อผิดพลาด');
                    console.error(xhr.responseText);
                }
            });
        }
        function printPdfBill() {
            $.ajax({
                url: '/pdf/invoice-bill-all/1',
                type: 'GET',
                success: function(html) {
                    const iframe = document.getElementById('print-iframe');
                    const doc = iframe.contentWindow.document;
                    doc.open();
                    doc.write(html);
                    doc.close();

                    // รอโหลดก่อนค่อยพิมพ์
                    iframe.onload = function () {
                        iframe.contentWindow.focus();
                        iframe.contentWindow.print();
                    };
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
        function printExcel(){

            searchData = {}; // reset ก่อน

            $('.p_search').each(function() {
                var inputName = $(this).attr('name');
                var inputValue = $(this).val();
                
                searchData[inputName] = inputValue;
            });

            var query = $.param(searchData);

            window.open('{{$page_url}}/export/excel?' + query, '_blank');
        }
        $(document).ready(function() {
            $('input[type="radio"]').click(function() {
                var inputValue = $(this).attr("value");
                var targetBox = $("." + inputValue);
                $(".box").not(targetBox).hide();
                $(targetBox).show();
            });
        });
        
        function view(id,de){

            loadData(page);
        
            if(de == 'table'){
                status_detail_waiting_confirm = 0;
            }else{
                status_detail_waiting_confirm = 1;
            }
            $.ajax({
                type: "GET",
                url: "{{ $page_url }}/"+id,
                success: function(data) {
                    $("#viewInvoice").html(data);
                }
            });
        }
        summary();
        function summary(){
            $.ajax({
                type: "GET",
                url: "{{ $page_url }}/summary",
                success: function(data) {
                    $('#confirm_by_employee').html(data.confirm_by_employee);
                    $('.detail_confirm_by_employee').html(data.confirm_by_employee);
                    $('#confirm_by_ceo').html(data.confirm_by_ceo);
                    $('.confirm_by_ceo').html(data.confirm_by_ceo);
                    $('.confirm_by_employee_confirm_by_ceo').html(data.confirm_by_employee_confirm_by_ceo);
                    $('#transfer_wait_for_confirm').html(data.transfer_wait_for_confirm+' บาท');
                    $('#cash_wait_for_confirm').html(data.cash_wait_for_confirm+' บาท');

                    if(data.confirm_by_employee != "0 บาท"){
                        $('.change_status_all_check').prop("disabled", false)
                    }else{
                        $('.change_status_all_check').prop("disabled", true)
                    }
                    
                }
            });
        }
        // function incomplete(id){
        //     $.ajax({
        //         type: "GET",
        //         url: "{{ $page_url }}/incomplete/"+id,
        //         success: function(data) {
        //             $("#incompleteInvoice").html(data);
        //         }
        //     });
        // }
        function changeStatusBill(id, status, title){
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ '+title+' หรือไม่?',
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
                        type: "POST",
                        url: "{{ $page_url }}/change_status_bill/"+id,
                        data: {
                            _token: "{{ csrf_token() }}",
                            status: status
                        },
                        success: function(response) {
                            if(response == true){
                                $('#invoice').modal('hide');
                                loadData(page);
                                Swal.fire({
                                    title: title+' เรียบร้อยแล้ว',
                                    icon: 'success',
                                    timer: 1500, // ตั้งเวลาเป็น 1500 มิลลิวินาที (1.5 วินาที)
                                    timerProgressBar: true, 
                                    showConfirmButton: false,
                                    customClass: {
                                        title: 'custom-title', // กำหนดคลาสให้กับ title
                                    },
                                });
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
        }
        function changeDeleteReceipt(receipt_id, invoice_id){
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ ยกเลิก ใบเสร็จ หรือไม่?',
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
                        type: "POST",
                        url: "{{ $page_url }}/delete-receipt/"+receipt_id,
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if(response == true){
                                loadData(page);
                                Swal.fire({
                                    title: 'ยกเลิก ใบเสร็จ เรียบร้อยแล้ว',
                                    icon: 'success',
                                    timer: 1500, // ตั้งเวลาเป็น 1500 มิลลิวินาที (1.5 วินาที)
                                    timerProgressBar: true, 
                                    showConfirmButton: false,
                                    customClass: {
                                        title: 'custom-title', // กำหนดคลาสให้กับ title
                                    },
                                });
                                view(invoice_id,'table');
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
        }

        var page = "{{$page_url}}/datatable";
        var searchData = {};
        loadData(page);
        
        var ch = "pills-profile";
        function ch_div(id_ch){
            ch = id_ch;
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
                    summary();
                    let selectedMonth = $('#exampleFormControlInput1').val(); // เช่น "2024-05"
                    let thaiMonthText = formatThaiMonth(selectedMonth);        // ได้ "พฤษภาคม 2024"
                    // console.log(thaiMonthText);
                     $('#thai-month-label').html(thaiMonthText);

                    // $("#table-data").html(data);
                }
            });
            // alert(page);
        }
        function formatThaiMonth(monthStr) {
            const months = [
                'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
                'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
            ];

            const parts = monthStr.split('-'); // ["2024", "05"]
            const year = parts[0];
            const monthIndex = parseInt(parts[1], 10) - 1;

            return `${months[monthIndex]} ${year}`;
        }


        var status_detail_waiting_confirm = 0;
        $('#invoice').on('hidden.bs.modal', function () {
            if(status_detail_waiting_confirm == 1){
                $('#editserviceModal').modal('show');
            };
        });
        function waitingForConfirmation() // Modal รอคอนเฟิร์ม
        {
            $.ajax({
                type: "GET",
                url: "{{$page_url}}/waiting-for-confirmation",
                // data: searchData,
                success: function(data) {
                    $("#detail").html(data);
                    summary();
                }
            });
            // alert(page);
        }
        function getFormClearBalance(){ // Modal รอคอนเฟิร์ม
            $.ajax({
                type: "GET",
                url: "{{$page_url}}/get-form-clear-balance",
                // data: searchData,
                success: function(data) {
                    $("#get-form-clear-balance").html(data);
                }
            });
            // alert(page);
        }
        function confirmation(){ // Modal รอคอนเฟิร์ม
            $.ajax({
                type: "GET",
                url: "{{$page_url}}/confirmation",
                // data: searchData,
                success: function(data) {
                    $("#confirmation").html(data);
                }
            });
            // alert(page);
        }
        $('#payment_bill_form_all').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ

            if (!this.checkValidity()) {
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }

            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ ชำระเงิน ค่าเช่าห้อง หรือไม่?',
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
                    let form = document.getElementById('payment_bill_form_all');
                    let formData = new FormData(form);
                    formData.append('_token', '{{ csrf_token() }}'); // สำหรับ Laravel CSRF

                    $.ajax({
                        url: 'room/receipt/all',
                        type: 'POST',
                        data: formData,
                        contentType: false, // ต้องมีเพื่อให้ส่ง multipart/form-data ได้
                        processData: false,
                        success: function(response) {
                            if (response == true) {
                                var modalEl = document.getElementById('modal-payment-bill-all');
                                var modalInstance = bootstrap.Modal.getInstance(modalEl); // <-- ดึง instance ที่เปิดอยู่
                                if (modalInstance) {
                                    modalInstance.hide(); // <-- ซ่อน modal ที่เปิดอยู่จริง
                                }
                                // Swal.fire('ชำระเงิน ค่าเช่าห้อง เรียบร้อยแล้ว', '', 'success').then((result) => {
                                //     location.reload();
                                // });
                                Swal.fire({
                                    title: 'ชำระเงิน ค่าเช่าห้อง เรียบร้อยแล้ว',
                                    icon: 'success',
                                    timer: 1500, // ตั้งเวลาเป็น 1500 มิลลิวินาที (1.5 วินาที)
                                    timerProgressBar: true, 
                                    showConfirmButton: false,
                                    customClass: {
                                        title: 'custom-title', // กำหนดคลาสให้กับ title
                                    },
                                });
                                location.reload();
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
        
        function changeStatusAllCheck(){
            let ids = [];
            $('.ids_receipt:checked').each(function() {
                ids.push($(this).val());
            });

            // ✅ ตรวจสอบก่อนส่ง
            if (ids.length === 0) {
                Swal.fire('กรุณาเลือกอย่างน้อย 1 รายการ', '', 'warning');
                return;
            }

            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ ชำระเงินทั้งหมด หรือไม่?',
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
                        type: "POST",
                        url: "{{ $page_url }}/change_status_bill_receipt",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: ids,
                            status: 5
                        },
                        success: function(response) {
                            if(response == true){
                                $('#invoice').modal('hide');
                                loadData(page);
                                waitingForConfirmation();
                                Swal.fire({
                                    title: 'ชำระเงินทั้งหมด เรียบร้อยแล้ว',
                                    icon: 'success',
                                    timer: 1500, // ตั้งเวลาเป็น 1500 มิลลิวินาที (1.5 วินาที)
                                    timerProgressBar: true, 
                                    showConfirmButton: false,
                                    customClass: {
                                        title: 'custom-title', // กำหนดคลาสให้กับ title
                                    },
                                });
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
            // var selectedValues = $('input.confirm-bill:checked').map(function() {
            //     return this.value;
            // }).get();

            // // แสดงผลลัพธ์
            // if (selectedValues.length === 0) {
            //     return 1;
            // } else {
            //     changeStatusBill(selectedValues, 2, "คอนเฟิร์มบิล");
            // }
        }
        function confirmBillAll(){
            let ids = [];
            $('.ids_invoice:checked').each(function() {
                ids.push($(this).val());
            });

            // // ✅ ตรวจสอบก่อนส่ง
            // if (ids.length === 0) {
            //     Swal.fire('กรุณาเลือกอย่างน้อย 1 รายการ', '', 'warning');
            //     return;
            // }

            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ คอนเฟิร์มบิล ทั้งหมด หรือไม่?',
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
                        type: "POST",
                        url: "{{ $page_url }}/confirm-bill-all",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: ids,
                            // building: $('#selectpickerBuilding').val(),
                            // floor: $('#selectpickerFloor').val(),
                            status: 7
                        },
                        success: function(response) {
                            if(response == true){
                                loadData(page);
                                Swal.fire({
                                    title: 'คอนเฟิร์มบิล ทั้งหมด เรียบร้อยแล้ว',
                                    icon: 'success',
                                    timer: 1500, // ตั้งเวลาเป็น 1500 มิลลิวินาที (1.5 วินาที)
                                    timerProgressBar: true, 
                                    showConfirmButton: false,
                                    customClass: {
                                        title: 'custom-title', // กำหนดคลาสให้กับ title
                                    },
                                });
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
            // var selectedValues = $('input.confirm-bill:checked').map(function() {
            //     return this.value;
            // }).get();

            // // แสดงผลลัพธ์
            // if (selectedValues.length === 0) {
            //     return 1;
            // } else {
            //     changeStatusBill(selectedValues, 2, "คอนเฟิร์มบิล");
            // }
        }
        function changeStatusByInvoiceCheck(){
            let ids = [];
            $('.ids_invoice:checked').each(function() {
                ids.push($(this).val());
            });

            // ✅ ตรวจสอบก่อนส่ง
            if (ids.length === 0) {
                Swal.fire('กรุณาเลือกอย่างน้อย 1 รายการ', '', 'warning');
                return;
            }

            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ ชำระเงินทั้งหมด หรือไม่?',
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
                        type: "POST",
                        url: "{{ $page_url }}/change_status_bill_invoice",
                        data: {
                            _token: "{{ csrf_token() }}",
                            id: ids,
                            status: 5
                        },
                        success: function(response) {
                            if(response == true){
                                $('#invoice').modal('hide');
                                loadData(page);
                                waitingForConfirmation();
                                Swal.fire({
                                    title: 'ชำระเงินทั้งหมด เรียบร้อยแล้ว',
                                    icon: 'success',
                                    timer: 1500, // ตั้งเวลาเป็น 1500 มิลลิวินาที (1.5 วินาที)
                                    timerProgressBar: true, 
                                    showConfirmButton: false,
                                    customClass: {
                                        title: 'custom-title', // กำหนดคลาสให้กับ title
                                    },
                                });
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
            // var selectedValues = $('input.confirm-bill:checked').map(function() {
            //     return this.value;
            // }).get();

            // // แสดงผลลัพธ์
            // if (selectedValues.length === 0) {
            //     return 1;
            // } else {
            //     changeStatusBill(selectedValues, 2, "คอนเฟิร์มบิล");
            // }
        }
        
    </script>
    <script src="assets/vendor/libs/select2/select2.js"></script>
    <script src="assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="assets/js/forms-selects.js"></script>

</body>

</html>