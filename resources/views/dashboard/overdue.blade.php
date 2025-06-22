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
        /* border: 1px solid black */
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
                                                    ค้างชำระ
                                                </h4>
                                            </div>
                                            <div class="col-sm-6 col-lg-6 text-danger">
                                                <div class="card card-border-shadow-danger">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center pb-1">
                                                            <div class="avatar me-2">
                                                            <span class="avatar-initial rounded bg-label-danger"><i class="ti ti-alert-octagon ti-md"></i></span>
                                                            </div>
                                                            <h4 class="ms-1 mb-0 text-danger">{{ $summary['all_overdue'] }} ห้อง</h4>
                                                        </div>
                                                        <p class="mb-1">ห้องที่ค้างชำระ</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6 col-lg-6">
                                                <div class="card card-border-shadow-danger" style="background-color: #f8eae4;">
                                                    <div class="card-body">
                                                        <div class="d-flex align-items-center mb-2 pb-1">
                                                            <h4 class="ms-1 mb-0 text-danger">{{ number_format($all_overdue_payment) }}</h4>
                                                        </div>
                                                        <p class="mb-1">รวมยอดค้างชำระทั้งหมด</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row border-top border-light p-3">
                                        <div class="row mt-3">
                                            <div class="col-md-12" style="padding-right: unset !important;">
                                                <div class="input-group input-group-merge">
                                                    <span class="input-group-text" id="basic-addon-search31"><i class="ti ti-search"></i></span>
                                                    <input
                                                        name="search"
                                                        type="text"
                                                        class="form-control p_search"
                                                        placeholder="Search..."
                                                        aria-label="Search..."
                                                        oninput="loadData('{{$page_url}}/datatable')"
                                                        aria-describedby="basic-addon-search31" />
                                                  </div>
                                                  </div>
                                                
                                    </div>
                                        <div class="col-lg-4 mt-4">
                                            <div class="d-flex align-items-center mb-2 mb-md-0">
                                                <label class="">Show</label>
                                                <select name="" class="form-select ms-2 me-2" style="width:100px">
                                                    <option value="10">10</option>
                                                    <option value="25">25</option>
                                                    <option value="50">50</option>
                                                    <option value="75">75</option>
                                                    <option value="100">100</option>
                                                </select>
                                            </div>
                                        </div>
                                        
                                    </div>
                                    <div class="card-body px-0 pt-0" id="table-data">
                                                    {{-- ตารางอยู่ตรงนี้นะจ๊ะ --}}
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




    <!-- / Layout wrapper -->
    @include('layout/inc_js')
    <script>
        var page = "{{$page_url}}/datatable";
        var searchData = {};
        loadData(page);

        function view(id){
            $.ajax({
                type: "GET",
                url: "{{ $page_url }}/overdue/"+id,
                success: function(data) {
                    $("#viewInvoice").html(data);
                }
            });
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
                    $("#table-data").html(data);
                }
            });
            // alert(page);
        }
        $(document).ready(function() {
            $('input[type="radio"]').click(function() {
                var inputValue = $(this).attr("value");
                var targetBox = $("." + inputValue);
                $(".box").not(targetBox).hide();
                $(targetBox).show();
            });
        });
        </script>
    <script src="assets/vendor/libs/select2/select2.js"></script>
    <script src="assets/vendor/libs/bootstrap-select/bootstrap-select.js"></script>
    <script src="assets/js/forms-selects.js"></script>

</body>

</html>