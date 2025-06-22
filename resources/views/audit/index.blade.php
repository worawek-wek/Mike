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
    border: 1px solid black
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
/* .custom-tab-invoice.active {
    background-color: #d6f4f7 !important;
    color: black !important;
}
.custom-tab-receipt.active {
    background-color: #ffe2e3 !important;
    color: black !important;
} */
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
                                    <div class="card-header pb-0">
                                        <div class="row g-3 justify-content-between">
                                            <div class="col-sm-12">
                                                <h4 class="mb-0">
                                                    <i class="tf-icons ti ti-receipt-tax text-main ti-md me-2"></i>
                                                    บัญชี
                                                </h4>
                                            </div>
                                            <div class="col-sm-12">
                                                {{-- <ul class="nav nav-pills nav-fill" role="tablist">
                                                    <li class="nav-item me-4">
                                                        <button type="button" class="nav-link active custom-tab-invoice" role="tab"
                                                            data-bs-toggle="tab" data-bs-target="#navs-pills-top-home"
                                                            aria-controls="navs-pills-top-home" aria-selected="true">
                                                            ใบแจ้งหนี้
                                                        </button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button type="button" class="nav-link custom-tab-receipt" role="tab"
                                                            data-bs-toggle="tab" data-bs-target="#navs-pills-top-profile"
                                                            aria-controls="navs-pills-top-profile" aria-selected="false">
                                                            ใบเสร็จรับเงิน
                                                        </button>
                                                    </li>
                                                </ul>
                                                 --}}
                                                <ul class="nav nav-pills nav-fill" role="tablist">
                                                    <li class="nav-item pe-4">
                                                        <button type="button" class="nav-link btn-primary active" id="tab_invoice" role="tab"
                                                            data-bs-toggle="tab" data-bs-target="#navs-pills-top-home"
                                                            aria-controls="navs-pills-top-home"
                                                            aria-selected="true">
                                                            ใบแจ้งหนี้
                                                        </button>
                                                    </li>
                                                    <li class="nav-item">
                                                        <button type="button" class="nav-link btn-label-success" id="tab_receipt" role="tab"
                                                            data-bs-toggle="tab"
                                                            data-bs-target="#navs-pills-top-profile"
                                                            aria-controls="navs-pills-top-profile"
                                                            aria-selected="false">
                                                            ใบเสร็จรับเงิน
                                                        </button>
                                                    </li>
                                                </ul>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body">
                                        <div class="tab-content p-0">
                                            <div class="tab-pane fade show active" id="navs-pills-top-home"
                                                role="tabpanel">
                                                <div class="row mt-4 justify-content-end border-bottom pb-3">
                                                    <div class="col-md-3">
                                                        <select onchange="loadInvoiceData('{{$page_url}}/invoice/datatable')" name="ref_type_id" id="selectpickerBasic" class="form-select me-2 p_invoice_search" data-style="btn-default">
                                                                <option value="all">ประเภท</option>
                                                                <option value="3">ค่าจองห้อง</option>
                                                                <option value="2">ค่าเงินประกันห้อง</option>
                                                                <option value="1">ค่าเช่ารายเดือน</option>
                                                                {{-- <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option> --}}
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <select onchange="loadInvoiceData('{{$page_url}}/invoice/datatable')" name="ref_status_id" class="form-select me-2 p_invoice_search" data-style="btn-default">
                                                                <option value="all">สถานะ</option>
                                                                <option value="5">ชำระเงินแล้ว</option>
                                                                <option value="2">ยืนยันชำระเงินโดยพนักงาน</option>
                                                                <option value="3">ค้างชำระ</option>
                                                                <option value="4">ยกเลิกการชำระเงิน</option>
                                                                {{-- <option value="5">5</option> --}}
                                                        </select>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text"><i class="ti ti-search"></i></span>
                                                            <input
                                                            name="search"
                                                            type="text"
                                                            class="form-control p_invoice_search"
                                                            placeholder="ค้นหาตามเลขเอกสาร/เลขห้อง/ชื่อลูกค้า"
                                                            aria-label="ค้นหาตามเลขเอกสาร/เลขห้อง/ชื่อลูกค้า"
                                                            aria-describedby="basic-addon-search31"
                                                            oninput="loadInvoiceData('{{$page_url}}/invoice/datatable')"/>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row border-bottom border-light p-3 py-4">
                                                    <div class="col-lg-2">
                                                        <div class="d-flex align-items-center mb-2 mb-md-0">
                                                            <label class="">Show</label>
                                                            <select onchange='loadInvoiceData("{{$page_url}}/invoice/datatable")' name="limit" class="form-select ms-2 me-2 p_invoice_search" style="width:70px">
                                                                <option value="10">10</option>
                                                                <option value="25">25</option>
                                                                <option value="50">50</option>
                                                                <option value="75">75</option>
                                                                <option value="100">100</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-3 mt-1" style="padding-right: unset !important;font-weight: 500;" align="right">
                                                        <span style="font-size: 18px"></span><span style="font-size: 16px"> วันที่</span>
                                                    </div>
                                                    <div class="col-md-2" style="padding-right: unset !important;">
                                                        <input onchange="loadInvoiceData('{{$page_url}}/invoice/datatable')" name="month_from" type="month" value="{{ date('Y-m') }}" class="form-control p_invoice_search" id="exampleFormControlInput1" placeholder="" />
                                                    </div>
                                                    <div class="col-md-1" style="padding-right: unset !important;font-weight: 500;margin: inherit;" align="center">
                                                        <span style="font-size: 22px"></span><span style="font-size: 16px">ถึงวันที่</span>
                                                    </div>
                                                    <div class="col-md-2" style="padding-right: unset !important;">
                                                        <input onchange="loadInvoiceData('{{$page_url}}/invoice/datatable')" name="month_to" type="month" value="{{ date('Y-m') }}" class="form-control p_invoice_search" id="exampleFormControlInput2" placeholder="" />
                                                    </div>
                                                    <div class="col-md-2" style="padding-right: unset !important;">
                                                        <button
                                                                style="padding-right: 14px;padding-left: 14px;"
                                                                class="btn btn-success buttons-collection btn-warning waves-effect waves-light me-2"
                                                                tabindex="0" aria-controls="DataTables_Table_0"
                                                                type="button" aria-haspopup="dialog"
                                                                aria-expanded="false"
                                                                onclick="invoice_export_excel()"
                                                                >
                                                                <span>
                                                                    <i class="ti ti-upload"></i> 
                                                                    ดาวน์โหลด Excel
                                                                </span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body px-0 pt-0">
                                                    <div class="tab-content p-0" id="pills-tabContent">
                                                        <div class="tab-pane fade show active invoice_table" id="pills-profile" role="tabpanel"
                                                            aria-labelledby="pills-profile-tab" tabindex="0">
                                                            
                                                            {{-- table ใบแจ้งหนี้ อยู่ตรงนี้นะจ๊ะ --}}

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                                                <div class="tab-pane fade show active" id="pills-profile" role="tabpanel"
                                                aria-labelledby="pills-profile-tab" tabindex="0">
                                                <div class="row mt-4 justify-content-end border-bottom pb-3">
                                                    <div class="col-md-3">
                                                        <select onchange="loadReceiptData('{{$page_url}}/receipt/datatable')" id="selectpickerBasic" class="form-select me-2 p_receipt_search" name="ref_type_id" data-style="btn-default">
                                                                <option value="all">ประเภท</option>
                                                                <option value="1">ค่าจองห้อง</option>
                                                                <option value="2">ค่าเงินประกันห้อง</option>
                                                                <option value="3">ค่าเช่ารายเดือน</option>
                                                                {{-- <option value="3">3</option>
                                                                <option value="4">4</option>
                                                                <option value="5">5</option> --}}
                                                        </select>
                                                    </div>
                                                    {{-- <div class="col-md-3">
                                                        <select class="form-select me-2" data-style="btn-default">
                                                                <option value="">สถานะ</option>
                                                                <option value="1">ชำระเงินแล้ว</option>
                                                                <option value="2">ยืนยันชำระเงินโดยพนักงาน</option>
                                                                <option value="3">ค้างชำระ</option>
                                                                <option value="4">ยกเลิกการชำระเงิน</option>
                                                                <option value="5">5</option>
                                                        </select>
                                                    </div> --}}
                                                    <div class="col-md-5">
                                                        <div class="input-group input-group-merge">
                                                            <span class="input-group-text"><i class="ti ti-search"></i></span>
                                                            <input
                                                            oninput="loadReceiptData('{{$page_url}}/receipt/datatable')"
                                                            name="search"
                                                            type="text"
                                                            class="form-control p_receipt_search"
                                                            placeholder="ค้นหาตามเลขเอกสาร/เลขห้อง/ชื่อลูกค้า"
                                                            aria-label="ค้นหาตามเลขเอกสาร/เลขห้อง/ชื่อลูกค้า"
                                                            aria-describedby="basic-addon-search31" />
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row border-bottom border-light p-3 py-4">
                                                    <div class="col-lg-2">
                                                        <div class="d-flex align-items-center mb-2 mb-md-0">
                                                            <label class="">Show</label>
                                                            <select name="" class="form-select ms-2 me-2" style="width:70px">
                                                                <option value="10">10</option>
                                                                <option value="25">25</option>
                                                                <option value="50">50</option>
                                                                <option value="75">75</option>
                                                                <option value="100">100</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-3 mt-1" style="padding-right: unset !important;font-weight: 500;" align="right">
                                                        <span style="font-size: 18px"></span><span style="font-size: 16px"> วันที่</span>
                                                    </div>
                                                    <div class="col-md-2" style="padding-right: unset !important;">
                                                        <input onchange="loadReceiptData('{{$page_url}}/receipt/datatable')" name="month_from" value="{{ date('Y-m') }}" type="month" class="form-control p_receipt_search" id="exampleFormControlInput3" placeholder="" />
                                                    </div>
                                                    <div class="col-md-1" style="padding-right: unset !important;font-weight: 500;margin: inherit;" align="center">
                                                        <span style="font-size: 22px"></span><span style="font-size: 16px">ถึงวันที่</span>
                                                    </div>
                                                    <div class="col-md-2" style="padding-right: unset !important;">
                                                        <input onchange="loadReceiptData('{{$page_url}}/receipt/datatable')" name="month_to" value="{{ date('Y-m') }}" type="month" class="form-control p_receipt_search" id="exampleFormControlInput4" placeholder="" />
                                                    </div>
                                                    <div class="col-md-2" style="padding-right: unset !important;">
                                                        <button
                                                                style="padding-right: 14px;padding-left: 14px;"
                                                                class="btn btn-success buttons-collection btn-warning waves-effect waves-light me-2"
                                                                tabindex="0" aria-controls="DataTables_Table_0"
                                                                type="button" aria-haspopup="dialog"
                                                                aria-expanded="false"
                                                                onclick="receipt_export_excel()">
                                                                <span>
                                                                    <i class="ti ti-upload"></i> 
                                                                    ดาวน์โหลด Excel
                                                                </span>
                                                        </button>
                                                    </div>
                                                </div>
                                                <div class="card-body px-0 pt-0">
                                                    <div class="tab-content p-0" id="pills-tabContent">
                                                        <div class="tab-pane fade show active receipt_table" id="pills-profile" role="tabpanel"
                                                            aria-labelledby="pills-profile-tab" tabindex="0">
                                                            
                                                            {{-- table ใบเสร็จรับเงิน อยู่ตรงนี้นะจ๊ะ --}}

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

    <iframe id="print-iframe" style="display: none;"></iframe>        
    
    <!-- / Layout wrapper -->
    @include('layout/inc_js')
    <script src="assets/vendor/libs/select2/select2.js"></script>
    <script src="assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="assets/js/forms-selects.js"></script>

