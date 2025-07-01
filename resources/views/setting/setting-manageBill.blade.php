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
                                        <form id="form_submit">
                                        @csrf
                                            <div class="row g-3">
                                                <div class="col-sm-12">
                                                    <label for="" class="form-label">ประเภทธุรกิจ<span class="text-danger">*</span></label>
                                                    <select id="type" name="type" class="form-select" required>
                                                        <option value="0" @if(@$data->type == 0) selected @endif>บุคคลธรรมดา</option>
                                                        <option value="1" @if(@$data->type == 1) selected @endif>นิติบุคคล</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="" class="form-label">ชื่อบริษัท/ชื่อเต็ม<spanclass="text-danger">*</span></label>
                                                    <input type="text" class="form-control" id="company_name" name="company_name" placeholder="" value="{{@$data->company_name}}" required />
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="" class="form-label">ที่อยู่</label>
                                                    <textarea rows="3" id="address" name="address" class="form-control">{{@$data->address}}</textarea>
                                                </div>
                                                <div class="col-sm-12">
                                                    <label for="" class="form-label">เลขประจำตัวผู้เสียภาษี</label>
                                                    <input type="text" class="form-control" id="tax_no" name="tax_no" value="{{@$data->tax_no}}" placeholder="" />
                                                </div>
                                                <div class="col-sm-6">
                                                    <label for="" class="form-label">เบอร์โทร</label>
                                                    <input type="text" class="form-control" id="phone" name="phone" value="{{@$data->phone}}" placeholder="" />
                                                </div>
                                                <div class="col-sm-6">
                                                    {{-- <label for="" class="form-label">อีเมล</label> --}}
                                                    <input type="hidden" class="form-control" id="email" name="email" value="{{@$data->email}}" placeholder="" />
                                                </div>
                                                {{-- <div class="col-sm-12 text-center">
                                                    <button type="submit" class="btn btn-main">บันทึก</button>
                                                </div> --}}
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
                                                                @php 
                                                                $image1 = "/image_bill/invoice_ex_1.png";
                                                                $image2 = "/image_bill/invoice_ex_2.png";
                                                                $image_show = $image1;
                                                                if(@$data->type_doc == 0){
                                                                    $image_show = $image1;
                                                                }else{
                                                                    $image_show = $image2;
                                                                }
                                                                @endphp
                                                                <div class="col-md mb-md-0 mb-5">
                                                                    <div
                                                                        class="form-check custom-option custom-option-icon checked">
                                                                        <label
                                                                            class="form-check-label custom-option-content"
                                                                            for="customRadioIcon1">
                                                                            <span class="custom-option-body">
                                                                                <div class="ratio ratio-1x1 mb-3">
                                                                                    <img src="{{@$image1}}" class="object-fit-contain" alt="...">
                                                                                </div>
                                                                                <span class="custom-option-title">ต้นฉบับ-สำเนาอยู่ใน 1 แผ่น</span>
                                                                            </span>
                                                                            <input class="form-check-input" data-image="{{@$image1}}" type="radio" value="0" id="customRadioIcon1" name="type_doc" @if(@$data->type_doc == 0) checked @endif>
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                {{-- <div class="col-md mb-md-0 mb-5">
                                                                    <div
                                                                        class="form-check custom-option custom-option-icon">
                                                                        <label
                                                                            class="form-check-label custom-option-content"
                                                                            for="customRadioIcon2">
                                                                            <span class="custom-option-body">
                                                                                <div class="ratio ratio-1x1 mb-3">
                                                                                    <img src="{{@$image2}}" class="object-fit-contain" alt="...">
                                                                                </div>
                                                                                <span class="custom-option-title"> ต้นฉบับ-สำเนา 1 แผ่น </span>
                                                                            </span>
                                                                            <input class="form-check-input" type="radio" data-image="{{@$image2}}" value="1" id="customRadioIcon2" name="type_doc" @if(@$data->type_doc == 1) checked @endif>
                                                                        </label>
                                                                    </div>
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                        {{-- <div class="col-sm-6 text-center">
                                                            <div class="ratio ratio-1x1 bg-white rounded">
                                                                <img id="previewImage" src="{{@$image_show}}" class="object-fit-contain border rounded" alt="...">
                                                            </div>
                                                        </div> --}}
                                                    </div>
                                                </div>
                                            </div>
                                            {{-- <div class="text-center pt-4">
                                                <button type="submit" class="btn btn-main">บันทึก</button>
                                            </div> --}}


                                            <hr class="border-light my-4">
                                           <div class="" hidden>
                                            <h4 class="text-center">ตั้งค่าข้อความท้าย<span class="text-main">ใบแจ้งหนี้</span></h4>
                                            <div id="full-editor">{!!@$data->detail_footer!!}</div>
                                            <input type="hidden" name="detail_footer" id="detail_footer" value="{{@$data->detail_footer}}">
                                           </div>
                                            
                                            {{-- <div class="text-center pt-4">
                                                <button type="submit" class="btn btn-main">บันทึก</button>
                                            </div> --}}
                                            <hr class="border-light my-4">
                                            <h4 class="text-center">ตั้งค่ารูปแบบเอกสาร<span class="text-main">ใบเสร็จจองห้องพัก</span></h4>
                                            <div id="full-editor1">{!!@$data->detail_doc!!}</div>
                                            <input type="hidden" name="detail_doc" id="detail_doc" value="{{@$data->detail_doc}}">
                                            <div class="text-center pt-4">
                                                <button type="button" onclick="check_add();" class="btn btn-main">บันทึก</button>
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
    document.addEventListener("DOMContentLoaded", function () {
        const radios = document.querySelectorAll('input[name="type_doc"]');
        const preview = document.getElementById('previewImage');
        radios.forEach(radio => {
            radio.addEventListener('change', function () {
                const imageUrl = this.dataset.image;
                preview.src = imageUrl;
            });
            if (radio.checked) {
                preview.src = radio.dataset.image;
            }
        });
    });
    function check_add() {
        var formData = new FormData($("#form_submit")[0]);
        event.preventDefault(); 
        Swal.fire({
            title: 'ยืนยันการดำเนินการ?',
            text: 'คุณต้องการแก้ไขรายการตั้งค่าบิลใช่หรือไม่?',
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
                $.ajax({
                    url: 'setting/manage-bill', 
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'json',
                    success: function(response) {
                        location.href = "setting/manage-bill";
                    },
                    error: function(error) {
                        Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                        console.error('เกิดข้อผิดพลาด:', error);
                    }
                });
            } else if (result.isDismissed) {
            }
        });
    }
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
    fullEditor.on('text-change', function () {
        document.getElementById('detail_footer').value = fullEditor.root.innerHTML;
    });

    const fullEditor1 = new Quill('#full-editor1', {
        bounds: '#full-editor1',
        placeholder: 'Type Something...',
        modules: {
            formula: true,
            toolbar: fullToolbar
        },
        theme: 'snow'
    });
    fullEditor1.on('text-change', function () {
        document.getElementById('detail_doc').value = fullEditor.root.innerHTML;
    });
    </script>

</body>

</html>