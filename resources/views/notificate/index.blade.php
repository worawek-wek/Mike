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
                                                    <i class="tf-icons ti ti-copy text-main ti-md me-2"></i>
                                                    สรุปการแจ้ง
                                                </h4>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="row">
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                                                            <input
                                                            name="search"
                                                            type="text"
                                                            class="form-control p_search"
                                                            placeholder="ค้นหาคีเวิร์ดที่ต้องการ"
                                                            aria-label="ค้นหาคีเวิร์ดที่ต้องการ"
                                                            aria-describedby="basic-addon-search31" />
                                                        </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="card-body">
                                        <div class="tab-content p-0">
                                            <div class="tab-pane fade show active" id="navs-pills-top-home"
                                                role="tabpanel">
                                                <div class="row p-3">
                                                    <div class="col-lg-4">
                                                        <div class="d-flex align-items-center mb-2 mb-md-0">
                                                            <label class="">Show</label>
                                                            <select onchange='loadData("{{$page_url}}/datatable")' name="limit" class="form-select ms-2 me-2 p_search" style="width:100px">
                                                                <option value="5">5</option>
                                                                <option value="10">10</option>
                                                                <option value="15">15</option>
                                                                <option value="20">20</option>
                                                                <option value="100">100</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-8 flex text-end" style="padding-right: unset !important;">
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
                                                        <button
                                                                style="padding-right: 14px;padding-left: 14px;margin-right: 0px;"
                                                                class="btn btn-success buttons-collection  btn-info waves-effect waves-light"
                                                                tabindex="0" aria-controls="DataTables_Table_0"
                                                                type="button" aria-haspopup="dialog"
                                                                aria-expanded="false" data-bs-toggle="modal" data-bs-target="#addserviceModal">
                                                            <span><i class="ti ti-plus"></i> เพิ่มประวัติผู้เช่า</span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body px-0 pt-0">
                                                    <div class="tab-content p-0" id="pills-tabContent">
                                                        <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                                                            aria-labelledby="pills-profile-tab" tabindex="0">

                                                            <div id="table-data">

                                                                {{-- ตารางอยู่ตรงนี้นะจ๊ะ --}}

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
                    <h5 class="modal-title" id="exampleModalLabel1">&nbsp;เพิ่มการแจ้งเตือน</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="insert_user">		
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3 p-4">
                            <div class="form-check mt-3">
                            <input
                                name="default-radio-1"
                                class="form-check-input"
                                type="radio"
                                value=""
                                id="defaultRadio1"
                                checked />
                            <label class="form-check-label" for="defaultRadio1"> การแจ้งซ่อม </label>
                            </div>
                            <div class="form-check">
                            <input
                                name="default-radio-1"
                                class="form-check-input"
                                type="radio"
                                value=""
                                id="defaultRadio2"/>
                            <label class="form-check-label" for="defaultRadio2"> อื่น ๆ </label>
                            </div>

                            <div class="col-sm-6">
                                <label for="" class="form-label">เลือกห้อง</label>
                                <select name="ref_room_id" id="select2Position1" class="select2 form-select form-select-lg" data-allow-clear="true">
                                    @foreach ($room as $ro)
                                        <option value="{{$ro->id}}">{{$ro->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div class="col-sm-12">
                                <label for="" class="form-label">เรื่องที่แจ้ง</label>
                                <input name="detail" class="form-control">
                            </div>

                            <div class="col-sm-12">
                                <label for="" class="form-label">รายละเอียด</label>
                                <textarea name="detail" class="form-control"></textarea>
                            </div>

                            <div class="col-sm-10 mt-3">
                                <label for="evidence_of_money_transfer">แนบหลักฐานการโอน</label>
                                <input type="file" class="form-control mb-2" id="evidence_of_money_transfer" name="evidence_of_money_transfer">
                                <div class="preview-container">
                                    <img id="preview_evidence_of_money_transfer" src="" alt="Preview 1" style="display: none; width:30%">
                                </div>
                            </div>

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
    
    <!--set rent Modal -->
    
    <!-- / Layout wrapper -->
    @include('layout/inc_js')
    <script>
        var page = "{{$page_url}}/datatable";
        var searchData = {};
        loadData(page);
        
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
                    $("#table-data").html(data);
                }
            });
            // alert(page);
        }

        function view(id){
            $.ajax({
                type: "GET",
                url: "{{ $page_url }}/"+id,
                success: function(data) {
                    $("#view").html(data);
                }
            });
        }

        $('#insert_user').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการเพิ่มประวัติหรือไม่?',
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
                        url: '{{$page_url}}', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response == true){
                                $('#insert_user')[0].reset();
                                Swal.fire('เพิ่มประวัติเรียบร้อยแล้ว', '', 'success');
                                $('#addserviceModal').modal('hide');
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

        function handleFileInput(fileInputId, previewId) {
            const fileInput = document.getElementById(fileInputId);
            const previewImage = document.getElementById(previewId);

            fileInput.addEventListener('change', function () {
                const file = fileInput.files[0];

                if (file) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        previewImage.src = e.target.result;
                        previewImage.style.display = 'block';  // แสดงภาพพรีวิว
                    };

                    reader.readAsDataURL(file);
                } else {
                    previewImage.style.display = 'none'; // ซ่อนพรีวิวถ้าไม่ได้เลือกไฟล์
                }
            });
        }
        handleFileInput('evidence_of_money_transfer', 'preview_evidence_of_money_transfer');
        
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
</body>

</html>