<script>
    var invoice_page = "{{$page_url}}/invoice/datatable";
    var receipt_page = "{{$page_url}}/receipt/datatable";
    var searchInvoiceData = {};
    var searchReceiptData = {};


    loadInvoiceData(invoice_page);
    loadReceiptData(receipt_page);
    
    function printPdfReceipt(id) {
        $.ajax({
            url: '/pdf/receipt/'+id,
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

    function loadInvoiceData(pages){
        
        $('.p_invoice_search').each(function() {
            var inputName = $(this).attr('name'); // ดึงชื่อ attribute 'name' ของ input
            var inputValue = $(this).val(); // ดึงค่า value ของ input
            
            searchInvoiceData[inputName] = inputValue; // เก็บข้อมูลลงในออบเจ็กต์ searchInvoiceData
        });

        invoice_page = pages;

        $.ajax({
            type: "GET",
            url: invoice_page,
            data: searchInvoiceData,
            success: function(data) {
                $(".invoice_table").html(data);
            }
        });

    }

    function loadReceiptData(pages){
        
        $('.p_receipt_search').each(function() {
            var inputName = $(this).attr('name'); // ดึงชื่อ attribute 'name' ของ input
            var inputValue = $(this).val(); // ดึงค่า value ของ input
            
            searchReceiptData[inputName] = inputValue; // เก็บข้อมูลลงในออบเจ็กต์ searchReceiptData
        });

        receipt_page = pages;

        $.ajax({
            type: "GET",
            url: receipt_page,
            data: searchReceiptData,
            success: function(data) {
                $(".receipt_table").html(data);
            }
        });
        // alert(page);
    }
    function invoice_export_excel(){
        var searchInvoiceData = {};

        $('.p_invoice_search').each(function() {
            var inputName = $(this).attr('name');
            var inputValue = $(this).val();
            searchInvoiceData[inputName] = inputValue;
        });

        // แปลงเป็น query string
        var queryString = Object.keys(searchInvoiceData)
            .map(key => encodeURIComponent(key) + '=' + encodeURIComponent(searchInvoiceData[key]))
            .join('&');

        var fullUrl = '{{$page_url}}/invoice/export/excel' + '?' + queryString;

        window.open(fullUrl, '_blank');
    }

    function receipt_export_excel(){
        var searchReceiptData = {};

        $('.p_receipt_search').each(function() {
            var inputName = $(this).attr('name');
            var inputValue = $(this).val();
            searchReceiptData[inputName] = inputValue;
        });

        // แปลงเป็น query string
        var queryString = Object.keys(searchReceiptData)
            .map(key => encodeURIComponent(key) + '=' + encodeURIComponent(searchReceiptData[key]))
            .join('&');

        var fullUrl = '{{$page_url}}/receipt/export/excel' + '?' + queryString;

        window.open(fullUrl, '_blank');
    }

            $('#selectpickerBuilding').change(function() {
                var building = $(this).val();
                
                // เคลียร์ dropdown สำหรับตำบล
                $('#selectpickerFloor').empty().append('<option value="all">ทุกชั้น</option>');

                if(building == 'all'){
                    $('#selectpickerFloor').prop('disabled', true);
                    return;
                }
                if (building) {
                    $.ajax({
                        url: '/get-floors/' + building,
                        type: 'GET',
                        success: function(data) {
                            $('#selectpickerFloor').prop('disabled', false);
                            data.forEach(function(floor) {
                                $('#selectpickerFloor').append('<option value="' + floor.id + '">' + floor.name + '</option>');
                            });
                        }
                    });
                }
            });
            $('#selectpickerBuilding_2').change(function() {
                var building = $(this).val();
                
                // เคลียร์ dropdown สำหรับตำบล
                $('#selectpickerFloor_2').empty().append('<option value="all">ทุกชั้น</option>');

                if(building == 'all'){
                    $('#selectpickerFloor_2').prop('disabled', true);
                    return;
                }
                if (building) {
                    $.ajax({
                        url: '/get-floors/' + building,
                        type: 'GET',
                        success: function(data) {
                            $('#selectpickerFloor_2').prop('disabled', false);
                            data.forEach(function(floor) {
                                $('#selectpickerFloor_2').append('<option value="' + floor.id + '">' + floor.name + '</option>');
                            });
                        }
                    });
                }
            });
            
       
    $('#tab_invoice').on('click', function() {
        $('.nav-link').removeClass('active btn-success');
        $('#tab_receipt').addClass('btn-label-success');
        $(this).removeClass('btn-label-primary');
        $(this).addClass('active btn-primary');
    });
    $('#tab_receipt').on('click', function() {
        $('.nav-link').removeClass('active btn-primary');
        $('#tab_invoice').addClass('btn-label-primary');
        $(this).removeClass('btn-label-success');
        $(this).addClass('active btn-success');
    });
    
</script>

</body>

</html>