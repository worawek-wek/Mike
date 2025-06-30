<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template">

<head>
    @include('layout/inc_header')
    <title>Dashboard - CRM | Vuexy - Bootstrap Admin Template</title>
</head>
<style>
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
                                                    <i class="tf-icons ti ti-percentage text-main ti-md"></i>
                                                    ค่าบริการ ส่วนลด
                                                </h4>
                                            </div>
                                            {{-- <div class="col-sm-12">
                                                <ul class="nav nav-pills nav-fill " role="tablist">
                                                    <li class="nav-item">
                                                        <button type="button" class="nav-link active" role="tab"
                                                            data-bs-toggle="tab" data-bs-target="#navs-pills-top-home"
                                                            aria-controls="navs-pills-top-home"
                                                            aria-selected="true">ค่าบริการ</button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button type="button" class="nav-link" role="tab"
                                                            data-bs-toggle="tab"
                                                            data-bs-target="#navs-pills-top-profile"
                                                            aria-controls="navs-pills-top-profile"
                                                            aria-selected="false">ส่วนลด</button>
                                                    </li>
                                                </ul>
                                            </div>
                                             --}}
                                            <div class="col-sm-12" style="font-weight: 500;">
                                                <ul class="nav nav-pills nav-fill " role="tablist">
                                                    <li class="nav-item pe-4">
                                                        <button type="button" class="nav-link btn-primary active" id="meter_water" role="tab"
                                                            data-bs-toggle="tab" data-bs-target="#navs-pills-top-home"
                                                            aria-controls="navs-pills-top-home"
                                                            aria-selected="true">
                                                            ค่าบริการ
                                                        </button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button type="button" class="nav-link btn-label-danger" id="meter_electricity" role="tab"
                                                            data-bs-toggle="tab"
                                                            data-bs-target="#navs-pills-top-profile"
                                                            aria-controls="navs-pills-top-profile"
                                                            aria-selected="false">
                                                            ส่วนลด
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body pt-4">
                                        <div class="tab-content p-0">
                                            <div class="tab-pane fade show active" id="navs-pills-top-home" role="tabpanel">

                                                {{-- /////////////////////////////////////////////////////////// --}}
                                                {{-- ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ
                                                ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ
                                                ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ
                                                ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ
                                                ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ
                                                ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ
                                                ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ
                                                ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ
                                                ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ
                                                ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ
                                                ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ
                                                ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ
                                                ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ
                                                ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ ค่าบริการ --}}
                                                {{-- /////////////////////////////////////////////////////////// --}}

                                            </div>

                                            {{-- ------------------------------------------------ --}}
                                            {{-- ------------------------------------------------ --}}

                                            <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">

                                                {{-- /////////////////////////////////////////////////////////// --}}
                                                {{-- ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด
                                                ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด
                                                ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด
                                                ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด
                                                ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด
                                                ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด
                                                ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด
                                                ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด
                                                ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด
                                                ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด
                                                ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด
                                                ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด
                                                ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด ส่วนลด --}}
                                                {{-- /////////////////////////////////////////////////////////// --}}

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
    <form id="addService">
        @csrf
        <div class="modal fade modalHeadDecor" id="setServiceFeesModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-header rounded-0">
                        <h5 class="modal-title" id="exampleModalLabel1">กำหนดค่าบริการ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="formAddService">
                        
                    </div>
                    <div class="modal-footer rounded-0 justify-content-center">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-main">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    
    <!--add service  Modal -->
    <form id="deleteService">
        @csrf
        <div class="modal fade modalHeadDecor" id="deleteServiceModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-header rounded-0">
                        <h5 class="modal-title" id="exampleModalLabel1">ลบค่าบริการ</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="formDeleteService">
                    </div>
                    <div class="modal-footer rounded-0 justify-content-center">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-main">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--add service  Modal -->
    <form id="deleteDiscount">
        @csrf
        <div class="modal fade modalHeadDecor" id="deleteDiscountModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-header rounded-0">
                        <h5 class="modal-title" id="exampleModalLabel1">ลบส่วนลด</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="formDeleteDiscount">
                    </div>
                    <div class="modal-footer rounded-0 justify-content-center">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-main">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--add service  Modal -->
    <div class="modal fade modalHeadDecor" id="addserviceModal2" tabindex="-1" aria-hidden="true">
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
    
<form id="update_laundry">
    @csrf
    <div class="modal fade modalHeadDecor" id="editserviceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">แก้ไขค่าบริการ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewService">
                </div>
                <div class="modal-footer rounded-0 justify-content-center">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-main">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
</form>
<form id="update_discount">
    @csrf
    <div class="modal fade modalHeadDecor" id="editdiscountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">แก้ไขส่วนลด</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="viewDiscount">
                </div>
                <div class="modal-footer rounded-0 justify-content-center">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-main">บันทึก</button>
                </div>
            </div>
        </div>
    </div>
</form>
    <div class="modal fade modalHeadDecor" id="editserviceModal2" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">แก้ไขค่าที่จอดรถ</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">ชื่อบริการ<span
                                    class="text-muted">(ภาษาไทย)</span></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder=""
                                value="ค่าที่จอดรถ" disabled />
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">ชื่อบริการ<span
                                    class="text-muted">(ภาษาอังกฤษ)</span></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder=""
                                value="Parking fee" disabled />
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
    <div class="modal fade modalHeadDecor" id="editserviceModal3" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">แก้ไขค่าอินเตอร์เน็ต</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">ชื่อบริการ<span
                                    class="text-muted">(ภาษาไทย)</span></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder=""
                                value="ค่าอินเตอร์เน็ต" disabled />
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput1" class="form-label">ชื่อบริการ<span
                                    class="text-muted">(ภาษาอังกฤษ)</span></label>
                            <input type="text" class="form-control" id="exampleFormControlInput1" placeholder=""
                                value="Internet fee" disabled />
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
    

    {{-- <!--add discount  Modal -->
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
    </div> --}}
    
    <form id="addDiscount">
        @csrf
        <div class="modal fade modalHeadDecor" id="editDiscountModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                <div class="modal-content rounded-0">
                    <div class="modal-header rounded-0">
                        <h5 class="modal-title" id="exampleModalLabel1">กำหนดส่วนลด</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="formAddDiscount">
                        
                    </div>
                    <div class="modal-footer rounded-0 justify-content-center">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-main">บันทึก</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!--edit discount Modal -->
    {{-- <div class="modal fade modalHeadDecor" id="editDiscountModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">กำหนดส่วนลด</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body"  id="formAddDiscount">
                    
                </div>
                <div class="modal-footer rounded-0 justify-content-center">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                    <button type="submit" class="btn btn-main">บันทึก</button>
                </div>
            </div>
        </div>
    </div> --}}
    <!--set discount Modal -->
    {{-- <div class="modal fade modalHeadDecor" id="setDiscountFeesModal" tabindex="-1" aria-hidden="true">
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
    </div> --}}
    <!-- / Layout wrapper -->

    <!-- / Layout wrapper -->
    @include('layout/inc_js')
    <script>
        var page = "{{$page_url}}/datatable";
        var searchData = {};
        loadData(page);
        loadDataDiscount(page);
        
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
                url: 'setting/service/datatable',
                data: searchData,
                success: function(data) {
                    $("#navs-pills-top-home").html(data);
                }
            });
            // alert(page);
        }
        function loadDataDiscount(pages){
            
            $('.p_search').each(function() {
                var inputName = $(this).attr('name'); // ดึงชื่อ attribute 'name' ของ input
                var inputValue = $(this).val(); // ดึงค่า value ของ input
                
                searchData[inputName] = inputValue; // เก็บข้อมูลลงในออบเจ็กต์ searchData
            });

            // alert(page);
            page = pages;
            $.ajax({
                type: "GET",
                url: 'setting/discount/datatable',
                data: searchData,
                success: function(data) {
                    $("#navs-pills-top-profile").html(data);
                }
            });
            // alert(page);
        }
        function getService(){
            $.ajax({
                type: "GET",
                url: 'setting/service/get_service',
                data: searchData,
                success: function(data) {
                    $("#formAddService").html(data);
                }
            });
            // alert(page);
        }
        function getDiscount(){
            $.ajax({
                type: "GET",
                url: 'setting/discount/get_discount',
                data: searchData,
                success: function(data) {
                    $("#formAddDiscount").html(data);
                }
            });
            // alert(page);
        }
        function deleteService(){
            $.ajax({
                type: "GET",
                url: 'setting/service/delete_service',
                data: searchData,
                success: function(data) {
                    $("#formDeleteService").html(data);
                }
            });
            // alert(page);
        }
        function deleteDiscount_d(){
            $.ajax({
                type: "GET",
                url: 'setting/discount/delete_discount',
                data: searchData,
                success: function(data) {
                    $("#formDeleteDiscount").html(data);
                }
            });
            // alert(page);
        }
        var update_id = 999999999999;
        var update_ids_discount= 999999999999;
        function view_service(id){
            if(id == 'all'){
                var id = [];
                
                // ตรวจสอบ checkbox ที่ถูกเลือก
                $('input.ids_service:checked').each(function() {
                    id.push($(this).val());
                });
                id = id;

            }
            $.ajax({
                type: "GET",
                url: "setting/service/room/"+id,
                success: function(data) {
                    $("#viewService").html(data);
                    update_id = id;
                }
            });
        }
        function view_discount(id){
            if(id == 'all'){
                var id = [];
                
                // ตรวจสอบ checkbox ที่ถูกเลือก
                $('input.ids_discount:checked').each(function() {
                    id.push($(this).val());
                });
                id = id;
            }
            $.ajax({
                type: "GET",
                url: "setting/discount/room/"+id,
                success: function(data) {
                    $("#viewDiscount").html(data);
                    update_ids_discount= id;
                }
            });
        }
        // function view_service_2(id){
        //     $.ajax({
        //         type: "GET",
        //         url: "setting/water-bill/"+id,
        //         success: function(data) {
        //             $("#view_water").html(data);
        //             update_id = id;
        //         }
        //     });
        // }
        // function view_service_3(id){
        //     $.ajax({
        //         type: "GET",
        //         url: "setting/water-bill/"+id,
        //         success: function(data) {
        //             $("#view_water").html(data);
        //             update_id = id;
        //         }
        //     });
        // }
        
        $('#addService').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
// console.log(update_id);
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการเพิ่มค่าบริการหรือไม่?',
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
                        url: 'setting/service/insert', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response == true){
                                Swal.fire('เพิ่มค่าบริการเรียบร้อยแล้ว', '', 'success');
                                $('#addserviceModal').modal('hide');
                                loadData(page);
                                getService();
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
        $('#addDiscount').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
// console.log(update_id);
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการเพิ่มส่วนลดหรือไม่?',
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
                        url: 'setting/discount/insert', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response == true){
                                Swal.fire('เพิ่มส่วนลดเรียบร้อยแล้ว', '', 'success');
                                $('#adddiscountModal').modal('hide');
                                loadDataDiscount(page);
                                getDiscount();
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
        $('#deleteService').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ

            var formData = $(this).serialize(); // ดึงค่าจาก form
            var update_ids_service = [];

            // ตรวจสอบ checkbox ที่ถูกเลือก
            $('input.ids_service:checked').each(function() {
                update_ids_service.push($(this).val());
            });

            if (update_ids_service.length === 0) {
                Swal.fire('โปรดเลือกค่าบริการที่ต้องการลบ', '', 'warning');
                return; // หยุดการทำงานถ้าไม่มี checkbox ถูกเลือก
            }

            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการลบค่าบริการหรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                didOpen: () => {
                    Swal.getConfirmButton().focus();
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'setting/service/delete_on_room', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'DELETE',
                        data: formData + '&' + $.param({ id: update_ids_service }), // รวมข้อมูล form + ID checkbox
                        success: function(response) {
                            // if (response == 1) {
                            //     Swal.fire('ลบค่าบริการเรียบร้อยแล้ว', '', 'success');
                            //     $('#deleteServiceModal').modal('hide');
                            //     loadData(page);
                            //     getService();
                            // } else {
                            //     Swal.fire('ไม่สามารถลบค่าบริการได้', '', 'error');
                            // }
                            location.reload();
                        },
                        error: function(error) {
                            Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                            console.error('เกิดข้อผิดพลาด:', error);
                        }
                    });
                }
            });
        });
        $('#deleteDiscount').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ

            var formData = $(this).serialize(); // ดึงค่าจาก form
            var update_ids_discount = [];

            // ตรวจสอบ checkbox ที่ถูกเลือก
            $('input.ids_discount:checked').each(function() {
                update_ids_discount.push($(this).val());
            });

            if (update_ids_discount.length === 0) {
                Swal.fire('โปรดเลือกส่วนลดที่ต้องการลบ', '', 'warning');
                return; // หยุดการทำงานถ้าไม่มี checkbox ถูกเลือก
            }

            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการลบส่วนลดหรือไม่?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'ตกลง',
                cancelButtonText: 'ยกเลิก',
                didOpen: () => {
                    Swal.getConfirmButton().focus();
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: 'setting/discount/delete_on_room', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'DELETE',
                        data: formData + '&' + $.param({ id: update_ids_discount }), // รวมข้อมูล form + ID checkbox
                        success: function(response) {
                            if (response == 1) {
                                Swal.fire('ลบส่วนลดเรียบร้อยแล้ว', '', 'success');
                                $('#deleteDiscountModal').modal('hide');
                                loadDataDiscount(page);
                                getDiscount();
                            } else {
                                Swal.fire('ไม่สามารถลบส่วนลดได้', '', 'error');
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


        function view_electric(id){
            $.ajax({
                type: "GET",
                url: "setting/service/"+id,
                success: function(data) {
                    $("#view_electric").html(data);
                    update_id = id;
                }
            });
        }
        
        $('#update_laundry').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            if(update_id == 'all'){
                var update_ids_service = [];
                
                // ตรวจสอบ checkbox ที่ถูกเลือก
                $('input.ids_discount:checked').each(function() {
                    update_ids_service.push($(this).val());
                });
                update_id = update_ids_service;
            }
// console.log(update_id);
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการแก้ไขค่าบริการหรือไม่?',
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
                        url: 'setting/service/room/update', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response == true){
                                Swal.fire('แก้ไขค่าบริการเรียบร้อยแล้ว', '', 'success');
                                $('#editserviceModal').modal('hide');
                                loadData(page);
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
        $('#update_discount').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            if(update_ids_discount== 'all'){
                var update_ids_discount = [];
                
                // ตรวจสอบ checkbox ที่ถูกเลือก
                $('input.ids_discount:checked').each(function() {
                    update_ids_discount.push($(this).val());
                });
                update_ids_discount= update_ids_discount;
            }
// console.log(update_id);
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการแก้ไขส่วนลดหรือไม่?',
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
                        url: 'setting/discount/room/update', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response == true){
                                Swal.fire('แก้ไขส่วนลดเรียบร้อยแล้ว', '', 'success');
                                $('#editdiscountModal').modal('hide');
                                loadDataDiscount(page);
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
        
        $('#selectpickerBuilding').change(function() {
                var building = $(this).val();
                
                // เคลียร์ dropdown สำหรับตำบล
                $('#selectpickerFloor').empty().append('<option value="all"> &nbsp; &nbsp; ทุกชั้น &nbsp; &nbsp; </option>');

                if (building) {
                    $.ajax({
                        url: '/get-floors/' + building,
                        type: 'GET',
                        success: function(data) {
                            data.forEach(function(floor) {
                                $('#selectpickerFloor').append('<option value="' + floor.id + '"> &nbsp; &nbsp; ' + floor.name + ' &nbsp; &nbsp; </option>');
                            });
                        }
                    });
                }
            });

        
        // window.onload = function() {
        //     $('#addserviceModal').modal('show');
        // };
        $('#bs-datepicker-format').datepicker({
            format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่
            autoclose: true,      // ปิด datepicker เมื่อเลือกวันที่
            todayHighlight: true  // ไฮไลต์วันที่ปัจจุบัน
        });
        $('#select2Position1').select2();

    </script>
    <script>
    $(document).ready(function() {
        $('input[type="radio"]').click(function() {
            var inputValue = $(this).attr("value");
            var targetBox = $("." + inputValue);
            $(".box").not(targetBox).hide();
            $(targetBox).show();
        });
    });
    
    $('#meter_water').on('click', function() {
        $('.nav-link').removeClass('active btn-danger');
        $('#meter_electricity').addClass('btn-label-danger');
        $(this).removeClass('btn-label-primary');
        $(this).addClass('active btn-primary');
    });
    $('#meter_electricity').on('click', function() {
        $('.nav-link').removeClass('active btn-primary');
        $('#meter_water').addClass('btn-label-primary');
        $(this).removeClass('btn-label-danger');
        $(this).addClass('active btn-danger');
    });
    </script>
</body>

</html>