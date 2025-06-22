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
                                                    <i class="tf-icons ti ti-users text-main ti-md"></i>
                                                    ข้อมูลผู้เช่า
                                                </h4>
                                            </div>
                                            <div class="col-sm-12">
                                                <ul class="nav nav-pills nav-fill " role="tablist">
                                                    <li class="nav-item me-4">
                                                        <button type="button" class="nav-link active" role="tab"
                                                        style="background-color: #d6f4f7;color: black;"
                                                            data-bs-toggle="tab" data-bs-target="#navs-pills-top-home"
                                                            aria-controls="navs-pills-top-home"
                                                            aria-selected="true">ข้อมูลผู้เช่าปัจจุบัน</button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button type="button" class="nav-link" role="tab"
                                                        style="background-color: #ffe2e3;color: black;"
                                                            data-bs-toggle="tab"
                                                            data-bs-target="#navs-pills-top-profile"
                                                            aria-controls="navs-pills-top-profile"
                                                            aria-selected="false">ข้อมูลผู้เช่าเก่า</button>
                                                    </li>
                                                </ul>
                                                <div class="row mt-4">
                                                    <div class="col-md-6">
                                                        <select id="selectpickerBasic" class="form-select me-2" data-style="btn-default">
                                                                <option value="">ค้นหาตาม</option>
                                                                <option value="1">1</option>
                                                                <option value="2">2</option>
                                                                <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                                                            <input
                                                            type="text"
                                                            class="form-control"
                                                            placeholder="ค้นหาคีย์เวิร์ดที่ต้องการ"
                                                            aria-label="ค้นหาคีย์เวิร์ดที่ต้องการ"
                                                            aria-describedby="basic-addon-search31" />
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content p-0">
                                            <div class="tab-pane fade show active" id="navs-pills-top-home"
                                                role="tabpanel">
                                                
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
                                                <ul class="nav nav-pills" id="pills-tablayout" role="tablist">
                                                    <li class="nav-item me-1" role="presentation">
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-secondary waves-effect"
                                                            id="pills-home-tab" data-bs-toggle="pill"
                                                            data-bs-target="#pills-home" type="button" role="tab"
                                                            aria-controls="pills-home" aria-selected="true">
                                                            <span class="ti ti-layout-grid ti-md"></span>
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-secondary waves-effect active"
                                                            data-bs-toggle="pill" data-bs-target="#pills-profile"
                                                            type="button" role="tab" aria-controls="pills-profile"
                                                            aria-selected="false">
                                                            <span class="ti ti-list ti-md"></span>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                            <div class="col-md-8 flex text-end" style="padding-right: unset !important;">
                                                <button
                                                        style="padding-right: 14px;padding-left: 14px;"
                                                        class="btn btn-success buttons-collection btn-primary waves-effect waves-light me-2"
                                                        tabindex="0" aria-controls="DataTables_Table_0"
                                                        type="button" aria-haspopup="dialog"
                                                        aria-expanded="false">
                                                        <span>
                                                            <i class="ti ti-file-upload"></i> 
                                                            พิมพ์เอกสารเช็ครถ
                                                        </span>
                                                </button>
                                                <button
                                                        style="padding-right: 14px;padding-left: 14px;"
                                                        class="btn btn-success buttons-collection btn-warning waves-effect waves-light me-2"
                                                        tabindex="0" aria-controls="DataTables_Table_0"
                                                        type="button" aria-haspopup="dialog"
                                                        aria-expanded="false">
                                                        <span>
                                                            <i class="ti ti-upload"></i> 
                                                            ดาวน์โหลด Excel
                                                        </span>
                                                </button>
                                                {{-- <button
                                                            style="padding-right: 14px;padding-left: 14px;margin-right: 0px;"
                                                            class="btn btn-success buttons-collection  btn-info waves-effect waves-light"
                                                            tabindex="0" aria-controls="DataTables_Table_0"
                                                            type="button" aria-haspopup="dialog"
                                                            aria-expanded="false" data-bs-toggle="modal" data-bs-target="#addModal">
                                                        <span><i class="ti ti-plus"></i> เพิ่มผู้เช่าห้อง</span>
                                                    </button> --}}
                                            </div>
                                        
                                    </div>
                                    <div class="card-body px-0 pt-0">
                                        <div class="tab-content p-0" id="pills-tabContent">
                                            <div class="tab-pane fade show" id="pills-home" role="tabpanel"
                                                aria-labelledby="pills-home-tab" tabindex="0">
                                                <div class="card card-body shadow-none" style="padding: 10px;line-height: 5px;">
                                                    <div class="row g-3 new_box" style="padding: 0px 30px;">
                                                        <div class="col-md-6 col-lg5">
                                                            <div
                                                                class="card bg-label-success card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A101</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-success h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ชำระเงินแล้ว
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div
                                                                class="card bg-label-success card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A102</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-success h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ชำระเงินแล้ว
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div
                                                                class="card bg-label-success card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A103</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-success h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ชำระเงินแล้ว
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-label-success card-check shadow-sm">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A104</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-success h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ชำระเงินแล้ว
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-label-success card-check shadow-sm">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A105</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-success h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ชำระเงินแล้ว
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-lightGray card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A106</b></h5>
                                                                        <p>ไม่มีผู้เช่า</p>
                                                                    <div class="h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ห้องว่าง
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-lightGray card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A107</b></h5>
                                                                        <p>ไม่มีผู้เช่า</p>
                                                                    <div class="h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ห้องว่าง
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-lightGray card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A108</b></h5>
                                                                        <p>ไม่มีผู้เช่า</p>
                                                                    <div class="h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ห้องว่าง
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-lightGray card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A109</b></h5>
                                                                        <p>ไม่มีผู้เช่า</p>
                                                                    <div class="h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ห้องว่าง
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-lightGray card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A110</b></h5>
                                                                        <p>ไม่มีผู้เช่า</p>
                                                                    <div class="h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ห้องว่าง
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-label-danger card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A106</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-danger h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ค้างชำระ
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-label-danger card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A107</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-danger h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ค้างชำระ
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-label-danger card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A108</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-danger h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ค้างชำระ
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-label-danger card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A109</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-danger h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ค้างชำระ
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-label-danger card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A110</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-danger h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ค้างชำระ
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                                                aria-labelledby="pills-profile-tab" tabindex="0">
                                                <table class="datatables-basic table dataTable no-footer dtr-column"
                                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                        <thead class="border-top">
                                                            <tr class=" table-info">
                                                                <th class="text-center" tabindex="0" style="width: 40px;">
                                                                    ลำดับ
                                                                </th>
                                                                <th class="text-center">
                                                                    ชื่อผู้เช่า
                                                                </th>
                                                                <th class="text-center">
                                                                    ห้อง</th>
                                                                <th class="text-center">
                                                                    เบอร์ติดต่อ</th>
                                                                <th class="text-center">
                                                                    ยานพาหนะ
                                                                </th>
                                                                <th class="text-center">
                                                                    วันที่เข้าพัก
                                                                </th>
                                                                <th class="text-center">
                                                                    วันสิ้นสุดสัญญาเช่า
                                                                </th>
                                                                <th class="text-center">
                                                                    อายุสัญญา
                                                                </th>
                                                                {{-- <th class="text-center">
                                                                    
                                                                </th> --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="odd">
                                                                <td class="text-center">1</td>
                                                                <td class="text-center">
                                                                    บริษัท Kittinakorn
                                                                </td>
                                                                <td class="text-center">A201
                                                                </td>
                                                                <td class="text-center">0909090909
                                                                </td>
                                                                <td class="text-center">
                                                                    รถยนต์ ก 1234
                                                                </td>
                                                                <td class="text-center">
                                                                    19/12/2024
                                                                </td>
                                                                <td class="text-center">
                                                                    19/06/2025
                                                                </td>
                                                                <td class="text-center">
                                                                    6 เดือน
                                                                </td>
                                                                {{-- <td class="text-center">
                                                                    <div class="d-inline-block text-nowrap">
                                                                        <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light me-2">
                                                                            <i class="ti ti-eye ti-md" style="color:#6f6b7d !important;"></i>
                                                                        </button>
                                                                    </div>
                                                                </td> --}}
                                                            </tr>
                                                            <tr class="odd">
                                                                <td class="text-center">2</td>
                                                                <td class="text-center">
                                                                    บริษัท Kittinakorn
                                                                </td>
                                                                <td class="text-center">B102
                                                                </td>
                                                                <td class="text-center">0909090909
                                                                </td>
                                                                <td class="text-center">
                                                                    รถยนต์ ก 1234
                                                                </td>
                                                                <td class="text-center">
                                                                    19/12/2024
                                                                </td>
                                                                <td class="text-center">
                                                                    19/06/2025
                                                                </td>
                                                                <td class="text-center">
                                                                    6 เดือน
                                                                </td>
                                                                {{-- <td class="text-center">
                                                                    <div class="d-inline-block text-nowrap">
                                                                        <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light me-2">
                                                                            <i class="ti ti-eye ti-md" style="color:#6f6b7d !important;"></i>
                                                                        </button>
                                                                    </div>
                                                                </td> --}}
                                                            </tr>
                                                            <tr class="odd">
                                                                <td class="text-center">3</td>
                                                                <td class="text-center">
                                                                    บริษัท Kittinakorn
                                                                </td>
                                                                <td class="text-center">B101
                                                                </td>
                                                                <td class="text-center">0909090909
                                                                </td>
                                                                <td class="text-center">
                                                                    รถยนต์ ข 5678
                                                                </td>
                                                                <td class="text-center">
                                                                    19/12/2024
                                                                </td>
                                                                <td class="text-center">
                                                                    19/06/2025
                                                                </td>
                                                                <td class="text-center">
                                                                    6 เดือน
                                                                </td>
                                                                {{-- <td class="text-center">
                                                                    <div class="d-inline-block text-nowrap">
                                                                        <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light me-2">
                                                                            <i class="ti ti-eye ti-md" style="color:#6f6b7d !important;"></i>
                                                                        </button>
                                                                    </div>
                                                                </td> --}}
                                                            </tr>
                                                            
                                                            <tr class="odd">
                                                                <td class="text-center">4</td>
                                                                <td class="text-center">
                                                                    บริษัท Kittinakorn
                                                                </td>
                                                                <td class="text-center">A102
                                                                </td>
                                                                <td class="text-center">0909090909
                                                                </td>
                                                                <td class="text-center">
                                                                    รถยนต์ ค 7894
                                                                </td>
                                                                <td class="text-center">
                                                                    19/12/2024
                                                                </td>
                                                                <td class="text-center">
                                                                    19/06/2025
                                                                </td>
                                                                <td class="text-center">
                                                                    6 เดือน
                                                                </td>
                                                                {{-- <td class="text-center">
                                                                    <div class="d-inline-block text-nowrap">
                                                                        <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light me-2">
                                                                            <i class="ti ti-eye ti-md" style="color:#6f6b7d !important;"></i>
                                                                        </button>
                                                                    </div>
                                                                </td> --}}
                                                            </tr>
                                                            
                                                            <tr class="odd">
                                                                <td class="text-center">5</td>
                                                                <td class="text-center">
                                                                    บริษัท Kittinakorn
                                                                </td>
                                                                <td class="text-center">A101
                                                                </td>
                                                                <td class="text-center">0909090909
                                                                </td>
                                                                <td class="text-center">
                                                                    รถยนต์ ก 1234
                                                                </td>
                                                                <td class="text-center">
                                                                    19/12/2024
                                                                </td>
                                                                <td class="text-center">
                                                                    19/06/2025
                                                                </td>
                                                                <td class="text-center">
                                                                    6 เดือน
                                                                </td>
                                                                {{-- <td class="text-center">
                                                                    <div class="d-inline-block text-nowrap">
                                                                        <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light me-2">
                                                                            <i class="ti ti-eye ti-md" style="color:#6f6b7d !important;"></i>
                                                                        </button>
                                                                    </div>
                                                                </td> --}}
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6 ps-4">
                                                        <div class="dataTables_info" id="DataTables_Table_1_info"
                                                            role="status" aria-live="polite">Showing 1 to 10 of 100
                                                            entries</div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 pe-4">
                                                        <div class="dataTables_paginate paging_simple_numbers"
                                                            id="DataTables_Table_1_paginate">
                                                            <ul class="pagination justify-content-end">
                                                                <li class="paginate_button page-item previous disabled"
                                                                    id="DataTables_Table_1_previous"><a
                                                                        aria-controls="DataTables_Table_1"
                                                                        aria-disabled="true" role="link"
                                                                        data-dt-idx="previous" tabindex="-1"
                                                                        class="page-link"><i
                                                                            class="ti ti-chevron-left ti-sm"></i></a>
                                                                </li>
                                                                <li class="paginate_button page-item active"><a href="#"
                                                                        aria-controls="DataTables_Table_1" role="link"
                                                                        aria-current="page" data-dt-idx="0" tabindex="0"
                                                                        class="page-link">1</a></li>
                                                                <li class="paginate_button page-item "><a href="#"
                                                                        aria-controls="DataTables_Table_1" role="link"
                                                                        data-dt-idx="1" tabindex="0"
                                                                        class="page-link">2</a></li>
                                                                <li class="paginate_button page-item "><a href="#"
                                                                        aria-controls="DataTables_Table_1" role="link"
                                                                        data-dt-idx="2" tabindex="0"
                                                                        class="page-link">3</a></li>
                                                                <li class="paginate_button page-item "><a href="#"
                                                                        aria-controls="DataTables_Table_1" role="link"
                                                                        data-dt-idx="3" tabindex="0"
                                                                        class="page-link">4</a></li>
                                                                <li class="paginate_button page-item "><a href="#"
                                                                        aria-controls="DataTables_Table_1" role="link"
                                                                        data-dt-idx="4" tabindex="0"
                                                                        class="page-link">5</a></li>
                                                                <li class="paginate_button page-item disabled"
                                                                    id="DataTables_Table_1_ellipsis"><a
                                                                        aria-controls="DataTables_Table_1"
                                                                        aria-disabled="true" role="link"
                                                                        data-dt-idx="ellipsis" tabindex="-1"
                                                                        class="page-link">…</a></li>
                                                                <li class="paginate_button page-item "><a href="#"
                                                                        aria-controls="DataTables_Table_1" role="link"
                                                                        data-dt-idx="14" tabindex="0"
                                                                        class="page-link">15</a></li>
                                                                <li class="paginate_button page-item next"
                                                                    id="DataTables_Table_1_next"><a href="#"
                                                                        aria-controls="DataTables_Table_1" role="link"
                                                                        data-dt-idx="next" tabindex="0"
                                                                        class="page-link"><i
                                                                            class="ti ti-chevron-right ti-sm"></i></a>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    ฝฝฝฝฝ
                                </div>
                                            <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
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
                                                <ul class="nav nav-pills" id="pills-tablayout" role="tablist">
                                                    <li class="nav-item me-1" role="presentation">
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-secondary waves-effect"
                                                            id="pills-home-tab" data-bs-toggle="pill"
                                                            data-bs-target="#pills-home" type="button" role="tab"
                                                            aria-controls="pills-home" aria-selected="true">
                                                            <span class="ti ti-layout-grid ti-md"></span>
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-secondary waves-effect active"
                                                            data-bs-toggle="pill" data-bs-target="#pills-profile"
                                                            type="button" role="tab" aria-controls="pills-profile"
                                                            aria-selected="false">
                                                            <span class="ti ti-list ti-md"></span>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                            <div class="col-md-8 flex text-end" style="padding-right: unset !important;">
                                                <button
                                                        style="padding-right: 14px;padding-left: 14px;"
                                                        class="btn btn-success buttons-collection btn-primary waves-effect waves-light me-2"
                                                        tabindex="0" aria-controls="DataTables_Table_0"
                                                        type="button" aria-haspopup="dialog"
                                                        aria-expanded="false">
                                                        <span>
                                                            <i class="ti ti-file-upload"></i> 
                                                            พิมพ์เอกสารเช็ครถ
                                                        </span>
                                                </button>
                                                <button
                                                        style="padding-right: 14px;padding-left: 14px;"
                                                        class="btn btn-success buttons-collection btn-warning waves-effect waves-light me-2"
                                                        tabindex="0" aria-controls="DataTables_Table_0"
                                                        type="button" aria-haspopup="dialog"
                                                        aria-expanded="false">
                                                        <span>
                                                            <i class="ti ti-upload"></i> 
                                                            ดาวน์โหลด Excel
                                                        </span>
                                                </button>
                                                {{-- <button
                                                            style="padding-right: 14px;padding-left: 14px;margin-right: 0px;"
                                                            class="btn btn-success buttons-collection  btn-info waves-effect waves-light"
                                                            tabindex="0" aria-controls="DataTables_Table_0"
                                                            type="button" aria-haspopup="dialog"
                                                            aria-expanded="false" data-bs-toggle="modal" data-bs-target="#addModal">
                                                        <span><i class="ti ti-plus"></i> เพิ่มผู้เช่าห้อง</span>
                                                    </button> --}}
                                            </div>
                                        
                                    </div>
                                    <div class="card-body px-0 pt-0">
                                        <div class="tab-content p-0" id="pills-tabContent">
                                            <div class="tab-pane fade show" id="pills-home" role="tabpanel"
                                                aria-labelledby="pills-home-tab" tabindex="0">
                                                <div class="card card-body shadow-none" style="padding: 10px;line-height: 5px;">
                                                    <div class="row g-3 new_box" style="padding: 0px 30px;">
                                                        <div class="col-md-6 col-lg5">
                                                            <div
                                                                class="card bg-label-success card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A101</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-success h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ชำระเงินแล้ว
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div
                                                                class="card bg-label-success card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A102</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-success h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ชำระเงินแล้ว
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div
                                                                class="card bg-label-success card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A103</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-success h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ชำระเงินแล้ว
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-label-success card-check shadow-sm">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A104</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-success h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ชำระเงินแล้ว
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-label-success card-check shadow-sm">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A105</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-success h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ชำระเงินแล้ว
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-lightGray card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A106</b></h5>
                                                                        <p>ไม่มีผู้เช่า</p>
                                                                    <div class="h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ห้องว่าง
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-lightGray card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A107</b></h5>
                                                                        <p>ไม่มีผู้เช่า</p>
                                                                    <div class="h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ห้องว่าง
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-lightGray card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A108</b></h5>
                                                                        <p>ไม่มีผู้เช่า</p>
                                                                    <div class="h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ห้องว่าง
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-lightGray card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A109</b></h5>
                                                                        <p>ไม่มีผู้เช่า</p>
                                                                    <div class="h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ห้องว่าง
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-lightGray card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A110</b></h5>
                                                                        <p>ไม่มีผู้เช่า</p>
                                                                    <div class="h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ห้องว่าง
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-label-danger card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A106</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-danger h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ค้างชำระ
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-label-danger card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A107</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-danger h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ค้างชำระ
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-label-danger card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A108</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-danger h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ค้างชำระ
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-label-danger card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A109</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-danger h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ค้างชำระ
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 col-lg5">
                                                            <div class="card bg-label-danger card-check shadow-sm h-100">
                                                                <div class="card-body text-center">
                                                                    <h5 class="card-title" style="color: black"><b>A110</b></h5>
                                                                        <p style="color: rgb(40, 40, 40);font-weight: 430;">นางสาว มาลินี ประเทศา</p>
                                                                    <div class="text-danger h5 text-center" style="margin-top: 0;margin-bottom: 0;">
                                                                        ค้างชำระ
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                                                aria-labelledby="pills-profile-tab" tabindex="0">
                                                <table class="datatables-basic table dataTable no-footer dtr-column"
                                                        id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                        <thead class="border-top">
                                                            <tr class=" table-info">
                                                                <th class="text-center" tabindex="0" style="width: 40px;">
                                                                    ลำดับ
                                                                </th>
                                                                <th class="text-center">
                                                                    ชื่อผู้เช่า
                                                                </th>
                                                                <th class="text-center">
                                                                    ห้อง</th>
                                                                <th class="text-center">
                                                                    เบอร์ติดต่อ</th>
                                                                <th class="text-center">
                                                                    ยานพาหนะ
                                                                </th>
                                                                <th class="text-center">
                                                                    วันที่เข้าพัก
                                                                </th>
                                                                <th class="text-center">
                                                                    วันสิ้นสุดสัญญาเช่า
                                                                </th>
                                                                <th class="text-center">
                                                                    อายุสัญญา
                                                                </th>
                                                                {{-- <th class="text-center">
                                                                    
                                                                </th> --}}
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="odd">
                                                                <td class="text-center">1</td>
                                                                <td class="text-center">
                                                                    บริษัท Kittinakorn
                                                                </td>
                                                                <td class="text-center">A201
                                                                </td>
                                                                <td class="text-center">0909090909
                                                                </td>
                                                                <td class="text-center">
                                                                    รถยนต์ ก 1234
                                                                </td>
                                                                <td class="text-center">
                                                                    19/12/2024
                                                                </td>
                                                                <td class="text-center">
                                                                    19/06/2025
                                                                </td>
                                                                <td class="text-center">
                                                                    6 เดือน
                                                                </td>
                                                                {{-- <td class="text-center">
                                                                    <div class="d-inline-block text-nowrap">
                                                                        <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light me-2">
                                                                            <i class="ti ti-eye ti-md" style="color:#6f6b7d !important;"></i>
                                                                        </button>
                                                                    </div>
                                                                </td> --}}
                                                            </tr>
                                                            <tr class="odd">
                                                                <td class="text-center">2</td>
                                                                <td class="text-center">
                                                                    บริษัท Kittinakorn
                                                                </td>
                                                                <td class="text-center">B102
                                                                </td>
                                                                <td class="text-center">0909090909
                                                                </td>
                                                                <td class="text-center">
                                                                    รถยนต์ ก 1234
                                                                </td>
                                                                <td class="text-center">
                                                                    19/12/2024
                                                                </td>
                                                                <td class="text-center">
                                                                    19/06/2025
                                                                </td>
                                                                <td class="text-center">
                                                                    6 เดือน
                                                                </td>
                                                                {{-- <td class="text-center">
                                                                    <div class="d-inline-block text-nowrap">
                                                                        <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light me-2">
                                                                            <i class="ti ti-eye ti-md" style="color:#6f6b7d !important;"></i>
                                                                        </button>
                                                                    </div>
                                                                </td> --}}
                                                            </tr>
                                                            <tr class="odd">
                                                                <td class="text-center">3</td>
                                                                <td class="text-center">
                                                                    บริษัท Kittinakorn
                                                                </td>
                                                                <td class="text-center">B101
                                                                </td>
                                                                <td class="text-center">0909090909
                                                                </td>
                                                                <td class="text-center">
                                                                    รถยนต์ ข 5678
                                                                </td>
                                                                <td class="text-center">
                                                                    19/12/2024
                                                                </td>
                                                                <td class="text-center">
                                                                    19/06/2025
                                                                </td>
                                                                <td class="text-center">
                                                                    6 เดือน
                                                                </td>
                                                                {{-- <td class="text-center">
                                                                    <div class="d-inline-block text-nowrap">
                                                                        <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light me-2">
                                                                            <i class="ti ti-eye ti-md" style="color:#6f6b7d !important;"></i>
                                                                        </button>
                                                                    </div>
                                                                </td> --}}
                                                            </tr>
                                                            
                                                            <tr class="odd">
                                                                <td class="text-center">4</td>
                                                                <td class="text-center">
                                                                    บริษัท Kittinakorn
                                                                </td>
                                                                <td class="text-center">A102
                                                                </td>
                                                                <td class="text-center">0909090909
                                                                </td>
                                                                <td class="text-center">
                                                                    รถยนต์ ค 7894
                                                                </td>
                                                                <td class="text-center">
                                                                    19/12/2024
                                                                </td>
                                                                <td class="text-center">
                                                                    19/06/2025
                                                                </td>
                                                                <td class="text-center">
                                                                    6 เดือน
                                                                </td>
                                                                {{-- <td class="text-center">
                                                                    <div class="d-inline-block text-nowrap">
                                                                        <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light me-2">
                                                                            <i class="ti ti-eye ti-md" style="color:#6f6b7d !important;"></i>
                                                                        </button>
                                                                    </div>
                                                                </td> --}}
                                                            </tr>
                                                            
                                                            <tr class="odd">
                                                                <td class="text-center">5</td>
                                                                <td class="text-center">
                                                                    บริษัท Kittinakorn
                                                                </td>
                                                                <td class="text-center">A101
                                                                </td>
                                                                <td class="text-center">0909090909
                                                                </td>
                                                                <td class="text-center">
                                                                    รถยนต์ ก 1234
                                                                </td>
                                                                <td class="text-center">
                                                                    19/12/2024
                                                                </td>
                                                                <td class="text-center">
                                                                    19/06/2025
                                                                </td>
                                                                <td class="text-center">
                                                                    6 เดือน
                                                                </td>
                                                                {{-- <td class="text-center">
                                                                    <div class="d-inline-block text-nowrap">
                                                                        <button class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light me-2">
                                                                            <i class="ti ti-eye ti-md" style="color:#6f6b7d !important;"></i>
                                                                        </button>
                                                                    </div>
                                                                </td> --}}
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                <div class="row">
                                                    <div class="col-sm-12 col-md-6 ps-4">
                                                        <div class="dataTables_info" id="DataTables_Table_1_info"
                                                            role="status" aria-live="polite">Showing 1 to 10 of 100
                                                            entries</div>
                                                    </div>
                                                    <div class="col-sm-12 col-md-6 pe-4">
                                                        <div class="dataTables_paginate paging_simple_numbers"
                                                            id="DataTables_Table_1_paginate">
                                                            <ul class="pagination justify-content-end">
                                                                <li class="paginate_button page-item previous disabled"
                                                                    id="DataTables_Table_1_previous"><a
                                                                        aria-controls="DataTables_Table_1"
                                                                        aria-disabled="true" role="link"
                                                                        data-dt-idx="previous" tabindex="-1"
                                                                        class="page-link"><i
                                                                            class="ti ti-chevron-left ti-sm"></i></a>
                                                                </li>
                                                                <li class="paginate_button page-item active"><a href="#"
                                                                        aria-controls="DataTables_Table_1" role="link"
                                                                        aria-current="page" data-dt-idx="0" tabindex="0"
                                                                        class="page-link">1</a></li>
                                                                <li class="paginate_button page-item "><a href="#"
                                                                        aria-controls="DataTables_Table_1" role="link"
                                                                        data-dt-idx="1" tabindex="0"
                                                                        class="page-link">2</a></li>
                                                                <li class="paginate_button page-item "><a href="#"
                                                                        aria-controls="DataTables_Table_1" role="link"
                                                                        data-dt-idx="2" tabindex="0"
                                                                        class="page-link">3</a></li>
                                                                <li class="paginate_button page-item "><a href="#"
                                                                        aria-controls="DataTables_Table_1" role="link"
                                                                        data-dt-idx="3" tabindex="0"
                                                                        class="page-link">4</a></li>
                                                                <li class="paginate_button page-item "><a href="#"
                                                                        aria-controls="DataTables_Table_1" role="link"
                                                                        data-dt-idx="4" tabindex="0"
                                                                        class="page-link">5</a></li>
                                                                <li class="paginate_button page-item disabled"
                                                                    id="DataTables_Table_1_ellipsis"><a
                                                                        aria-controls="DataTables_Table_1"
                                                                        aria-disabled="true" role="link"
                                                                        data-dt-idx="ellipsis" tabindex="-1"
                                                                        class="page-link">…</a></li>
                                                                <li class="paginate_button page-item "><a href="#"
                                                                        aria-controls="DataTables_Table_1" role="link"
                                                                        data-dt-idx="14" tabindex="0"
                                                                        class="page-link">15</a></li>
                                                                <li class="paginate_button page-item next"
                                                                    id="DataTables_Table_1_next"><a href="#"
                                                                        aria-controls="DataTables_Table_1" role="link"
                                                                        data-dt-idx="next" tabindex="0"
                                                                        class="page-link"><i
                                                                            class="ti ti-chevron-right ti-sm"></i></a>
                                                                </li>
                                                            </ul>
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
    <div class="modal fade modalHeadDecor" id="addserviceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">เพิ่มค่าบริการ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">ชื่อบริการ<span
                                    class="text-muted">(ภาษาไทย)</span></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="" />
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">ชื่อบริการ<span
                                    class="text-muted">(ภาษาอังกฤษ)</span></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="" />
                        </div>
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label">ราคาค่าบริการ<span
                                    class="text-muted">(บาท/เดือน)</span></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer rounded-0 justify-content-center">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-main">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
    <!--edit service Modal -->
    <div class="modal fade modalHeadDecor" id="editserviceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">แก้ไขค่าซักผ้า</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">ชื่อบริการ<span
                                    class="text-muted">(ภาษาไทย)</span></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder=""
                                value="ค่าซักผ้า" disabled />
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">ชื่อบริการ<span
                                    class="text-muted">(ภาษาอังกฤษ)</span></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder=""
                                value="Laundry cost" disabled />
                        </div>
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label">ราคาค่าบริการ<span
                                    class="text-muted">(บาท/เดือน)</span></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder=""
                                value="350.00" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer rounded-0 justify-content-center">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-main">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
    <!--set service Modal -->
    <div class="modal fade modalHeadDecor" id="setServiceFeesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">กำหนดค่าบริการ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label">เลือกบริการ</label>
                            <div class="row g-3">
                                <div class="col-sm-4">
                                    <div class="form-check custom-option custom-option-basic checked">
                                        <label class="form-check-label custom-option-content" for="customRadioTemp1">
                                            <input name="customRadioTemp" class="form-check-input" type="radio" value=""
                                                id="customRadioTemp1" checked="">
                                            <span class="custom-option-header">
                                                <span class="h6 mb-0">ค่าซักผ้า</span>
                                            </span>
                                            <!-- <span class="custom-option-body">
                                                <small>Get 1 project with 1 teams members.</small>
                                            </span> -->
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-check custom-option custom-option-basic">
                                        <label class="form-check-label custom-option-content" for="customRadioTemp2">
                                            <input name="customRadioTemp" class="form-check-input" type="radio" value=""
                                                id="customRadioTemp2">
                                            <span class="custom-option-header">
                                                <span class="h6 mb-0">ค่าที่จอดรถ</span>
                                            </span>
                                            <!-- <span class="custom-option-body">
                                                <small>Get 1 project with 1 teams members.</small>
                                            </span> -->
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-check custom-option custom-option-basic">
                                        <label class="form-check-label custom-option-content" for="customRadioTemp3">
                                            <input name="customRadioTemp" class="form-check-input" type="radio" value=""
                                                id="customRadioTemp3">
                                            <span class="custom-option-header">
                                                <span class="h6 mb-0">ค่าอินเตอร์เน็ต</span>
                                            </span>
                                            <!-- <span class="custom-option-body">
                                                <small>Get 1 project with 1 teams members.</small>
                                            </span> -->
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label">ราคาค่าบริการ<span
                                    class="text-muted">(บาท/เดือน)</span></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder=""
                                value="350.00" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer rounded-0 justify-content-center">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-main">บันทึก</button>
                </div>
            </div>
        </div>
    </div>

    <!--add discount  Modal -->
    <div class="modal fade modalHeadDecor" id="adddiscountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">เพิ่มรายการส่วนลด</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">ชื่อบริการ<span
                                    class="text-muted">(ภาษาไทย)</span></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="" />
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">ชื่อบริการ<span
                                    class="text-muted">(ภาษาอังกฤษ)</span></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="" />
                        </div>
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label">ราคาส่วนลด<span
                                    class="text-muted">(บาท)</span></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer rounded-0 justify-content-center">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-main">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
    <!--edit discount Modal -->
    <div class="modal fade modalHeadDecor" id="editDiscountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">แก้ไขส่วนลดซักผ้า</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">ชื่อบริการ<span
                                    class="text-muted">(ภาษาไทย)</span></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder=""
                                value="ส่วนลดซักผ้า" disabled />
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">ชื่อบริการ<span
                                    class="text-muted">(ภาษาอังกฤษ)</span></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder=""
                                value="Laundry discount" disabled />
                        </div>
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label">ราคาส่วนลด<span
                                    class="text-muted">(บาท)</span></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder=""
                                value="50.00" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer rounded-0 justify-content-center">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-main">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
    <!--set discount Modal -->
    <div class="modal fade modalHeadDecor" id="setDiscountFeesModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">กำหนดส่วนลด</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label">เลือกส่วนลด</label>
                            <div class="row g-3">
                                <div class="col-sm-4">
                                    <div class="form-check custom-option custom-option-basic checked">
                                        <label class="form-check-label custom-option-content" for="customRadioTemp1">
                                            <input name="customRadioTemp" class="form-check-input" type="radio" value=""
                                                id="customRadioTemp1" checked="">
                                            <span class="custom-option-header">
                                                <span class="h6 mb-0">ส่วนลดซักผ้า</span>
                                            </span>
                                            <!-- <span class="custom-option-body">
                                                <small>Get 1 project with 1 teams members.</small>
                                            </span> -->
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-check custom-option custom-option-basic">
                                        <label class="form-check-label custom-option-content" for="customRadioTemp2">
                                            <input name="customRadioTemp" class="form-check-input" type="radio" value=""
                                                id="customRadioTemp2">
                                            <span class="custom-option-header">
                                                <span class="h6 mb-0">ส่วนลดที่จอดรถ</span>
                                            </span>
                                            <!-- <span class="custom-option-body">
                                                <small>Get 1 project with 1 teams members.</small>
                                            </span> -->
                                        </label>
                                    </div>
                                </div>
                                <div class="col-sm-4">
                                    <div class="form-check custom-option custom-option-basic">
                                        <label class="form-check-label custom-option-content" for="customRadioTemp3">
                                            <input name="customRadioTemp" class="form-check-input" type="radio" value=""
                                                id="customRadioTemp3">
                                            <span class="custom-option-header">
                                                <span class="h6 mb-0">ส่วนลดอินเตอร์เน็ต</span>
                                            </span>
                                            <!-- <span class="custom-option-body">
                                                <small>Get 1 project with 1 teams members.</small>
                                            </span> -->
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label">ราคาส่วนลด<span
                                    class="text-muted">(บาท)</span></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder=""
                                value="50.00" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer rounded-0 justify-content-center">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-main">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade modalHeadDecor" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">เพิ่มผู้เช่าห้อง</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5>ข้อมูลส่วนตัว</h5>
                    <div class="row g-3">
                        <div class="col-sm-2">
                            <label for="exampleFormControlInput1" class="form-label">คำนำหน้า</label>
                            <select class="form-select" id="exampleFormControlSelect1"
                                aria-label="Default select example">
                                <option selected>บริษัท</option>
                                <option value="1">นาย</option>
                                <option value="2">นางสาว</option>
                                <option value="3">นาง</option>
                            </select>
                        </div>
                        <div class="col-sm-5">
                            <label for="exampleFormControlInput1" class="form-label">ชื่อจริง</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="" />
                        </div>
                        <div class="col-sm-5">
                            <label for="exampleFormControlInput1" class="form-label">นามสกุล</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="" />
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">เบอร์โทรศัพท์ (ตัวอย่าง. 0815578945)</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="" />
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">หมายเลขบัตรประชาชน</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="" />
                        </div>
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label">ที่อยู่ตามสำเนาทะเบียนบ้าน</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="เลขที่ ซอย ถนน อาคาร ห้องเลขที่ หรือหมู่บ้าน" />
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">แขวง/ตำบล</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="แขวง/ตำบล" />
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">เขต/อำเภอ</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="เขต/อำเภอ" />
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">จังหวัด</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="จังหวัด" />
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">รหัสไปรษณีย์</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="รหัสไปรษณีย์" />
                        </div>
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label">วันเดือนปีเกิดผู้จอง</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="วันเดือนปีเกิดผู้จอง" />
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">วันที่จอง</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="วันที่จอง" />
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">ช่องทางการจอง</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="ช่องทางการจอง" value="จองโดยตรงกับที่พัก" />
                        </div>
                    </div>
                    <h5 class="mt-4">รายการจองห้อง</h5>
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">วันที่จอง</label>
                            <input type="date" class="form-control" id="exampleFormControlInput1" placeholder="วันที่จอง" />
                        </div>
                        <div class="col-sm-7">
                            <label for="exampleFormControlInput1" class="form-label">เลือกห้อง</label>
                            <div class="accordion stick-top accordion-bordered" id="courseContent">
                                <div class="accordion-item active mb-0">
                                  <div class="accordion-header" id="headingOne">
                                    <button
                                      type="button"
                                      class="accordion-button bg-lighter rounded-0"
                                      data-bs-toggle="collapse"
                                      data-bs-target="#chapterOne"
                                      aria-expanded="true"
                                      aria-controls="chapterOne">
                                      <span class="d-flex flex-column">
                                        <span style="font-size: medium;font-weight: 430">ตึกคุณแบม</span>
                                      </span>
                                    </button>
                                  </div>
                                  <div id="chapterOne" class="accordion-collapse collapse show" data-bs-parent="#courseContent">
                                    <div class="accordion-body py-3 border-top">
                                        <div class="form-check align-items-center mb-3" style="padding: unset;">
                                            <div class="accordion stick-top accordion-bordered" id="courseContent2">
                                                <div class="accordion-item active mb-0">
                                                    <div class="accordion-header" id="headingOne2">
                                                        <button
                                                        type="button"
                                                        class="accordion-button bg-lighter rounded-0"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#chapterOne1"
                                                        aria-expanded="true"
                                                        aria-controls="chapterOne1">
                                                        <span class="d-flex flex-column">
                                                            <span class="me-2" style="font-size: medium;font-weight: 430">ชั้นมาทำอะไรที่นี่</span>
                                                        </span>
                                                        </button>
                                                    </div>
                                                    <div id="chapterOne1" class="accordion-collapse collapse show" data-bs-parent="#courseContent2">
                                                        <div class="accordion-body py-3 border-top">
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck1"/>
                                                                <label for="defaultCheck1" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A101</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck2"/>
                                                                <label for="defaultCheck2" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A102</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck3" />
                                                                <label for="defaultCheck3" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A103</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck4" />
                                                                <label for="defaultCheck4" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A104</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck5" />
                                                                <label for="defaultCheck5" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A105</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item mb-0">
                                                    <div class="accordion-header" id="headingTwo9">
                                                        <button
                                                        type="button"
                                                        class="bg-lighter rounded-0 accordion-button collapsed"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#chapterTwo9"
                                                        aria-expanded="false"
                                                        aria-controls="chapterTwo9">
                                                        <span class="d-flex flex-column">
                                                            <span class="me-2" style="font-size: medium;font-weight: 430">ชั้นเหนื่อย</span>
                                                        </span>
                                                        </button>
                                                    </div>
                                                    <div id="chapterTwo9" class="accordion-collapse collapse" data-bs-parent="#courseContent33">
                                                        <div class="accordion-body py-3 border-top">
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck1"/>
                                                                <label for="defaultCheck1" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A101</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck2"/>
                                                                <label for="defaultCheck2" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A102</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck3" />
                                                                <label for="defaultCheck3" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A103</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck4" />
                                                                <label for="defaultCheck4" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A104</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck5" />
                                                                <label for="defaultCheck5" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A105</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item mb-0">
                                                    <div class="accordion-header" id="headingTwo2">
                                                        <button
                                                        type="button"
                                                        class="bg-lighter rounded-0 accordion-button collapsed"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#chapterTwo2"
                                                        aria-expanded="false"
                                                        aria-controls="chapterTwo2">
                                                        <span class="d-flex flex-column">
                                                            <span class="me-2" style="font-size: medium;font-weight: 430">ชั้นง่วง</span>
                                                        </span>
                                                        </button>
                                                    </div>
                                                    <div id="chapterTwo2" class="accordion-collapse collapse" data-bs-parent="#courseContent2">
                                                        <div class="accordion-body py-3 border-top">
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck1"/>
                                                                <label for="defaultCheck1" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A101</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck2"/>
                                                                <label for="defaultCheck2" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A102</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck3" />
                                                                <label for="defaultCheck3" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A103</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck4" />
                                                                <label for="defaultCheck4" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A104</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck5" />
                                                                <label for="defaultCheck5" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A105</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="accordion-item mb-0">
                                  <div class="accordion-header" id="headingTwo">
                                    <button
                                      type="button"
                                      class="bg-lighter rounded-0 accordion-button collapsed"
                                      data-bs-toggle="collapse"
                                      data-bs-target="#chapterTwo"
                                      aria-expanded="false"
                                      aria-controls="chapterTwo">
                                      <span class="d-flex flex-column">
                                        <span style="font-size: medium;font-weight: 430">ตึกคุณโบว์</span>
                                      </span>
                                    </button>
                                  </div>
                                  <div id="chapterTwo" class="accordion-collapse collapse" data-bs-parent="#courseContent">
                                    <div class="accordion-body py-3 border-top">
                                        <div class="form-check align-items-center mb-3" style="padding: unset;">
                                            <div class="accordion stick-top accordion-bordered" id="courseContent3">
                                                <div class="accordion-item active mb-0">
                                                    <div class="accordion-header" id="headingOne3">
                                                        <button
                                                        type="button"
                                                        class="accordion-button bg-lighter rounded-0"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#chapterOne2"
                                                        aria-expanded="true"
                                                        aria-controls="chapterOne2">
                                                        <span class="d-flex flex-column">
                                                            <span class="me-2" style="font-size: medium;font-weight: 430">ชั้นมาทำอะไรที่นี่</span>
                                                        </span>
                                                        </button>
                                                    </div>
                                                    <div id="chapterOne2" class="accordion-collapse collapse show" data-bs-parent="#courseContent3">
                                                        <div class="accordion-body py-3 border-top">
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck1"/>
                                                                <label for="defaultCheck1" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A101</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck2"/>
                                                                <label for="defaultCheck2" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A102</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck3" />
                                                                <label for="defaultCheck3" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A103</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck4" />
                                                                <label for="defaultCheck4" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A104</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck5" />
                                                                <label for="defaultCheck5" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A105</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item mb-0">
                                                    <div class="accordion-header" id="headingTwo3">
                                                        <button
                                                        type="button"
                                                        class="bg-lighter rounded-0 accordion-button collapsed"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#chapterTwo4"
                                                        aria-expanded="false"
                                                        aria-controls="chapterTwo4">
                                                        <span class="d-flex flex-column">
                                                            <span class="me-2" style="font-size: medium;font-weight: 430">ชั้นเหนื่อย</span>
                                                        </span>
                                                        </button>
                                                    </div>
                                                    <div id="chapterTwo4" class="accordion-collapse collapse" data-bs-parent="#courseContent3">
                                                        <div class="accordion-body py-3 border-top">
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck1"/>
                                                                <label for="defaultCheck1" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A101</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck2"/>
                                                                <label for="defaultCheck2" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A102</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck3" />
                                                                <label for="defaultCheck3" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A103</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck4" />
                                                                <label for="defaultCheck4" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A104</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck5" />
                                                                <label for="defaultCheck5" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A105</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item mb-0">
                                                    <div class="accordion-header" id="headingTwo2">
                                                        <button
                                                        type="button"
                                                        class="bg-lighter rounded-0 accordion-button collapsed"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#chapterTwo5"
                                                        aria-expanded="false"
                                                        aria-controls="chapterTwo5">
                                                        <span class="d-flex flex-column">
                                                            <span class="me-2" style="font-size: medium;font-weight: 430">ชั้นง่วง</span>
                                                        </span>
                                                        </button>
                                                    </div>
                                                    <div id="chapterTwo5" class="accordion-collapse collapse" data-bs-parent="#courseContent4">
                                                        <div class="accordion-body py-3 border-top">
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck1"/>
                                                                <label for="defaultCheck1" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A101</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck2"/>
                                                                <label for="defaultCheck2" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A102</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck3" />
                                                                <label for="defaultCheck3" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A103</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck4" />
                                                                <label for="defaultCheck4" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A104</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck5" />
                                                                <label for="defaultCheck5" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A105</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="accordion-item mb-0">
                                  <div class="accordion-header" id="headingTwo7">
                                    <button
                                      type="button"
                                      class="bg-lighter rounded-0 accordion-button collapsed"
                                      data-bs-toggle="collapse"
                                      data-bs-target="#chapterTwo7"
                                      aria-expanded="false"
                                      aria-controls="chapterTwo7">
                                      <span class="d-flex flex-column">
                                        <span style="font-size: medium;font-weight: 430">ตึกคุณเบล</span>
                                      </span>
                                    </button>
                                  </div>
                                  <div id="chapterTwo7" class="accordion-collapse collapse" data-bs-parent="#courseContent7">
                                    <div class="accordion-body py-3 border-top">
                                        <div class="form-check align-items-center mb-3" style="padding: unset;">
                                            <div class="accordion stick-top accordion-bordered" id="courseContent7">
                                                <div class="accordion-item active mb-0">
                                                    <div class="accordion-header" id="headingOne3">
                                                        <button
                                                        type="button"
                                                        class="accordion-button bg-lighter rounded-0"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#chapterOne22"
                                                        aria-expanded="true"
                                                        aria-controls="chapterOne22">
                                                        <span class="d-flex flex-column">
                                                            <span class="me-2" style="font-size: medium;font-weight: 430">ชั้นมาทำอะไรที่นี่</span>
                                                        </span>
                                                        </button>
                                                    </div>
                                                    <div id="chapterOne22" class="accordion-collapse collapse show" data-bs-parent="#courseContent7">
                                                        <div class="accordion-body py-3 border-top">
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck1"/>
                                                                <label for="defaultCheck1" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A101</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck2"/>
                                                                <label for="defaultCheck2" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A102</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck3" />
                                                                <label for="defaultCheck3" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A103</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck4" />
                                                                <label for="defaultCheck4" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A104</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck5" />
                                                                <label for="defaultCheck5" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A105</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item mb-0">
                                                    <div class="accordion-header" id="headingTwo8">
                                                        <button
                                                        type="button"
                                                        class="bg-lighter rounded-0 accordion-button collapsed"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#chapterTwo8"
                                                        aria-expanded="false"
                                                        aria-controls="chapterTwo8">
                                                        <span class="d-flex flex-column">
                                                            <span class="me-2" style="font-size: medium;font-weight: 430">ชั้นเหนื่อย</span>
                                                        </span>
                                                        </button>
                                                    </div>
                                                    <div id="chapterTwo8" class="accordion-collapse collapse" data-bs-parent="#courseContent3">
                                                        <div class="accordion-body py-3 border-top">
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck1"/>
                                                                <label for="defaultCheck1" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A101</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck2"/>
                                                                <label for="defaultCheck2" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A102</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck3" />
                                                                <label for="defaultCheck3" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A103</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck4" />
                                                                <label for="defaultCheck4" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A104</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck5" />
                                                                <label for="defaultCheck5" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A105</span>
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item mb-0">
                                                    <div class="accordion-header" id="headingTwo10">
                                                        <button
                                                        type="button"
                                                        class="bg-lighter rounded-0 accordion-button collapsed"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#chapterTwo10"
                                                        aria-expanded="false"
                                                        aria-controls="chapterTwo10">
                                                        <span class="d-flex flex-column">
                                                            <span class="me-2" style="font-size: medium;font-weight: 430">ชั้นง่วง</span>
                                                        </span>
                                                        </button>
                                                    </div>
                                                    <div id="chapterTwo10" class="accordion-collapse collapse" data-bs-parent="#courseContent10">
                                                        <div class="accordion-body py-3 border-top">
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck1"/>
                                                                <label for="defaultCheck1" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A101</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck2"/>
                                                                <label for="defaultCheck2" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A102</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck3" />
                                                                <label for="defaultCheck3" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A103</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center mb-1">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck4" />
                                                                <label for="defaultCheck4" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A104</span>
                                                                </label>
                                                            </div>
                                                            <div class="form-check d-flex align-items-center">
                                                                <input class="form-check-input" type="checkbox" id="defaultCheck5" />
                                                                <label for="defaultCheck5" class="form-check-label ms-3">
                                                                <span class="mb-0 h6">A105</span>
                                                                </label>
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
                        <div class="col-sm-5">
                            <div class="accordion-body py-3 mt-3">
                                <div class="ms-3">
                                    <span class="mb-1 h5">ตึกคุณแบม</span>
                                </div>
                                <div class="ms-4">
                                    <span class="mb-2 h6">ชั้นมาทำอะไรที่นี่</span>
                                </div>
                                <div class="ms-5 mt-1">
                                    <div class="form-check d-flex align-items-center mb-1">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck1" checked/>
                                        <label for="defaultCheck1" class="form-check-label ms-3">
                                        <span class="mb-0 h6">A101</span>
                                        </label>
                                    </div>
                                    <div class="form-check d-flex align-items-center mb-1">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck2" checked/>
                                        <label for="defaultCheck2" class="form-check-label ms-3">
                                        <span class="mb-0 h6">A102</span>
                                        </label>
                                    </div>
                                    <div class="form-check d-flex align-items-center mb-1">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck3" checked/>
                                        <label for="defaultCheck3" class="form-check-label ms-3">
                                        <span class="mb-0 h6">A103</span>
                                        </label>
                                    </div>
                                    <div class="form-check d-flex align-items-center mb-1">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck4" checked/>
                                        <label for="defaultCheck4" class="form-check-label ms-3">
                                        <span class="mb-0 h6">A104</span>
                                        </label>
                                    </div>
                                    <div class="form-check d-flex align-items-center">
                                        <input class="form-check-input" type="checkbox" id="defaultCheck5" checked/>
                                        <label for="defaultCheck5" class="form-check-label ms-3">
                                        <span class="mb-0 h6">A105</span>
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="mt-4">รายละเอียดการชำระเงิน</h5>
                    <div class="row g-3">
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label">ค่ามัดจำ (บาท)</label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder="" />
                        </div>
                        <div class="col-sm-12">
                            <div>
                                <label for="exampleFormControlInput1" class="form-label">วิธีการชำระเงิน</label>
                            </div>
                            <div class="ms-3">
                                <label class="form-label">
                                    <input type="radio" name="n"/> เงินสด</label>
                                <label class="form-label ms-2">
                                    <input type="radio" name="n"/> โอนเงิน</label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput1" class="form-label">วันที่รับชำระเงิน</label>
                            <input type="date" class="form-control" id="exampleFormControlInput1" placeholder="" />
                        </div>
                    </div>
                </div>
                <div class="modal-footer rounded-0 justify-content-center">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="button" class="btn btn-main">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
    <!-- / Layout wrapper -->
    @include('layout/inc_js')
    <script src="assets/vendor/libs/select2/select2.js"></script>
    <script src="assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="assets/js/forms-selects.js"></script>
</body>

</html>