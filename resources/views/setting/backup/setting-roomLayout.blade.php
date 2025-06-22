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
                                            <div class="col-sm-6">
                                                <h4 class="mb-0">
                                                    <i class="tf-icons ti ti-layout-board-split text-main ti-md"></i>
                                                    ตั้งค่าผังห้อง
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
                                        {{-- <h2>ฟอร์มอัปโหลดไฟล์</h2>
                                        <form action="/insert_all" method="POST" enctype="multipart/form-data">
                                            @csrf
                                            <label for="file">เลือกไฟล์:</label>
                                            <input type="file" id="file" name="file">
                                            <br><br>
                                            <button type="submit">อัปโหลดไฟล์</button>
                                        </form> --}}
                                        {{-- <form> --}}
                                            <form id="inser_building">
                                                @csrf
                                                <div class="row mt-4">
                                                    <div class="col-sm-3"></div>
                                                    <div class="col-sm-4">
                                                        <input name="name" type="text" class="form-control" placeholder="เพิ่มตึก" required />
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="addFloor">
                                                            <button type="submit" class="btn btn-light-main me-2">
                                                                <i class="ti-xs ti ti-plus me-2"></i>เพิ่มตึก</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>
                                            <div id="building">

                                            </div>
                                        {{-- </form> --}}
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
    <script>
        
        loadData();
        
        function loadData(){
            // alert(page);
            $.ajax({
                type: "GET",
                url: "/setting/room-layout/building",
                success: function(data) {
                    $("#building").html(data);
                }
            });
            // alert(page);
        }
        $('#inser_building').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการเพิ่มตึกหรือไม่?',
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
                        url: '/setting/room-layout/building', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response == true){
                                $('#inser_building')[0].reset();
                                Swal.fire('เพิ่มตึกเรียบร้อยแล้ว', '', 'success');
                                $('#addserviceModal').modal('hide');
                                loadData();
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
        
    </script>
</body>

</html>