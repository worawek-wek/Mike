<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template">

<head>
    @include('layout/inc_header')
    <title>Dashboard - CRM | Vuexy - Bootstrap Admin Template</title>
</head>
<style>
    .new_box .col-md-6 {
        padding: 5px 12px;
    }
    .table th {
        font-size: 15px;
        font-weight: bold;
    }
    /* .table td {
        padding-top: 14px;
        padding-bottom: 14px;
    } */
    .modalHeadDecor .modal-header {
        padding: 0;
    }

    .modalHeadDecor .modal-title {
        padding: 1.25rem 0.5rem 1.25rem 1.25rem;
        color: white;
        background-color: #54BAB9;
        position: relative;
    }

    .modalHeadDecor .modal-title::after {
        position: absolute;
        top: 0;
        right: -64px;
        content: '';
        width: 0;
        height: 0;
        border-top: 67px solid #54BAB9;
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
                                    <div class="card-header">
                                        <div class="row g-3 justify-content-between">
                                            <div class="col-sm-12">
                                                <h4 class="mb-0">
                                                    <i class="tf-icons ti ti-sitemap text-main ti-xl" style="margin-right: 10px;"></i>
                                                    เลือกรอบบิล
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-header row pt-0 g-3">
                                        <div class="col-sm-5 col-lg-5 text-warning">
                                            <div class="card card-border-shadow-warning">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center pb-1">
                                                        <h4 class="ms-1 mb-0 text-warning" id="confirm_by_employee">
                                                        </h4>
                                                    </div>
                                                    <h5 class="mb-0 d-flex">รอคอนเฟิร์ม
                                                        <button type="button"
                                                            class="btn btn-main btn-sm rounded-2 ms-auto"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editserviceModal"
                                                            onclick="waitingForConfirmation()">
                                                            รายละเอียด
                                                        </button>
                                                    </h5>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-sm-5 col-lg-5">
                                            <div class="card card-border-shadow-success">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center pb-1">
                                                        <h4 class="ms-1 mb-0 text-success" id="confirm_by_ceo">
                                                        </h4>
                                                    </div>
                                                    <h5 class="mb-0">ยอดในบัญชี</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-5 col-lg-5">
                                            <div class="card card-border-shadow-success">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center pb-1">
                                                        <h4 class="ms-1 mb-0 text-success" id="transfer">
                                                            0.00 บาท
                                                        </h4>
                                                    </div>
                                                    <h5 class="mb-0">โอนเงิน</h5>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-5 col-lg-5 text-warning">
                                            <div class="card card-border-shadow-warning">
                                                <div class="card-body">
                                                    <div class="d-flex align-items-center pb-1">
                                                        <h4 class="ms-1 mb-0 text-warning" id="cash" >
                                                            0.00 บาท
                                                        </h4>
                                                    </div>
                                                    <h5 class="mb-0">เงินสด</h5>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row border-bottom border-light p-3">
                                        <div class="row">
                                                <div class="col-md-3" style="padding-right: unset !important;">
                                                    <select onchange='loadData("{{$page_url}}/datatable")' name="ref_status_id" id="selectpickerStatus" class="select2 form-select form-select-lg p_search" data-style="btn-default">
                                                        <option value="all">สถานะบิล</option>
                                                        @foreach ($status_rent_bill as $sta_tus)
                                                            <option value="{{ $sta_tus->id }}">{{ $sta_tus->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-md-3" style="padding-right: unset !important;">
                                                    <div class="input-group input-group-merge">
                                                        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                                                        <input
                                                            name="room_name"
                                                            type="text"
                                                            class="form-control p_search"
                                                            placeholder="ค้นหาตามหมายเลขห้อง"
                                                            aria-label="ค้นหาตามหมายเลขห้อง"
                                                            oninput="loadData('{{$page_url}}/datatable')"
                                                            aria-describedby="basic-addon-search31" />
                                                    </div>
                                                </div>
                                                <!-- Group -->
                                                <div class="col-md-3" style="padding-right: unset !important;">
                                                    <div class="input-group input-group-merge">
                                                        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                                                        <input
                                                            name="invoice_number"
                                                            type="text"
                                                            class="form-control p_search"
                                                            placeholder="ค้นหาตามใบแจ้งหนี้/ใบเสร็จรับเงิน"
                                                            aria-label="ค้นหาตามใบแจ้งหนี้/ใบเสร็จรับเงิน"
                                                            oninput="loadData('{{$page_url}}/datatable')"
                                                            aria-describedby="basic-addon-search31" />
                                                      </div>
                                                </div>
                                                <div class="col-md-3" style="padding-right: unset !important;">
                                                    <div class="input-group input-group-merge">
                                                        <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                                                        <input
                                                            name="room_rent"
                                                            type="text"
                                                            class="form-control p_search"
                                                            placeholder="ค้นหาตามยอดเงินรวม"
                                                            aria-label="ค้นหาตามยอดเงินรวม"
                                                            oninput="loadData('{{$page_url}}/datatable')"
                                                            aria-describedby="basic-addon-search31" />
                                                      </div>
                                                </div>
                                    </div>
                                    <div class="row border-top mt-3 border-light p-3">
                                            <div class="col-md-1" style="padding-right: unset !important;">
                                            </div>
                                            <div class="col-md-2" style="padding-right: unset !important;">
                                            <select onchange='loadData("{{$page_url}}/datatable")' name="building" id="selectpickerBuilding" class="select2 form-select form-select-lg p_search" data-style="btn-default">
                                                    <option value="all">ทุกตึก</option>
                                                    @foreach ($buildings as $b)
                                                        <option value="{{ $b->id }}">{{ $b->name }}</option>
                                                    @endforeach
                                            </select>
                                            </div>
                                            <!-- Group -->
                                            <div class="col-md-2" style="padding-right: unset !important;">
                                            <select onchange='loadData("{{$page_url}}/datatable")' name="floor" id="selectpickerFloor" class="select2 form-select form-select-lg p_search" data-style="btn-default">
                                                    <option value="all">ทุกชั้น</option>
                                                    @foreach ($floors as $f)
                                                        <option value="{{ $f->id }}">{{ $f->name }}</option>
                                                    @endforeach
                                            </select>
                                            </div>
                                            <div class="col-md-7 text-end" style="padding-right: unset !important;">
                                                <button
                                                        class="btn btn-success buttons-collection  btn-info waves-effect waves-light"
                                                        tabindex="0" aria-controls="DataTables_Table_0"
                                                        type="button" aria-haspopup="dialog"
                                                        aria-expanded="false" data-bs-toggle="modal" data-bs-target="#123"
                                                        onclick="changeStatusAllCheck()"
                                                        >
                                                    <span><i class="ti ti-send"></i> ชำระเงิน</span>
                                                </button>
                                                <button 
                                                        style="padding-right: 14px;padding-left: 14px;"
                                                        class="btn btn-success buttons-collection btn-warning waves-effect waves-light me-2"
                                                        tabindex="0" aria-controls="DataTables_Table_0"
                                                        type="button" aria-haspopup="dialog"
                                                        aria-expanded="false"
                                                        onclick="window.open('{{$page_url}}/export/excel', '_blank')">
                                                    <span>
                                                    <i class="ti ti-upload"></i> ดาวน์โหลด Excel</span>
                                                </button>
                                                <button
                                                        style="padding-right: 14px;padding-left: 14px;"
                                                        class="btn btn-success buttons-collection btn-primary waves-effect waves-light me-2"
                                                        tabindex="0" aria-controls="DataTables_Table_0"
                                                        type="button" aria-haspopup="dialog"
                                                        aria-expanded="false"
                                                        onclick="window.open('{{$page_url}}/export/excel-summary', '_blank')"
                                                        {{-- onclick="printPdfBill()" --}}
                                                        >
                                                    <span>
                                                    <i class="ti ti-file-upload"></i> พิมพ์ใบสรุปบิล</span>
                                                </button>
                                                <button
                                                        style="padding-right: 14px;padding-left: 14px;"
                                                        class="btn btn-success buttons-collection btn-danger waves-effect waves-light me-2"
                                                        tabindex="0" aria-controls="DataTables_Table_0"
                                                        type="button" aria-haspopup="dialog"
                                                        aria-expanded="false"
                                                        onclick="printPdfMany()"
                                                        >
                                                    <span>
                                                    <i class="ti ti-file-upload"></i> พิมพ์หลายห้อง</span>
                                                </button>
                                            </div>
                                </div>
                                <div class="row mt-4">
                                        <div class="col-lg-7">
                                            <div class="d-flex align-items-center mb-2 mb-md-0">
                                                <label class="">Show</label>
                                                <select onchange='loadData("{{$page_url}}/datatable")' name="limit" class="form-select ms-2 me-2 p_search" style="width:100px">
                                                    <option value="10">10</option>
                                                    <option value="50">50</option>
                                                    <option value="100">100</option>
                                                    <option value="150">150</option>
                                                </select>
                                                <ul class="nav nav-pills" id="pills-tablayout" role="tablist">
                                                    <li class="nav-item me-1" role="presentation">
                                                        <button type="button" onclick="ch_div('pills-home')"
                                                            class="btn btn-icon btn-sm btn-label-secondary waves-effect"
                                                            id="pills-home-tab" data-bs-toggle="pill"
                                                            data-bs-target="#pills-home" type="button" role="tab"
                                                            aria-controls="pills-home" aria-selected="true">
                                                            <span class="ti ti-layout-grid ti-md"></span>
                                                        </button>
                                                    </li>
                                                    <li class="nav-item" role="presentation">
                                                        <button type="button" onclick="ch_div('pills-profile')"
                                                            class="btn btn-icon btn-sm btn-label-secondary waves-effect active"
                                                            data-bs-toggle="pill" data-bs-target="#pills-profile"
                                                            type="button" role="tab" aria-controls="pills-profile"
                                                            aria-selected="false">
                                                            <span class="ti ti-list ti-md"></span>
                                                        </button>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mt-1" style="padding-right: unset !important;">
                                            <h4 id="thai-month-label">พฤษภาคม 2024</h4>
                                        </div>
                                        <div class="col-md-2" style="padding-right: unset !important;">
                                            <input onchange='loadData("{{$page_url}}/datatable")' name="month" type="month" class="form-control p_search" id="exampleFormControlInput1" placeholder="" value="{{ date('Y-m', strtotime('-1 month')) }}" />
                                        </div>
                                        
                                    </div>
                                </div>
                                
                                <div class="card-body px-0 pt-0">
                                    <div class="tab-content p-0" id="pills-tabContent">
                                        
                                        {{-- table อยู่ตรงนี้ครับ --}}

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
    <div class="modal fade modalHeadDecor" id="invoice" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0" id="viewInvoice">
                
            </div>
        </div>
    </div>
    <div class="modal fade modalHeadDecor" id="editserviceModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title" id="exampleModalLabel1">รอคอนเฟิร์ม</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="detail">
                    
                </div>
                <div class="modal-footer rounded-0 justify-content-center">
                    <button
                            class="btn btn-success buttons-collection  btn-info waves-effect waves-light"
                            tabindex="0" aria-controls="DataTables_Table_0"
                            type="button" aria-haspopup="dialog"
                            aria-expanded="false" data-bs-toggle="modal" data-bs-target="#123"
                            onclick="changeStatusAllCheck()"
                            >
                        <span><i class="ti ti-send"></i> ชำระเงิน</span>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <iframe id="print-iframe" style="display: none;"></iframe>    
    <!-- / Layout wrapper -->
    @include('layout/inc_js')
    <script>
        
        function printPdf(id) {
            $.ajax({
                url: '/pdf/invoice/'+id,
                type: 'GET',
                success: function(html) {
                    const iframe = document.getElementById('print-iframe');
                    const doc = iframe.contentWindow.document;
                    doc.open();
                    doc.write(html);
                    doc.close();

                    // รอโหลดก่อนค่อยพิมพ์
                    iframe.onload = function () {
                        iframe.contentWindow.focus();
                        iframe.contentWindow.print();
                    };
                },
                error: function(xhr) {
                    alert('เกิดข้อผิดพลาด');
                    console.error(xhr.responseText);
                }
            });
        }
        function printPdfMany() {
            $.ajax({
                url: '/pdf/invoice-many/1',
                type: 'GET',
                success: function(html) {
                    const iframe = document.getElementById('print-iframe');
                    const doc = iframe.contentWindow.document;
                    doc.open();
                    doc.write(html);
                    doc.close();

                    // รอโหลดก่อนค่อยพิมพ์
                    iframe.onload = function () {
                        iframe.contentWindow.focus();
                        iframe.contentWindow.print();
                    };
                },
                error: function(xhr) {
                    alert('เกิดข้อผิดพลาด');
                    console.error(xhr.responseText);
                }
            });
        }
        function printPdfBill() {
            $.ajax({
                url: '/pdf/invoice-bill-all/1',
                type: 'GET',
                success: function(html) {
                    const iframe = document.getElementById('print-iframe');
                    const doc = iframe.contentWindow.document;
                    doc.open();
                    doc.write(html);
                    doc.close();

                    // รอโหลดก่อนค่อยพิมพ์
                    iframe.onload = function () {
                        iframe.contentWindow.focus();
                        iframe.contentWindow.print();
                    };
                },
                error: function(xhr) {
                    alert('เกิดข้อผิดพลาด');
                    console.error(xhr.responseText);
                }
            });
        }
        $(document).ready(function() {
            $('input[type="radio"]').click(function() {
                var inputValue = $(this).attr("value");
                var targetBox = $("." + inputValue);
                $(".box").not(targetBox).hide();
                $(targetBox).show();
            });
        });
        
        function view(id,de){
            if(de == 'table'){
                status_detail_waiting_confirm = 0;
            }else{
                status_detail_waiting_confirm = 1;
            }
            $.ajax({
                type: "GET",
                url: "{{ $page_url }}/"+id,
                success: function(data) {
                    $("#viewInvoice").html(data);
                }
            });
        }
        summary();
        function summary(){
            $.ajax({
                type: "GET",
                url: "{{ $page_url }}/summary",
                success: function(data) {
                    $('#confirm_by_employee').html(data.confirm_by_employee);
                    $('.detail_confirm_by_employee').html(data.confirm_by_employee);
                    $('#confirm_by_ceo').html(data.confirm_by_ceo);
                    $('.confirm_by_ceo').html(data.confirm_by_ceo);
                    $('.confirm_by_employee_confirm_by_ceo').html(data.confirm_by_employee_confirm_by_ceo);
                    $('#transfer').html(data.transfer);
                    $('#cash').html(data.cash);
                }
            });
        }
        // function incomplete(id){
        //     $.ajax({
        //         type: "GET",
        //         url: "{{ $page_url }}/incomplete/"+id,
        //         success: function(data) {
        //             $("#incompleteInvoice").html(data);
        //         }
        //     });
        // }
        function changeStatusBill(id, status, title){
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ '+title+' หรือไม่?',
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
                        type: "POST",
                        url: "{{ $page_url }}/change_status_bill/"+id,
                        data: {
                            _token: "{{ csrf_token() }}",
                            status: status
                        },
                        success: function(response) {
                            if(response == true){
                                $('#invoice').modal('hide');
                                loadData(page);
                                Swal.fire(title+' เรียบร้อยแล้ว', '', 'success');
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
        }

        var page = "{{$page_url}}/datatable";
        var searchData = {};
        loadData(page);
        
        var ch = "pills-profile";
        function ch_div(id_ch){
            ch = id_ch;
        }
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
                    $("#pills-tabContent").html(data);
                    $('#'+ch).addClass('active');
                    summary();
                    let selectedMonth = $('#exampleFormControlInput1').val(); // เช่น "2024-05"
                    let thaiMonthText = formatThaiMonth(selectedMonth);        // ได้ "พฤษภาคม 2024"
                    // console.log(thaiMonthText);
                     $('#thai-month-label').html(thaiMonthText);

                    // $("#table-data").html(data);
                }
            });
            // alert(page);
        }
        function formatThaiMonth(monthStr) {
            const months = [
                'มกราคม', 'กุมภาพันธ์', 'มีนาคม', 'เมษายน', 'พฤษภาคม', 'มิถุนายน',
                'กรกฎาคม', 'สิงหาคม', 'กันยายน', 'ตุลาคม', 'พฤศจิกายน', 'ธันวาคม'
            ];

            const parts = monthStr.split('-'); // ["2024", "05"]
            const year = parts[0];
            const monthIndex = parseInt(parts[1], 10) - 1;

            return `${months[monthIndex]} ${year}`;
        }


        var status_detail_waiting_confirm = 0;
        $('#invoice').on('hidden.bs.modal', function () {
            if(status_detail_waiting_confirm == 1){
                $('#editserviceModal').modal('show');
            };
        });
        function waitingForConfirmation(){
            $.ajax({
                type: "GET",
                url: "{{$page_url}}/waiting-for-confirmation",
                data: searchData,
                success: function(data) {
                    $("#detail").html(data);
                    summary();
                }
            });
            // alert(page);
        }
        function changeStatusAllCheck(){
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ ชำระเงินทั้งหมด หรือไม่?',
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
                        type: "POST",
                        url: "{{ $page_url }}/change_status_bill/all",
                        data: {
                            _token: "{{ csrf_token() }}",
                            status: 5
                        },
                        success: function(response) {
                            if(response == true){
                                $('#invoice').modal('hide');
                                loadData(page);
                                waitingForConfirmation();
                                Swal.fire('ชำระเงินทั้งหมด เรียบร้อยแล้ว', '', 'success');
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
            // var selectedValues = $('input.confirm-bill:checked').map(function() {
            //     return this.value;
            // }).get();

            // // แสดงผลลัพธ์
            // if (selectedValues.length === 0) {
            //     return 1;
            // } else {
            //     changeStatusBill(selectedValues, 2, "คอนเฟิร์มบิล");
            // }
        }
        
    </script>
    <script src="assets/vendor/libs/select2/select2.js"></script>
    <script src="assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="assets/js/forms-selects.js"></script>

</body>

</html>