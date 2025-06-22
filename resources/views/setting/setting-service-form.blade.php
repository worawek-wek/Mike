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
                                            <div class="col-sm-12">
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
                                        </div>
                                    </div>
                                    <div class="card-body pt-4">
                                        <div class="tab-content p-0">
                                            <div class="tab-pane fade show active" id="navs-pills-top-home"
                                                role="tabpanel">
                                                <div class="card shadow-none border-bottom rounded-0">
                                                    <div class="card-header px-0 px-md-4">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center flex-md-row flex-column">
                                                            <h4 class="mb-0">ชั้นที่ 1</h4>
                                                            <div>
                                                                <button type="button"
                                                                    class="btn btn-light-main">เลือกทั้งชั้น</button>
                                                                <button type="button" class="btn btn-label-warning"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#setServiceFeesModal">กำหนดค่าบริการ</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body px-0 px-md-4">
                                                        <div class="row g-3">
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check card-selected">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A101</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addserviceModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าบริการ</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A102</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addserviceModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าบริการ</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A103</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addserviceModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าบริการ</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A104</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addserviceModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าบริการ</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A105</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addserviceModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าบริการ</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A106</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addserviceModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าบริการ</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A107</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addserviceModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าบริการ</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A108</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addserviceModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าบริการ</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card shadow-none border-bottom rounded-0">
                                                    <div class="card-header px-0 px-md-4">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center flex-md-row flex-column">
                                                            <h4 class="mb-0">ชั้นที่ 2</h4>
                                                            <div>
                                                                <button type="button"
                                                                    class="btn btn-light-main">เลือกทั้งชั้น</button>
                                                                <button type="button" class="btn btn-label-warning"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#setServiceFeesModal">กำหนดค่าบริการ</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body px-0 px-md-4">
                                                        <div class="row g-3">
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check card-selected">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A201</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addserviceModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าบริการ</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A202</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addserviceModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าบริการ</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A203</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addserviceModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าบริการ</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A204</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addserviceModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าบริการ</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A205</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addserviceModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าบริการ</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A206</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addserviceModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าบริการ</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A207</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addserviceModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าบริการ</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A208</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ค่าอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editserviceModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#addserviceModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าบริการ</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                                                <div class="card shadow-none border-bottom rounded-0">
                                                    <div class="card-header px-0 px-md-4">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center flex-md-row flex-column">
                                                            <h4 class="mb-0">ชั้นที่ 1</h4>
                                                            <div>
                                                                <button type="button"
                                                                    class="btn btn-light-main">เลือกทั้งชั้น</button>
                                                                <button type="button" class="btn btn-label-warning"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#setDiscountFeesModal">กำหนดค่าส่วนลด</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body  px-0 px-md-4">
                                                        <div class="row g-3">
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check card-selected">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A101</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#adddiscountModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าส่วนลด</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div
                                                                    class="card bg-lightGray card-check shadow-sm card-selected">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A102</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#adddiscountModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าส่วนลด</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A103</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#adddiscountModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าส่วนลด</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A104</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#adddiscountModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าส่วนลด</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A105</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#adddiscountModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าส่วนลด</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A106</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#adddiscountModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าส่วนลด</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A107</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#adddiscountModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าส่วนลด</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A108</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#adddiscountModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าส่วนลด</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card shadow-none border-bottom rounded-0">
                                                    <div class="card-header  px-0 px-md-4">
                                                        <div
                                                            class="d-flex justify-content-between align-items-center flex-md-row flex-column">
                                                            <h4 class="mb-0">ชั้นที่ 2</h4>
                                                            <div>
                                                                <button type="button"
                                                                    class="btn btn-light-main">เลือกทั้งชั้น</button>
                                                                <button type="button" class="btn btn-label-warning"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#setDiscountFeesModal">กำหนดค่าส่วนลด</button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="card-body  px-0 px-md-4">
                                                        <div class="row g-3">
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check card-selected">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A201</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#adddiscountModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าส่วนลด</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A202</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#adddiscountModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าส่วนลด</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A203</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#adddiscountModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าส่วนลด</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A204</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#adddiscountModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าส่วนลด</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A205</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#adddiscountModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าส่วนลด</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A206</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#adddiscountModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าส่วนลด</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A207</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#adddiscountModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าส่วนลด</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-lg-3">
                                                                <div class="card bg-lightGray card-check shadow-sm">
                                                                    <div class="card-body text-center">
                                                                        <h5 class="card-title">A208</h5>
                                                                        <ul class="list-group list-group-flush mb-2">
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดซักผ้า</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดที่จอดรถ</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                            <li
                                                                                class="list-group-item d-flex justify-content-between align-items-center px-0 border-0 py-0">
                                                                                <span><i
                                                                                        class="ti ti-checkbox ti-xs text-main me-2"></i>ส่วนลดอินเตอร์เน็ต</span>
                                                                                <button type="button"
                                                                                    class="btn btn-icon btn-sm btn-label-secondary"
                                                                                    data-bs-toggle="modal"
                                                                                    data-bs-target="#editDiscountModal">
                                                                                    <span
                                                                                        class="ti ti-edit ti-xs"></span>
                                                                                </button>
                                                                            </li>
                                                                        </ul>
                                                                        <button type="button"
                                                                            class="btn btn-main btn-sm rounded-2"
                                                                            data-bs-toggle="modal"
                                                                            data-bs-target="#adddiscountModal"><i
                                                                                class="ti ti-plus ti-xs"></i>
                                                                            เพิ่มค่าส่วนลด</button>
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
    <!-- / Layout wrapper -->
    @include('layout/inc_js')
</body>

</html>