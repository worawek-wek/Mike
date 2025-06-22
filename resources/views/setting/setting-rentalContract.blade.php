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
                                        <form id="form_submit">
                                        @csrf
                                            <h4>คลิกเพื่อใส่ข้อมูล</h4>
                                            <div class="mb-3 d-flex gap-2 flex-wrap">
                                                <button type="button" data-text="{ชื่อหอพัก}" class="btn btn-outline-secondary waves-effect addCondition">ชื่อหอพัก</button>
                                                <button type="button" data-text="{ที่อยู่หอพัก}" class="btn btn-outline-secondary waves-effect addCondition">ที่อยู่หอพัก</button>
                                                <button type="button" data-text="{วันที่ปัจจุบัน}" class="btn btn-outline-secondary waves-effect addCondition">วันที่ปัจจุบัน</button>
                                                <button type="button" data-text="{เดือน/ปีปัจจุบัน}" class="btn btn-outline-secondary waves-effect addCondition">เดือน/ปีปัจจุบัน</button>
                                                <button type="button" data-text="{ชื่อผู้เช่า}" class="btn btn-outline-secondary waves-effect addCondition">ชื่อผู้เช่า</button>
                                                <button type="button" data-text="{หมายเลขบัตรประชาชนผู้เช่า}" class="btn btn-outline-secondary  waves-effect addCondition">หมายเลขบัตรประชาชนผู้เช่า</button>
                                                <button type="button" data-text="{เบอร์โทรผู้เช่า}" class="btn btn-outline-secondary  waves-effect addCondition">เบอร์โทรผู้เช่า</button>
                                                <button type="button" data-text="{หมายเลขห้องพัก}" class="btn btn-outline-secondary  waves-effect addCondition">หมายเลขห้องพัก</button>
                                                <button type="button" data-text="{หมายเลขชั้นของห้องพัก}" class="btn btn-outline-secondary  waves-effect addCondition">หมายเลขชั้นของห้องพัก</button>
                                                <button type="button" data-text="{ระยะเวลาสัญญา}" class="btn btn-outline-secondary  waves-effect addCondition">ระยะเวลาสัญญา</button>
                                                <button type="button" data-text="{วันที่เริ่มต้นสัญญา}" class="btn btn-outline-secondary  waves-effect addCondition">วันที่เริ่มต้นสัญญา</button>
                                                <button type="button" data-text="{วันที่สิ้นสุดสัญญา}" class="btn btn-outline-secondary  waves-effect addCondition">วันที่สิ้นสุดสัญญา</button>
                                                <button type="button" data-text="{เงินประกันห้อง}" class="btn btn-outline-secondary  waves-effect addCondition">เงินประกันห้อง</button>
                                                <button type="button" data-text="{ค่าเช่าห้อง}" class="btn btn-outline-secondary  waves-effect addCondition">ค่าเช่าห้อง</button>
                                                <button type="button" data-text="{ค่าเช่าเฟอร์นิเจอร์}" class="btn btn-outline-secondary  waves-effect addCondition">ค่าเช่าเฟอร์นิเจอร์</button>
                                                <button type="button" data-text="{ค่าเช่าห้องไม่รวมค่าเฟอร์นิเจอร์}" class="btn btn-outline-secondary  waves-effect addCondition">ค่าเช่าห้องไม่รวมค่าเฟอร์นิเจอร์</button>
                                                <button type="button" data-text="{วันที่สิ้นสุดการชำระเงิน}" class="btn btn-outline-secondary  waves-effect addCondition">วันที่สิ้นสุดการชำระเงิน</button>
                                                <button type="button" data-text="{เลขมิเตอร์ไฟฟ้าเข้าพัก}" class="btn btn-outline-secondary  waves-effect addCondition">เลขมิเตอร์ไฟฟ้าเข้าพัก</button>
                                                <button type="button" data-text="{เลขมิเตอร์น้ำเข้าพัก}" class="btn btn-outline-secondary  waves-effect addCondition">เลขมิเตอร์น้ำเข้าพัก</button>
                                                <button type="button" data-text="{ลายเซนต์ผู้เช่า}" class="btn btn-outline-secondary  waves-effect addCondition">ลายเซนต์ผู้เช่า</button>
                                            </div>
                                            <div id="full-editor">{!!@$data->detail!!}</div>
                                            <input type="hidden" name="detail" id="detail" value="{{@$data->detail}}">

                                            {{-- <div class="row">
                                                <div class="col-xs-12">
                                                  <button class="btn btn-blue" type="button" name="button" ng-click="printSampleContract(htmlString)">
                                                    <i class="fa fa-print"></i> พิมพ์ตัวอย่าง
                                                  </button>
                                                  <button class="btn btn-green pull-right" type="button" name="button" ng-click="saveContractHtml(htmlString)">
                                                    <i class="fa fa-print"></i> บันทึกสัญญา
                                                  </button>
                                                  <button class="btn btn-default pull-right" style="margin-right:5px" type="button" name="button" ng-click="resetContract()">
                                                    กลับสู่สัญญาเริ่มต้น
                                                  </button>
                                                </div>
                                              </div> --}}

                                            <div class="row mt-3">
                                                <div class="col-md-10"><button type="button" class="btn btn-warning" onclick="print_show();"><i class="fa fa-print me-2"></i>พิมพ์ตัวอย่าง</button></div>
                                                <div class="col-md-2 text-end">
                                                    <button type="button" class="btn btn-main" onclick="check_add();"><i class="ti-xs ti ti-device-floppy me-2"></i>บันทึกแก้ไข</button>
                                                </div>
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
        function generatePlaceholdersFromButtons() {
            const placeholders = {};
            document.querySelectorAll('.addCondition').forEach(button => {
                const key = button.getAttribute('data-text');
                placeholders[key] = getPlaceholderValue(key);
            });
            return placeholders;
        }
        function getPlaceholderValue(key) {
            const now = new Date();
            const options = { year: 'numeric', month: '2-digit', day: '2-digit' };

            switch (key) {
                case '{ชื่อหอพัก}': return 'หอพัก  Orange';
                case '{ที่อยู่หอพัก}': return '32/1 ถ. จรัญสนิทวงศ์ แขวงบางอ้อ บางพลัด กรุงเทพมหานคร 10700';
                case '{วันที่ปัจจุบัน}': return now.toLocaleDateString('th-TH', options);
                case '{เดือน/ปีปัจจุบัน}': return now.toLocaleDateString('th-TH', { year: 'numeric', month: 'long' });
                case '{ชื่อผู้เช่า}': return 'นายพิพัฒน์';
                case '{หมายเลขบัตรประชาชนผู้เช่า}': return '0000000000';
                case '{เบอร์โทรผู้เช่า}': return '02-424-555-9';
                case '{หมายเลขห้องพัก}': return 'ชั้น 3';
                case '{หมายเลขชั้นของห้องพัก}': return '3';
                case '{ระยะเวลาสัญญา}': return '12 เดือน';
                case '{วันที่เริ่มต้นสัญญา}': return '1 มกราคม 2568';
                case '{วันที่สิ้นสุดสัญญา}': return '31 ธันวาคม 2568';
                case '{เงินประกันห้อง}': return '5,000 บาท';
                case '{ค่าเช่าห้อง}': return '7,500 บาท';
                case '{ค่าเช่าเฟอร์นิเจอร์}': return '1,000 บาท';
                case '{ค่าเช่าห้องไม่รวมค่าเฟอร์นิเจอร์}': return '6,500 บาท';
                case '{วันที่สิ้นสุดการชำระเงิน}': return '5 มกราคม 2568';
                case '{เลขมิเตอร์ไฟฟ้าเข้าพัก}': return '0000';
                case '{เลขมิเตอร์น้ำเข้าพัก}': return '0000';
                case '{ลายเซนต์ผู้เช่า}': return '(พิพัฒน์)';
                default: return key; 
            }
        }
        function replacePlaceholders(content, map) {
            for (const key in map) {
                const regex = new RegExp(key.replace(/[.*+?^${}()|[\]\\]/g, '\\$&'), 'g');
                content = content.replace(regex, map[key]);
            }
            return content;
        }
        function print_show() {
            const content = document.getElementById('detail').value;
            const placeholders = generatePlaceholdersFromButtons();
            const replacedContent = replacePlaceholders(content, placeholders);
            const printWindow = window.open('', '', 'width=800,height=600');

            printWindow.document.open();
            printWindow.document.write(`
                <html>
                    <head>
                        <title>พิมพ์ตัวอย่าง</title>
                        <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
                        <link href="https://fonts.googleapis.com/css2?family=Sarabun&display=swap" rel="stylesheet">
                        <style>
                            @page {
                                size: A4;
                                margin: 20mm;
                            }
                            body {
                                font-family: 'Sarabun', sans-serif;
                                font-size: 14pt;
                                padding: 20px;
                                line-height: 1.6;
                            }

                            .ql-align-center {
                                text-align: center;
                            }
                            .ql-align-right {
                                text-align: right;
                            }
                            .ql-align-left {
                                text-align: left;
                            }

                            /* เพิ่ม margin ให้ element ภายใน */
                            p {
                                margin: 0 0 10px;
                            }
                        </style>
                    </head>
                    <body onload="window.print(); window.close();">
                        ${replacedContent}
                    </body>
                </html>
            `);
            printWindow.document.close();
        }
        function check_add() {
            var formData = new FormData($("#form_submit")[0]);
            event.preventDefault(); 
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการแก้ไขค่าห้องหรือไม่?',
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
                        url: 'setting/rental-contract', 
                        type: 'POST',
                        data: formData,
						processData: false,
						contentType: false,
						dataType: 'json',
                        success: function(response) {
                            location.href = "setting/rental-contract";
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
            document.getElementById('detail').value = fullEditor.root.innerHTML;
        });

        function insertTextAtCursor(text) {
            const cursorPosition = fullEditor.getSelection()?.index || 0;
            fullEditor.insertText(cursorPosition, text);
            fullEditor.setSelection(cursorPosition + text.length);
        }

        document.querySelectorAll('.addCondition').forEach(button => {
            button.addEventListener('click', function () {
                const textToInsert = this.getAttribute('data-text');
                insertTextAtCursor(textToInsert);
            });
        });
    </script>

</body>

</html>