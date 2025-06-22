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
                                                    <i class="tf-icons ti ti-door text-main ti-md"></i>
                                                    กำหนดค่าเช่าห้อง
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row border-bottom border-top border-light p-3">
                                        <div class="col-lg-4">
                                            <div class="d-flex align-items-center mb-2 mb-md-0">
                                                <label class="">Show</label>
                                                <select name="limit" class="form-select ms-2 me-2 p_search" style="width:100px" onchange='loadData("{{$page_url}}/datatable")'>
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="75">75</option>
                                                    <option value="100">100</option>
                                                </select>
                                                <ul class="nav nav-pills" id="pills-tablayout" role="tablist">
                                                    <li class="nav-item me-1" role="presentation">
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-label-secondary waves-effect active"
                                                            id="pills-home-tab" data-bs-toggle="pill"
                                                            data-bs-target="#pills-home" type="button" role="tab"
                                                            aria-controls="pills-home" aria-selected="true">
                                                            <span class="ti ti-layout-grid ti-md"></span>
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button type="button"
                                                            class="btn btn-icon btn-sm btn-label-secondary waves-effect"
                                                            data-bs-toggle="pill" data-bs-target="#pills-profile"
                                                            type="button" role="tab" aria-controls="pills-profile"
                                                            aria-selected="false">
                                                            <span class="ti ti-list ti-md"></span>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-lg-8">
                                            <div class="d-flex justify-content-end flex-column flex-md-row">
                                                {{-- <div class="col-md-2 select_off" style="padding-right: unset !important;"> --}}
                                                <select onchange='loadData("{{$page_url}}/datatable")' name="building" id="selectpickerBuilding" class="select2 form-select form-select-lg p_search" data-style="btn-default">
                                                        <option value="all"> &nbsp; &nbsp; ทุกตึก &nbsp; &nbsp; </option>
                                                        @foreach ($buildings as $b)
                                                            <option value="{{ $b->id }}"> &nbsp; &nbsp; {{ $b->name }} &nbsp; &nbsp; </option>
                                                        @endforeach
                                                </select>
                                                {{-- </div> --}}
                                                <!-- Group -->
                                                {{-- <div class="col-md-2 select_off" style="padding-right: unset !important;"> --}}
                                                <select onchange='loadData("{{$page_url}}/datatable")' name="floor" id="selectpickerFloor" class="select2 form-select form-select-lg p_search" data-style="btn-default">
                                                        <option value="all"> &nbsp; &nbsp; ทุกชั้น &nbsp; &nbsp; </option>
                                                        @foreach ($floors as $f)
                                                            <option value="{{ $f->id }}"> &nbsp; &nbsp; {{ $f->name }} &nbsp; &nbsp; </option>
                                                        @endforeach
                                                </select>
                                                {{-- </div> --}}
                                                <button
                                                    id="edit-rent"
                                                    type="button"
                                                    class="btn btn-main waves-effect waves-light me-md-2 mb-2 mb-md-0"
                                                    data-bs-toggle="modal" data-bs-target="#editModal" onclick="view('all')">
                                                    <span class="ti-xs ti ti-cash-banknote me-2"></span>กำหนดค่าเช่า
                                                </button>
                                                <button type="button"
                                                    class="btn btn-label-info waves-effect waves-light text-dark">
                                                    <span class="ti-xs ti ti-list-check me-2"></span>เลือกทั้งชั้น
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body px-0 pt-0">
                                        <div class="tab-content p-0" id="table-data">
                                            {{-- @include('setting/setting-roomRent-table') --}}
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
    <div class="modal fade modalHeadDecor" id="editModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg  modal-dialog-scrollable" role="document">
            <div class="modal-content rounded-0">
                <form id="update_room">
                    @csrf
                    <div class="modal-header rounded-0">
                        <h5 class="modal-title" id="exampleModalLabel1">กำหนดค่าเช่า</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body" id="view">
                        
                    </div>
                    <div class="modal-footer rounded-0 justify-content-center">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                        <button type="submit" class="btn btn-main">บันทึก</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

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
        var update_id = 999999999999;
        function view(id){
            $.ajax({
                type: "GET",
                url: "{{ $page_url }}/"+id,
                success: function(data) {
                    $("#view").html(data);
                    update_id = id;
                }
            });
        }
        
        $('#update_room').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            if(update_id == 'all'){
                var update_ids = [];
                
                // ตรวจสอบ checkbox ที่ถูกเลือก
                $('input.ids:checked').each(function() {
                    update_ids.push($(this).val());
                });
                update_id = update_ids;
            }
console.log(update_id);
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการแก้ไขค่าห้องหรือไม่?',
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
                        url: '{{$page_url}}/update/'+update_id, // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response == true){
                                Swal.fire('แก้ไขค่าห้องเรียบร้อยแล้ว', '', 'success');
                                $('#editModal').modal('hide');
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
    </script>

</body>

</html>