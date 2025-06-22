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
                                                    รายละเอียดหัวบิล
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
                                            <div class="row g-3">
                                                <div class="col-sm-12">
                                                    <label for="" class="form-label">ประเภทธุรกิจ<span
                                                            class="text-danger">*</span></label>
                                                    <select class="form-select" required>
                                                        <option>บุคคลธรรมดา</option>
                                                        <option></option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="" class="form-label">ชื่อบริษัท/ชื่อเต็ม<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="" placeholder=""
                                                        value="กิตตินคร" required />
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="" class="form-label">ที่อยู่</label>
                                                    <textarea rows="3"
                                                        class="form-control">333,333/4 ม.6 ซ.เจริญใจ ถ.เทพารักษ์ ตำบล เทพารักษ์ ต.เทพารักษ์ อ.เมืองสมุทรปราการ จ.สมุทรปราการ </textarea>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="" class="form-label">เลขประจำตัวผู้เสียภาษี</label>
                                                    <input type="text" class="form-control" id="" placeholder="" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">เบอร์โทร</label>
                                                    <input type="text" class="form-control" id="" placeholder="" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">อีเมล</label>
                                                    <input type="email" class="form-control" id="" placeholder="" />
                                                </div>
                                                <div class="col-sm-12 text-center">
                                                    <button type="submit" class="btn btn-main">บันทึก</button>
                                                </div>
                                            </div>
                                            <hr class="border-light my-4">
                                            <h4 class="text-center">ตั้งค่ารูปแบบเอกสาร</h4>
                                            <div class="card shadow-none bg-secondary-subtle">
                                                <div class="card-body">
                                                    <h5 class="card-title">
                                                        รูปแบบเอกสารสำหรับใบแจ้งและใบเสร็จรับเงิน</h5>
                                                    <div class="row">
                                                        <div class="col-sm-6">
                                                            <div class="row">
                                                                <div class="col-md mb-md-0 mb-5">
                                                                    <div
                                                                        class="form-check custom-option custom-option-icon checked">
                                                                        <label
                                                                            class="form-check-label custom-option-content"
                                                                            for="customRadioIcon1">
                                                                            <span class="custom-option-body">
                                                                                <div class="ratio ratio-1x1 mb-3">
                                                                                    <img src="https://images.pexels.com/photos/27659008/pexels-photo-27659008/free-photo-of-a-black-and-white-photo-of-a-mosque.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                                                                                        class="object-fit-contain"
                                                                                        alt="...">
                                                                                </div>
                                                                                <span
                                                                                    class="custom-option-title">ต้นฉบับ-สำเนาอยู่ใน
                                                                                    1 แผ่น</span>
                                                                            </span>
                                                                            <input name="customOptionRadioIcon"
                                                                                class="form-check-input" type="radio"
                                                                                value="" id="customRadioIcon1"
                                                                                checked="">
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md mb-md-0 mb-5">
                                                                    <div
                                                                        class="form-check custom-option custom-option-icon">
                                                                        <label
                                                                            class="form-check-label custom-option-content"
                                                                            for="customRadioIcon2">
                                                                            <span class="custom-option-body">
                                                                                <div class="ratio ratio-1x1 mb-3">
                                                                                    <img src="https://images.pexels.com/photos/27659008/pexels-photo-27659008/free-photo-of-a-black-and-white-photo-of-a-mosque.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                                                                                        class="object-fit-contain"
                                                                                        alt="...">
                                                                                </div>
                                                                                <span class="custom-option-title">
                                                                                    ต้นฉบับ-สำเนา 1 แผ่น </span>
                                                                            </span>
                                                                            <input name="customOptionRadioIcon"
                                                                                class="form-check-input" type="radio"
                                                                                value="" id="customRadioIcon2">
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 text-center">
                                                            <div class="ratio ratio-1x1 bg-white rounded">
                                                                <img src="https://images.pexels.com/photos/27659008/pexels-photo-27659008/free-photo-of-a-black-and-white-photo-of-a-mosque.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1"
                                                                    class="object-fit-contain border rounded" alt="...">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="text-center pt-4">
                                                <button type="submit" class="btn btn-main">บันทึก</button>
                                            </div>
                                            <hr class="border-light my-4">
                                            <h4 class="text-center">ตั้งค่าข้อความท้าย<span
                                                    class="text-main">ใบแจ้งหนี้</span></h4>
                                            <div id="full-editor"></div>
                                            <div class="text-center pt-4">
                                                <button type="submit" class="btn btn-main">บันทึก</button>
                                            </div>
                                            <hr class="border-light my-4">
                                            <h4 class="text-center">ตั้งค่ารูปแบบเอกสาร<span
                                                    class="text-main">ใบเสร็จจองห้องพัก</span></h4>
                                            <div id="full-editor"></div>
                                            <div class="text-center pt-4">
                                                <button type="submit" class="btn btn-main">บันทึก</button>
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