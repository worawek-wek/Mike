<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template">

<head>
    @include('layout/inc_header')
    <title>Dashboard - CRM | Vuexy - Bootstrap Admin Template</title>

</head>
{{-- //////////////////////////////////// --}}
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
</style>
{{-- //////////////////////////////////// --}}
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
                                        <div class="row g-3 justify-content-between mb-4">
                                            <div class="col-sm-12">
                                                <h4 class="mb-0">
                                                    <i class="tf-icons ti ti-chart-pie-3 text-main ti-md"></i>
                                                    รายงานบิลค่าเช่า
                                                </h4>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card card-border-shadow-success h-100">
                                                    <div
                                                        class="card-body d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <div class="card-icon me-3">
                                                                <span class="badge bg-label-success rounded p-2">
                                                                    <i class="ti ti-check ti-26px"></i>
                                                                </span>
                                                            </div>
                                                            <h3 class="mb-0 me-2 text-success">504,861 บาท</h3>
                                                        </div>
                                                        <div class="card-title mb-0">
                                                            <p class="mb-0">ชำระแล้ว</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="card card-border-shadow-danger bg-danger-subtle h-100">
                                                    <div
                                                        class="card-body d-flex justify-content-between align-items-center">
                                                        <div class="d-flex align-items-center">
                                                            <div class="card-icon me-3">
                                                                <span class="badge bg-label-danger rounded p-2">
                                                                    <i class="ti ti-x ti-26px"></i>
                                                                </span>
                                                            </div>
                                                            <h3 class="mb-0 me-2 text-danger">416,140 บาท</h3>
                                                        </div>
                                                        <div class="card-title mb-0">
                                                            <p class="mb-0">ยอดค้างชำระ</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <hr>
                                        <div>
                                            <h5 class="card-title">แยกตามการชำระ</h5>
                                            <div class="row justify-content-center">
                                                <div class="col-sm-3">
                                                    <div class="d-flex mb-3 pb-1 align-items-center">
                                                        <div class="chart-progress me-3" data-color="primary"
                                                            data-series="72" data-progress_variant="true"></div>
                                                        <div class="me-2">
                                                            <h6 class="mb-1">เงินสดรอคอนเฟิร์ม</h6>
                                                            <small>419,868</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="d-flex mb-3 pb-1 align-items-center">
                                                        <div class="chart-progress me-3" data-color="success"
                                                            data-series="48" data-progress_variant="true"></div>
                                                        <div class="me-2">
                                                            <h6 class="mb-1">เงินสดคอนเฟิร์มแล้ว</h6>
                                                            <small>44,388</small>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-sm-3">
                                                    <div class="d-flex mb-3 pb-1 align-items-center">
                                                        <div class="chart-progress me-3" data-color="danger"
                                                            data-series="15" data-progress_variant="true"></div>
                                                        <div class="me-2">
                                                            <h6 class="mb-1">ผ่านการโอนเงิน </h6>
                                                            <small>40,605 บาท</small>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-datatable table-responsive">
                                        <div id="DataTables_Table_0_wrapper"
                                            class="dataTables_wrapper dt-bootstrap5 no-footer">
                                            <div
                                                class="card-header d-flex border-top rounded-0 flex-wrap py-0 flex-column flex-md-row align-items-start">
                                                <div class="me-5 ms-n4 pe-5 mb-n6 mb-md-0">

                                                    <!-- <label><input type="search" class="form-control"
                                                                placeholder="Search Product"
                                                                aria-controls="DataTables_Table_0"></label> -->
                                                    <div class="dataTables_length mx-n2 ms-2"
                                                        id="DataTables_Table_0_length">
                                                        <label>Show
                                                            <select name="DataTables_Table_0_length"
                                                                aria-controls="DataTables_Table_0" class="form-select">
                                                                <option value="7">7</option>
                                                                <option value="10">10</option>
                                                                <option value="20">20</option>
                                                                <option value="50">50</option>
                                                                <option value="70">70</option>
                                                                <option value="100">100</option>
                                                            </select>
                                                        </label>
                                                    </div>
                                                </div>
                                                <div
                                                    class="d-flex justify-content-start justify-content-md-end align-items-baseline">
                                                    <div
                                                        class="dt-action-buttons d-flex flex-column align-items-start align-items-sm-center justify-content-sm-center pt-0 gap-sm-2 gap-sm-0 flex-sm-row">
                                                        <div id="DataTables_Table_0_filter"
                                                            class="dataTables_filter mx-n2 me-2">
                                                            <input type="date" class="form-control">
                                                        </div>
                                                        <div class="dt-buttons btn-group flex-wrap d-flex mb-6 mb-sm-0">

                                                            <button
                                                                class="btn btn-secondary add-new btn-label-primary me-2 ms-sm-0 waves-effect waves-light"
                                                                tabindex="0" aria-controls="DataTables_Table_0"
                                                                type="button">
                                                                <span>
                                                                    <i class="ti ti-file-upload me-0 me-sm-1"></i>
                                                                    <span class="d-none d-sm-inline-block">พิมพ์
                                                                    </span>
                                                                </span>
                                                            </button>
                                                            <div class="btn-group">
                                                                <button
                                                                    class="btn btn-success buttons-collection  btn-label-warning waves-effect waves-light"
                                                                    tabindex="0" aria-controls="DataTables_Table_0"
                                                                    type="button" aria-haspopup="dialog"
                                                                    aria-expanded="false">
                                                                    <span><i class="ti ti-upload me-1"></i>ดาวน์โหลด
                                                                        Excel
                                                                    </span>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <table class="datatables-products table dataTable no-footer dtr-column"
                                                id="DataTables_Table_0" aria-describedby="DataTables_Table_0_info">
                                                <thead class="border-top">
                                                    <tr class="text-center table-info">
                                                        <th class="control  dtr-hidden" rowspan="1"
                                                            colspan="1" style="width: 0px; display: none;"
                                                            aria-label=""></th>
                                                        <th class="text-center" style="padding: 0 50px;">
                                                            ห้อง
                                                        </th>
                                                        <th class="text-center">
                                                            ชื่อผู้เช่า
                                                        </th>
                                                        <th class="text-center" style="width: 57px;">
                                                            เลขที่ใบเสร็จ
                                                        </th>
                                                        <th class="text-center" style="width: 150px;">
                                                            วันที่รับชำระ
                                                        </th>
                                                        <th class="text-nowrap text-center">
                                                            ช่องทาง
                                                        </th>
                                                        <th class="text-nowrap text-center">
                                                            รับชำระโดย
                                                        </th>
                                                        <th class="text-center">
                                                            รวม
                                                        </th>
                                                        <th class="text-center" style="width: 100px;">
                                                            ค่าห้องเช่า
                                                        </th>
                                                        <th class="text-center">
                                                            ค่าน้ำ
                                                        </th>
                                                        <th class="text-center">
                                                            ค่าไฟ
                                                        </th>
                                                        <th class="text-center">
                                                            ค่าที่จอด <br> รถยนต์
                                                        </th>
                                                        <th class="text-center">
                                                            ค่าที่จอด <br> รถมอเตอร์ไซค์
                                                        </th>
                                                        <th class="text-nowrap text-center">
                                                            ส่วนกลาง
                                                        </th>
                                                        <th class="text-center">
                                                            รวม
                                                        </th>
                                                        <th class="text-center">
                                                            สถานะ
                                                        </th>
                                                        <!-- <th class="sorting_disabled" rowspan="1" colspan="1"
                                                            style="width: 87px;" aria-label="Actions">จัดการ</th> -->
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr class="odd table-success" align="center">
                                                        <td class="control" tabindex="0" style="display: none;">
                                                        </td>
                                                        <td class="sorting_1">A101</td>
                                                        <td><span class="text-truncate">นางสาว มาลินี ประเทศา</span>
                                                        </td>
                                                        <td><span>RC202405000109</span></td>
                                                        <td style="padding: 0 22px;"><span>25/04/2022</span></td>
                                                        <td><span>เงินสด</span></td>
                                                        <td><span>นิชกานต์</span></td>
                                                        <td><span>4,000</span></td>
                                                        <td style="padding: 0 45px;"><span>105</span></td>
                                                        <td><span>2,023</span></td>
                                                        <td><span>3,450</span></td>
                                                        <td style="padding: 0 32px;"><span>4,000</span></td>
                                                        <td style="padding: 0 62px;"><span>105</span></td>
                                                        <td><span>2,023</span></td>
                                                        <td><span>3,450</span></td>
                                                        <td><span class="badge bg-label-success"
                                                                text-capitalized="">ชำระแล้ว</span></td>
                                                        <!-- <td>
                                                            <div class="d-inline-block text-nowrap"><button
                                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i
                                                                        class="ti ti-edit ti-md"></i></button><button
                                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown"><i
                                                                        class="ti ti-dots-vertical ti-md"></i></button>
                                                                <div class="dropdown-menu dropdown-menu-end m-0"><a
                                                                        href="javascript:0;"
                                                                        class="dropdown-item">View</a><a
                                                                        href="javascript:0;"
                                                                        class="dropdown-item">Suspend</a></div>
                                                            </div>
                                                        </td> -->
                                                    </tr>
                                                    <tr class="even table-success" align="center">
                                                        <td class="control" tabindex="0" style="display: none;">
                                                        </td>
                                                        <td class="sorting_1">A101</td>
                                                        <td><span class="text-truncate">นางสาว มาลินี ประเทศา</span>
                                                        </td>
                                                        <td><span>RC202405000109</span></td>
                                                        <td style="padding: 0 22px;"><span>25/04/2022</span></td>
                                                        <td><span>เงินสด</span></td>
                                                        <td><span>นิชกานต์</span></td>
                                                        <td><span>4,000</span></td>
                                                        <td><span>105</span></td>
                                                        <td><span>2,023</span></td>
                                                        <td><span>3,450</span></td>
                                                        <td><span>4,000</span></td>
                                                        <td><span>105</span></td>
                                                        <td><span>2,023</span></td>
                                                        <td><span>3,450</span></td>
                                                        <td><span class="badge bg-label-success"
                                                                text-capitalized="">ชำระแล้ว</span></td>
                                                        <!-- <td>
                                                            <div class="d-inline-block text-nowrap"><button
                                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i
                                                                        class="ti ti-edit ti-md"></i></button><button
                                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown"><i
                                                                        class="ti ti-dots-vertical ti-md"></i></button>
                                                                <div class="dropdown-menu dropdown-menu-end m-0"><a
                                                                        href="javascript:0;"
                                                                        class="dropdown-item">View</a><a
                                                                        href="javascript:0;"
                                                                        class="dropdown-item">Suspend</a></div>
                                                            </div>
                                                        </td> -->
                                                    </tr>
                                                    <tr class="odd table-success" align="center">
                                                        <td class="control" tabindex="0" style="display: none;">
                                                        </td>
                                                        <td class="sorting_1">A101</td>
                                                        <td><span class="text-truncate">นางสาว มาลินี ประเทศา</span>
                                                        </td>
                                                        <td><span>RC202405000109</span></td>
                                                        <td style="padding: 0 22px;"><span>25/04/2022</span></td>
                                                        <td><span>เงินสด</span></td>
                                                        <td><span>นิชกานต์</span></td>
                                                        <td><span>4,000</span></td>
                                                        <td><span>105</span></td>
                                                        <td><span>2,023</span></td>
                                                        <td><span>3,450</span></td>
                                                        <td><span>4,000</span></td>
                                                        <td><span>105</span></td>
                                                        <td><span>2,023</span></td>
                                                        <td><span>3,450</span></td>
                                                        <td><span class="badge bg-label-success"
                                                                text-capitalized="">ชำระแล้ว</span></td>
                                                        <!-- <td>
                                                            <div class="d-inline-block text-nowrap"><button
                                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i
                                                                        class="ti ti-edit ti-md"></i></button><button
                                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown"><i
                                                                        class="ti ti-dots-vertical ti-md"></i></button>
                                                                <div class="dropdown-menu dropdown-menu-end m-0"><a
                                                                        href="javascript:0;"
                                                                        class="dropdown-item">View</a><a
                                                                        href="javascript:0;"
                                                                        class="dropdown-item">Suspend</a></div>
                                                            </div>
                                                        </td> -->
                                                    </tr>
                                                    <tr class="even table-warning" align="center">
                                                        <td class="control" tabindex="0" style="display: none;">
                                                        </td>
                                                        <td class="sorting_1">A101</td>
                                                        <td><span class="text-truncate">นางสาว มาลินี ประเทศา</span>
                                                        </td>
                                                        <td><span>RC202405000109</span></td>
                                                        <td style="padding: 0 22px;"><span>25/04/2022</span></td>
                                                        <td><span>เงินสด</span></td>
                                                        <td><span>นิชกานต์</span></td>
                                                        <td><span>4,000</span></td>
                                                        <td><span>105</span></td>
                                                        <td><span>2,023</span></td>
                                                        <td><span>3,450</span></td>
                                                        <td><span>4,000</span></td>
                                                        <td><span>105</span></td>
                                                        <td><span>2,023</span></td>
                                                        <td><span>3,450</span></td>
                                                        <td><span class="badge bg-label-warning"
                                                                text-capitalized="">รอชำระ</span></td>
                                                        <!-- <td>
                                                            <div class="d-inline-block text-nowrap"><button
                                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i
                                                                        class="ti ti-edit ti-md"></i></button><button
                                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown"><i
                                                                        class="ti ti-dots-vertical ti-md"></i></button>
                                                                <div class="dropdown-menu dropdown-menu-end m-0"><a
                                                                        href="javascript:0;"
                                                                        class="dropdown-item">View</a><a
                                                                        href="javascript:0;"
                                                                        class="dropdown-item">Suspend</a></div>
                                                            </div>
                                                        </td> -->
                                                    </tr>
                                                    <tr class="odd table-success" align="center">
                                                        <td class="control" tabindex="0" style="display: none;">
                                                        </td>
                                                        <td class="sorting_1">A101</td>
                                                        <td><span class="text-truncate">นางสาว มาลินี ประเทศา</span>
                                                        </td>
                                                        <td><span>RC202405000109</span></td>
                                                        <td style="padding: 0 22px;"><span>25/04/2022</span></td>
                                                        <td><span>เงินสด</span></td>
                                                        <td><span>นิชกานต์</span></td>
                                                        <td><span>4,000</span></td>
                                                        <td><span>105</span></td>
                                                        <td><span>2,023</span></td>
                                                        <td><span>3,450</span></td>
                                                        <td><span>4,000</span></td>
                                                        <td><span>105</span></td>
                                                        <td><span>2,023</span></td>
                                                        <td><span>3,450</span></td>
                                                        <td><span class="badge bg-label-success"
                                                                text-capitalized="">แบ่งชำระ</span></td>
                                                        <!-- <td>
                                                            <div class="d-inline-block text-nowrap"><button
                                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i
                                                                        class="ti ti-edit ti-md"></i></button><button
                                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown"><i
                                                                        class="ti ti-dots-vertical ti-md"></i></button>
                                                                <div class="dropdown-menu dropdown-menu-end m-0"><a
                                                                        href="javascript:0;"
                                                                        class="dropdown-item">View</a><a
                                                                        href="javascript:0;"
                                                                        class="dropdown-item">Suspend</a></div>
                                                            </div>
                                                        </td> -->
                                                    </tr>
                                                    <tr class="even table-danger" align="center">
                                                        <td class="control" tabindex="0" style="display: none;">
                                                        </td>
                                                        <td class="sorting_1">A101</td>
                                                        <td><span class="text-truncate">นางสาว มาลินี ประเทศา</span>
                                                        </td>
                                                        <td><span>RC202405000109</span></td>
                                                        <td style="padding: 0 22px;"><span>25/04/2022</span></td>
                                                        <td><span>เงินสด</span></td>
                                                        <td><span>นิชกานต์</span></td>
                                                        <td><span>4,000</span></td>
                                                        <td><span>105</span></td>
                                                        <td><span>2,023</span></td>
                                                        <td><span>3,450</span></td>
                                                        <td><span>4,000</span></td>
                                                        <td><span>105</span></td>
                                                        <td><span>2,023</span></td>
                                                        <td><span>3,450</span></td>
                                                        <td><span class="badge bg-label-danger"
                                                                text-capitalized="">ค้างชำระ</span></td>
                                                        <!-- <td>
                                                            <div class="d-inline-block text-nowrap"><button
                                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light"><i
                                                                        class="ti ti-edit ti-md"></i></button><button
                                                                    class="btn btn-sm btn-icon btn-text-secondary rounded-pill waves-effect waves-light dropdown-toggle hide-arrow"
                                                                    data-bs-toggle="dropdown"><i
                                                                        class="ti ti-dots-vertical ti-md"></i></button>
                                                                <div class="dropdown-menu dropdown-menu-end m-0"><a
                                                                        href="javascript:0;"
                                                                        class="dropdown-item">View</a><a
                                                                        href="javascript:0;"
                                                                        class="dropdown-item">Suspend</a></div>
                                                            </div>
                                                        </td> -->
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="row">
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="dataTables_info" id="DataTables_Table_0_info"
                                                        role="status" aria-live="polite">Displaying 1 to 7 of 100
                                                        entries</div>
                                                </div>
                                                <div class="col-sm-12 col-md-6">
                                                    <div class="dataTables_paginate paging_simple_numbers"
                                                        id="DataTables_Table_0_paginate">
                                                        <ul class="pagination">
                                                            <li class="paginate_button page-item previous disabled"
                                                                id="DataTables_Table_0_previous"><a
                                                                    aria-controls="DataTables_Table_0"
                                                                    aria-disabled="true" role="link"
                                                                    data-dt-idx="previous" tabindex="-1"
                                                                    class="page-link"><i
                                                                        class="ti ti-chevron-left ti-sm"></i></a>
                                                            </li>
                                                            <li class="paginate_button page-item active"><a href="#"
                                                                    aria-controls="DataTables_Table_0" role="link"
                                                                    aria-current="page" data-dt-idx="0" tabindex="0"
                                                                    class="page-link">1</a></li>
                                                            <li class="paginate_button page-item "><a href="#"
                                                                    aria-controls="DataTables_Table_0" role="link"
                                                                    data-dt-idx="1" tabindex="0" class="page-link">2</a>
                                                            </li>
                                                            <li class="paginate_button page-item "><a href="#"
                                                                    aria-controls="DataTables_Table_0" role="link"
                                                                    data-dt-idx="2" tabindex="0" class="page-link">3</a>
                                                            </li>
                                                            <li class="paginate_button page-item "><a href="#"
                                                                    aria-controls="DataTables_Table_0" role="link"
                                                                    data-dt-idx="3" tabindex="0" class="page-link">4</a>
                                                            </li>
                                                            <li class="paginate_button page-item "><a href="#"
                                                                    aria-controls="DataTables_Table_0" role="link"
                                                                    data-dt-idx="4" tabindex="0" class="page-link">5</a>
                                                            </li>
                                                            <li class="paginate_button page-item disabled"
                                                                id="DataTables_Table_0_ellipsis"><a
                                                                    aria-controls="DataTables_Table_0"
                                                                    aria-disabled="true" role="link"
                                                                    data-dt-idx="ellipsis" tabindex="-1"
                                                                    class="page-link">…</a></li>
                                                            <li class="paginate_button page-item "><a href="#"
                                                                    aria-controls="DataTables_Table_0" role="link"
                                                                    data-dt-idx="14" tabindex="0"
                                                                    class="page-link">15</a></li>
                                                            <li class="paginate_button page-item next"
                                                                id="DataTables_Table_0_next"><a href="#"
                                                                    aria-controls="DataTables_Table_0" role="link"
                                                                    data-dt-idx="next" tabindex="0" class="page-link"><i
                                                                        class="ti ti-chevron-right ti-sm"></i></a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div style="width: 1%;"></div>
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
    <!-- / Layout wrapper -->
    @include('layout/inc_js')
    <script src="assets/js/app-academy-dashboard.js"></script>

</body>

</html>