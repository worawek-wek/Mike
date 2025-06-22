<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template">

<head>
    @include('layout/inc_header')
    <title>Dashboard - CRM | Vuexy - Bootstrap Admin Template</title>
    <link rel="stylesheet" href="assets/vendor/libs/quill/typography.css" />
    <link rel="stylesheet" href="assets/vendor/libs/quill/katex.css" />
    <link rel="stylesheet" href="assets/vendor/libs/quill/editor.css" />
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
                                            <div class="col-sm-6">
                                                <h4 class="mb-0">
                                                    <i class="tf-icons ti ti-news text-main ti-md"></i>
                                                    สัญญาเช่า
                                                </h4>
                                            </div>
                                            <!-- <div class="col-sm-6 text-end">
                                                <button type="button" class="btn btn-main waves-effect waves-light"
                                                    data-bs-toggle="modal" data-bs-target="#addModal"><i
                                                        class="ti-xs ti ti-plus me-2"></i>เพิ่มบัญชี</button>
                                            </div> -->
                                        </div>
                                    </div>
                                    <div class="card-body pt-4">
                                        <form>
                                            <h4>คลิกเพื่อใส่ข้อมูล</h4>
                                            <div class="mb-3 d-flex gap-2 flex-wrap">
                                                <button type="button"
                                                    class="btn btn-outline-secondary waves-effect">ชื่อหอพัก</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary waves-effect">ที่อยู่หอพัก</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary waves-effect">วันที่ปัจจุบัน</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary waves-effect">เดือน/ปีปัจจุบัน</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary waves-effect">ชื่อผู้เช่า</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">หมายเลขบัตรประชาชนผู้เช่า</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">เบอร์โทรผู้เช่า</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">หมายเลขห้องพัก</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">หมายเลขชั้นของห้องพัก</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">ระยะเวลาสัญญา</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">วันที่เริ่มต้นสัญญา</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">วันที่สิ้นสุดสัญญา</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">เงินประกันห้อง</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">ค่าเช่าห้อง</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">ค่าเช่าเฟอร์นิเจอร์</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">ค่าเช่าห้องไม่รวมค่าเฟอร์นิเจอร์</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">วันที่สิ้นสุดการชำระเงิน</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">เลขมิเตอร์ไฟฟ้าเข้าพัก</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">เลขมิเตอร์น้ำเข้าพัก</button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary  waves-effect">ลายเซนต์ผู้เช่า</button>
                                            </div>
                                            <div id="full-editor"></div>
                                            <div class="addFloor text-center pt-4">
                                                <button type="button" class="btn btn-main"><i
                                                        class="ti-xs ti ti-device-floppy me-2"></i>บันทึกแก้ไข</button>
                                            </div>
                                        </form>
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
    <script src="assets/vendor/libs/quill/katex.js"></script>
    <script src="assets/vendor/libs/quill/quill.js"></script>
    <script>
        const fullToolbar = [
            [{
                    font: []
                },
                {
                    size: []
                }
            ],
            ['bold', 'italic', 'underline', 'strike'],
            [{
                    color: []
                },
                {
                    background: []
                }
            ],
            [{
                    script: 'super'
                },
                {
                    script: 'sub'
                }
            ],
            [{
                    header: '1'
                },
                {
                    header: '2'
                },
                'blockquote',
                'code-block'
            ],
            [{
                    list: 'ordered'
                },
                {
                    list: 'bullet'
                },
                {
                    indent: '-1'
                },
                {
                    indent: '+1'
                }
            ],
            [
                'direction',
                {
                    align: []
                }
            ],
            ['link', 'image', 'video', 'formula'],
            ['clean']
        ];

        const fullEditor = new Quill('#full-editor', {
            bounds: '#full-editor',
            placeholder: 'Type Something...',
            modules: {
                formula: true,
                toolbar: fullToolbar
            },
            theme: 'snow'
        });
    </script>

</body>

</html>