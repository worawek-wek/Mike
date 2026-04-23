<!doctype html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed layout-compact" dir="ltr"
    data-theme="theme-default" data-assets-path="assets/" data-template="vertical-menu-template">

<head>
    @include('layout/inc_header')
    <title>Dashboard - CRM | Vuexy - Bootstrap Admin Template</title>
</head>

<div id="loadingOverlay" style="display: none;">
  <div class="spinner"></div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<style>
  /* พื้นหลังทึบ */
  #loadingOverlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(255,255,255,0.8);
    z-index: 9999;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  /* สปินเนอร์หมุน */
  .spinner {
    border: 8px solid #f3f3f3;
    border-top: 8px solid #28c76f;
    border-radius: 50%;
    width: 60px;
    height: 60px;
    animation: spin 1s linear infinite;
  }

  @keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
  }
</style>
<style>
    .bootstrap-tagsinput {
      width: 100%;
    }
    .bootstrap-tagsinput .tag.invalid {
      background-color: #dc3545 !important;
      color: white;
    }

    .bootstrap-tagsinput .tag {
        color: white !important; 
        background-color: #007bff !important; 
        padding: 5px;
        border-radius: 4px;
        margin-right: 2px;
    }

    .bootstrap-tagsinput .tag.invalid {
        background-color: #dc3545 !important; /* สีแดง */
        color: white !important;
    }
    select#selectAllRooms + .ts-wrapper .ts-control .item {
        background-color: #0d6efd !important; /* ฟ้าแบบ Bootstrap Primary */
        color: #fff !important;               /* ตัวหนังสือขาว */
        border-radius: 12px;                  /* มุมโค้ง */
        padding: 4px 10px;
        margin: 2px;
        font-weight: 500;
    }
    select#selectAllRooms + .ts-wrapper .ts-control .item:hover {
        background-color: #0e5ed7 !important; /* เขียวเข้มขึ้น */
    }
  </style>
  
<style>
    .table-detail {
        border-collapse: collapse; /* รวมเส้นขอบของตาราง */
        border-radius: 5px;
        overflow: hidden;
    }
    .table-detail th, .table-detail td {
        border: 1px solid #d9d9d9 !important; /* กำหนดเส้นขอบของ th และ td */
    }
    .table-detail th {
        vertical-align: middle;
        font-weight: 500;
        font-size: 14px;
        color: black !important;
    }
    .new_box .col-md-6 {
        padding: 5px 12px;
    }
    .table th {
        font-size: 15px;
        font-weight: bold;
        border: 1px solid #dbdade
    }
    .border-dbdade th {
        border: 1px solid #dbdade
    }
    .border-dbdade td {
        border: 1px solid #dbdade
    }
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
                                        <div class="col-sm-12">
                                            <h4 class="mb-0">
                                                <i class="tf-icons ti ti-sitemap text-main ti-xl me-2"></i>
                                                ทำสัญญาเข้าพัก ห้อง
                                                {{ $room->name ?? '' }}
                                            </h4>
                                        </div>
                                    </div>
                                    <div class="card-body"> 
                                        {{-- insert_renter --}}
                                    <form id="insert_check_in">
                                    <div class="tab-content p-0" id="pills-tabContent">
                                        @csrf
                                            {{-- อันนี้แหละ หน้า สัญญาเช่า -> Form ทำสัญญา --}}
                                            {{-- อันนี้แหละ หน้า สัญญาเช่า -> Form ทำสัญญา --}}
                                            {{-- อันนี้แหละ หน้า สัญญาเช่า -> Form ทำสัญญา --}}
                                            
                                        <div class="m-2" style="border: 1px solid #dbdbdb;border-radius: 5px;">
                                            <h5 class="border-bottom p-2" style="background-color: rgb(255, 248, 237);;">
                                                <i class="tf-icons ti ti-user text-main" style="font-size: 25px;vertical-align: baseline;"></i>
                                                ข้อมูลส่วนตัว
                                            </h5>

                                            @if (@$check_in)
                                            <input type="hidden" name="room_id" value="{{ $room->id }}">
                                            <div class="row g-3 p-4 pt-1">
                                                <div class="col-sm-2">
                                                    <label for="exampleFormControlSelect1" class="form-label">คำนำหน้า</label>
                                                    <select name="prefix" class="form-select" id="exampleFormControlSelect1"
                                                        aria-label="Default select example">
                                                        <option value="บริษัท" selected>บริษัท</option>
                                                        <option value="นาย">นาย</option>
                                                        <option value="นางสาว">นางสาว</option>
                                                        <option value="นาง">นาง</option>
                                                    </select>
                                                </div>
                                                <div class="col-sm-5">
                                                    <label for="exampleFormControlInput1" class="form-label">ชื่อจริง</label><span class="text-danger">*</span></label>
                                                    <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="" value="" required/>
                                                </div>
                                                <div class="col-sm-5">
                                                    <label for="exampleFormControlInput2" class="form-label">นามสกุล</label><span class="text-danger">*</span>
                                                    <input type="text" name="surname" class="form-control" id="exampleFormControlInput2" placeholder="" value="" required/>
                                                </div>
                                            @else
                                                <div class="col-sm-5">
                                                    <label for="exampleFormControlInput1" class="form-label">ชื่อผู้เข้าพัก</label>
                                                    <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="" value="{{ @$contract->full_name }}" />
                                                </div>
                                            @endif
                                            
                                            <div class="col-sm-7">
                                                <label for="exampleFormControlInput2" class="form-label">ที่อยู่ผู้เข้าพัก</label>
                                                <input type="text" name="address" class="form-control" id="exampleFormControlInput2" placeholder="" value="{{ @$contract->address }}" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="exampleFormControlInput3" class="form-label">เบอร์โทรผู้เข้าพัก<span class="text-danger">*</span></label>
                                                <input type="text" name="phone" class="form-control" id="exampleFormControlInput3" placeholder="" oninput="this.value=this.value.slice(0,10);" value="{{ @$contract->phone }}" pattern="^\d{9,10}$" required />
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="exampleFormControlInput4" class="form-label">หมายเลขบัตรประชาชนผู้เข้าพัก<span class="text-danger">*</span></label>
                                                <input type="text" name="id_card_number" class="form-control" id="exampleFormControlInput4" placeholder="" oninput="this.value=this.value.slice(0,13);" value="{{ @$contract->id_card_number }}" pattern="^\d{13}$"  required/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="contract_date" class="form-label">วันที่ทำสัญญา</label>
                                                <input type="text" name="contract_date" class="form-control" placeholder="" id="contract_date" required autocomplete="off" value="{{ @$contract->contract_date != null ? date('d/m/Y', strtotime($contract->contract_date)) : date('d/m/Y'); }}"/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label class="form-label">ระยะเวลาสัญญา(เดือน)</label>
                                                <input type="number" name="period" class="form-control" placeholder="" value="{{ @$contract->period }}" required id="period"/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="contract_date_to" class="form-label">วันที่สิ้นสุดสัญญา </label>
                                                <input type="text" name="contract_date_to" class="form-control" placeholder="" id="contract_date_to" required autocomplete="off" value=""/>
                                            </div>
                                            <div></div>
                                            @if (@$room->status != 2)
                                            <table class="table table-detail table-bordered" id="discount-table">
                                                <tbody>
                                                    <tr>
                                                        <td>ค่าเช่าห้อง (Room rate)</td>
                                                        <td class="text-end" width="18%">
                                                            {{ number_format($room->rent+$room->furniture_rental+$room->air_rental) }}
                                                            <input type="hidden" id="room-rent" value="{{ $room->rent+$room->furniture_rental+$room->air_rental }}">
                                                        </td>
                                                    </tr>
                                            
                                                    <tr>
                                                        <td class="align-top">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <label class="form-label" style="margin-bottom: 12px;">ค่าบริการ</label>
                                                                </div>
                                                                @foreach ($service as $ser)
                                                                    <div class="col-sm-12">
                                                                        <input 
                                                                            name="ref_service_id[]"
                                                                            type="checkbox" 
                                                                            class="form-check-input mb-3" 
                                                                            id="service_checkbox_{{ $ser->id }}" 
                                                                            value="{{ $ser->id }}" 
                                                                            @if (in_array($ser->id, $room_has_service)) checked @endif
                                                                            oninput="calculateTotal()"
                                                                        >
                                                                        <label class="custom-option-header" for="service_checkbox_{{ $ser->id }}">
                                                                            <span class="h6 mb-0">&nbsp;{{ $ser->name }}</span>
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                        
                                                        <td class="text-end">
                                                            <label class="form-label"> &nbsp; </label>
                                                                @foreach ($service as $ser2)
                                                                    {{-- <div class="col-sm-12"> --}}

                                                                        <input 
                                                                            name="service_price[{{$ser2->id}}]"
                                                                            type="number" 
                                                                            class="form-control text-end" 
                                                                            id="service_price_{{ $ser2->id }}" 
                                                                            value="{{ number_format($ser2->price) }}" 
                                                                            oninput="calculateTotal()"
                                                                        >
                                                                    {{-- </div> --}}
                                                                @endforeach
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td class="align-top">
                                                            <div class="row">
                                                                <div class="col-sm-12">
                                                                    <label class="form-label" style="margin-bottom: 12px;">ส่วนลด</label>
                                                                </div>
                                                                @foreach ($discount as $dis)
                                                                    <div class="col-sm-12">
                                                                        <input 
                                                                            name="ref_discount_id[]"
                                                                            type="checkbox" 
                                                                            class="form-check-input mb-3" 
                                                                            id="discount_checkbox_{{ $dis->id }}" 
                                                                            value="{{ $dis->id }}" 
                                                                            @if (in_array($dis->id, $room_has_discount)) checked @endif
                                                                            oninput="calculateTotal()"
                                                                        >
                                                                        <label class="custom-option-header" for="discount_checkbox_{{ $dis->id }}">
                                                                            <span class="h6 mb-0">&nbsp;{{ $dis->name }}</span>
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </td>
                                                        
                                                        <td class="text-end">
                                                            <label class="form-label"> &nbsp; </label>
                                                                @foreach ($discount as $dis2)
                                                                    {{-- <div class="col-sm-12"> --}}

                                                                        <input 
                                                                            name="discount_price[{{$dis2->id}}]"
                                                                            type="number" 
                                                                            class="form-control text-end" 
                                                                            id="discount_price_{{ $dis2->id }}" 
                                                                            value="{{ number_format($dis2->price) }}" 
                                                                            oninput="calculateTotal()"
                                                                        >
                                                                    {{-- </div> --}}
                                                                @endforeach
                                                        </td>
                                                    </tr>
                                                <tfoot>
                                                    <tr>
                                                        <th>รวม</th>
                                                        <th class="text-end fw-bold" id="total-price">0</th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                            <script>
                                                function calculateTotal() {
                                                    let total = 0;
                                                    
                                                    // ดึงค่าเช่าห้อง
                                                    const roomRent = parseFloat(document.getElementById('room-rent').value) || 0;
                                                    total += roomRent;
                                                
                                                    // เช็คค่าบริการ
                                                    @foreach ($service as $ser)
                                                        const checkbox{{ $ser->id }} = document.getElementById('service_checkbox_{{ $ser->id }}');
                                                        const price{{ $ser->id }} = parseFloat(document.getElementById('service_price_{{ $ser->id }}').value.replace(/,/g, '')) || 0;
                                                
                                                        if (checkbox{{ $ser->id }} && checkbox{{ $ser->id }}.checked) {
                                                            total += price{{ $ser->id }};
                                                        }
                                                    @endforeach
                                                
                                                    // เช็คส่วนลด (ลบออก)
                                                    @foreach ($discount as $dis)
                                                        const discountCheckbox{{ $dis->id }} = document.getElementById('discount_checkbox_{{ $dis->id }}');
                                                        const discountPrice{{ $dis->id }} = parseFloat(document.getElementById('discount_price_{{ $dis->id }}').value.replace(/,/g, '')) || 0;
                                                
                                                        if (discountCheckbox{{ $dis->id }} && discountCheckbox{{ $dis->id }}.checked) {
                                                            total -= discountPrice{{ $dis->id }}; // <<<<< ลบลดราคาออก
                                                        }
                                                    @endforeach
                                                
                                                    // แสดงผลรวม
                                                    document.getElementById('total-price').textContent = total.toLocaleString();
                                                }
                                                
                                                // เรียกครั้งแรกตอนเปิดหน้า
                                                calculateTotal();
                                                </script>
                                            <div></div>
                                            <div></div>
                                            {{-- <div class="col-sm-6">
                                                <label for="security_deposit" class="form-label">เงินประกันห้อง(บาท)</label>
                                                <input type="text" name="contract[1][security_deposit]" class="form-control" id="security_deposit" placeholder="" value="" required/>
                                            </div> --}}
                                            <div class="row" id="deposit-list">
                                                <div class="col-md-12 deposit-item mb-2">
                                                    <input type="hidden" name="contract[1][deposit][0][title]" class="form-control" required value="เงินประกันห้อง" />
                                                    <div class="col-md-12">
                                                        <label class="form-label">เงินประกันห้อง (บาท)</label>
                                                        <input type="number" name="contract[1][deposit][0][security_deposit]" class="form-control" placeholder="เงินประกันห้อง (บาท)" required />
                                                    </div>
                                                </div>
                                            </div>
                                                <!-- ปุ่มเพิ่มรายการ -->
                                            <div class="col-sm-12 text-end mb-3">
                                                <button type="button" id="add_expenses" class="btn btn-sm btn-warning">
                                                    <i class="ti ti-plus"></i> เพิ่มรายการเงินประกัน
                                                </button>
                                            </div>
                                            <div></div>
                                    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
                                    <script>
                                    $(document).ready(function () {
                                        let depositIndex = 1;

                                        // กดเพิ่มรายการใหม่
                                        $('#add_expenses').on('click', function () {
                                        const html = `
                                            <div class="col-md-12 deposit-item mb-2">
                                            <div class="row">
                                                <div class="col-md-6">
                                                <label class="form-label">ชื่อรายการ</label>
                                                <input type="text" name="contract[1][deposit][${depositIndex}][title]" class="form-control" placeholder="เช่น เงินประกันคีย์การ์ด" required />
                                                </div>
                                                <div class="col-md-4">
                                                <label class="form-label">จำนวนเงิน (บาท)</label>
                                                <input type="number" name="contract[1][deposit][${depositIndex}][security_deposit]" class="form-control" required />
                                                </div>
                                                <div class="col-md-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-danger btn-sm remove-expense">
                                                    ลบ
                                                </button>
                                                </div>
                                            </div>
                                            </div>
                                        `;
                                        $('#deposit-list').append(html);
                                        depositIndex++;
                                        });

                                        // กดลบ
                                        $('#deposit-list').on('click', '.remove-expense', function () {
                                        $(this).closest('.deposit-item').remove();
                                        });
                                    });
                                    </script>

                                            <!-- Container where new items will be appended -->
                                            <div id="expenses-list"></div>

                                            <!-- Template for the new expense item (hidden by default) -->
                                            <div id="new-expense-template" style="display: none;">
                                                <div class="expense-row d-flex mb-2">
                                                    <div class="col-sm-2">
                                                        <button
                                                            class="btn btn-sm buttons-collection btn-danger waves-effect waves-light me-2 remove-expense"
                                                            tabindex="0" aria-controls="DataTables_Table_0"
                                                            type="button" aria-haspopup="dialog"
                                                            aria-expanded="false">
                                                            <span>
                                                                <i class="ti ti-subtract"></i> ลบรายการ
                                                            </span>
                                                        </button>
                                                    </div>
                                                    <div class="col-sm-4 text-end me-2 d-flex align-items-center">
                                                        <input type="text" class="form-control" placeholder="รายละเอียด" />
                                                    </div>
                                                    <div class="col-sm-3 text-end me-2 d-flex align-items-center">
                                                        <input type="number" class="form-control" placeholder="จำนวนเงิน(บาท)" />
                                                    </div>
                                                    
                                                </div>
                                            </div>

                                            {{-- <div class="col-sm-6">
                                                <label for="deduction_booking_amount" class="form-label">ยอดยกจากค่าจองห้อง(บาท)</label>
                                                <input type="text" name="contract[1][deduction_booking_amount]" class="form-control" id="deduction_booking_amount" placeholder="" value="{{ @$contract->deposit }}" />
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="deduction_booking_date" class="form-label">หักค่าจองห้องเมื่อวันที่</label>
                                                <input type="text" name="contract[1][deduction_booking_date]" class="form-control" id="deduction_booking_date" placeholder="" autocomplete="off" value="{{ @$contract->payment_received_date != null ? date('d/m/Y', strtotime($contract->payment_received_date)) : ''; }}"/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="receipt_no" class="form-label">อ้างอิงจากใบเสร็จค่าจองเลขที่</label>
                                                <input type="text" name="contract[1][receipt_no]" class="form-control" id="receipt_no" placeholder="" value="{{ @$receipt->receipt_number }}"/>
                                            </div> --}}
                                            @endif

                                            <div></div>
                                            <div class="col-sm-6">
                                                <label for="water_meter_start_living" class="form-label">เลขมิเตอร์น้ำประปา(เข้าพัก)*</label>
                                                <input type="text" name="contract[1][water_meter_start_living]" class="form-control" id="water_meter_start_living" placeholder="" value="{{ @$contract->water_meter_start_living ?? $meter->water_unit }}"/>
                                            </div>
                                            <div class="col-sm-6">
                                                <label for="electricity_meter_start_living" class="form-label">เลขมิเตอร์ค่าไฟ(เข้าพัก)*</label>
                                                <input type="text" name="contract[1][electricity_meter_start_living]" class="form-control" placeholder="" required value="{{ @$contract->electricity_meter_start_living ?? $meter->electricity_unit }}"/>
                                            </div>
                                            <div class="col-sm-12">
                                                <label for="" class="form-label">หมายเหตุ</label>
                                                <textarea name="remark" class="form-control"></textarea>
                                            </div>
                                            
                                            <!-- JavaScript คำนวณรวม -->
                                            <script>
                                                // คำนวณวันที่เริ่มต้นเมื่อเอกสารโหลดเสร็จ
                                                // setTimeout(() => {
                                                    
                                                // }, 1000);
                                                // updateContractDateTo();

                                            function updateContractDateTo() {
                                                const contractDate = $('#contract_date').val();
                                                const periodMonths = parseInt($('#period').val(), 10);
                                                const contractDateToField = $('#contract_date_to');

                                                if (contractDate && periodMonths && !isNaN(periodMonths)) {
                                                    const dateParts = contractDate.split('/');
                                                    const contractDateObject = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
                                                    contractDateObject.setMonth(contractDateObject.getMonth() + periodMonths);
                                                    const endDate = contractDateObject.toLocaleDateString('en-GB');
                                                    contractDateToField.val(endDate);
                                                }
                                            }

                                            function initContractFormScript() {
                                                $('#contract_date').on('input', updateContractDateTo);
                                                $('#period').on('input', updateContractDateTo);
                                                updateContractDateTo(); // คำนวณครั้งแรก
                                            }

                                            // เรียกตอนโหลดเสร็จ
                                            $(document).ready(function(){
                                                initContractFormScript();
                                            });

                                            </script>
                                            
                                            <script>
                                                // $('#deduction_booking_date').datepicker({
                                                //     format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่
                                                //     autoclose: true,      // ปิด datepicker เมื่อเลือกวันที่
                                                //     todayHighlight: true  // ไฮไลต์วันที่ปัจจุบัน
                                                // });
                                            </script>
                                            <script>
                                                flatpickr('#contract_date', {
                                                    dateFormat: 'd/m/Y',
                                                    allowInput: true,
                                                    onChange: function() { updateContractDateTo(); }
                                                });
                                            </script>
                                            {{-- <script>
                                                $('#edit_asset').on('submit', function(event) {

                                                        event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
                                                        if(!this.checkValidity()) {
                                                            // ถ้าฟอร์มไม่ถูกต้อง
                                                            this.reportValidity();
                                                            return console.log('ฟอร์มไม่ถูกต้อง');
                                                        }
                                                        // return alert(123);
                                                        Swal.fire({
                                                            title: 'ยืนยันการดำเนินการ?',
                                                            text: 'คุณต้องการ แก้ไข ทรัพย์สิน หรือไม่?',
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
                                                                    url: '{{$page_url}}/asset/{{$room->id}}', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                                                                    type: 'POST',
                                                                    data: $(this).serialize(),
                                                                    success: function(response) {
                                                                        if(response == true){
                                                                            Swal.fire('แก้ไข ทรัพย์สิน เรียบร้อยแล้ว', '', 'success');
                                                                            loadData(page);
                                                                            view('{{$room->id}}');
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
                                                    
                                            </script> --}}
                                                <div class="modal-footer rounded-0 justify-content-center">
                                                    {{-- <button type="button" class="btn btn-label-secondary me-2">ปิด</button> --}}
                                                    <button type="submit" class="btn btn-main">บันทึก</button>
                                                </div>
                                        </form>
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
    
    {{-- ///////////////////////////////////////////////////////////// --}}
    {{-- @include('room/add-renter') --}}
    {{-- ///////////////////////////////////////////////////////////// --}}


    <!-- / Layout wrapper -->
    @include('layout/inc_js')
</body>

</html>
<iframe id="print-iframe" style="display: none;"></iframe>
<script>
    
        const fpOpts = { dateFormat: 'd/m/Y', allowInput: true };
        flatpickr('#contract_date', { ...fpOpts, onChange: function() { updateContractDateTo(); } });
        flatpickr('#contract_date_to', fpOpts);
        // $('#exampleFormControlInput33').datepicker({
        //     format: 'dd/mm/yyyy', // กำหนดรูปแบบของวันที่
        //     todayBtn: "linked",   // เพิ่มปุ่มวันนี้
        //     clearBtn: true,       // เพิ่มปุ่มล้างข้อมูล
        //     autoclose: true       // เมื่อเลือกวันที่แล้วจะปิดปฏิทิน
        // })
        
        $('#insert_check_in').on('submit', function(event) {  // อันนี้คือ เพิ่มการจอง
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
                
            }
            
            var reserve_deposit = $('#reserve_deposit').val();
            if(reserve_deposit < 1){
                return Swal.fire('กรุณากรอก ค่ามัดจำ', '', 'warning');
            }

            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ เข้าพัก หรือไม่?',
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
                        url: '/room/check-in', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response.message == null){
                                // $('#insert_check_in')[0].reset();
                                // Swal.fire('เพิ่มการจองเรียบร้อยแล้ว', '', 'success');
                                
                                Swal.fire('เข้าพักเรียบร้อยแล้ว', '', 'success').then((result) => {
                                    window.location.href = '/room';
                                    // location.reload();
                                });
                            }else{
                                Swal.fire({ html: `<div style="color:red; font-size: 20px;">${response.message}</div>`, icon: 'error'} );
                            }
                        },
                        error: function (xhr) {
                            if (xhr.responseJSON && xhr.responseJSON.errors) {
                                let messages = '';
                                $.each(xhr.responseJSON.errors, function (key, value) {
                                    messages += value + '<br>';
                                });

                                Swal.fire({
                                    title: 'เกิดข้อผิดพลาด',
                                    html: messages,
                                    icon: 'error',
                                });
                            } else {
                                Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                                console.error('เกิดข้อผิดพลาด:', xhr);
                            }
                        }
                    });
                } else if (result.isDismissed) {
                    // Swal.fire('ยกเลิกการดำเนินการ', '', 'info');
                }
            });
        });
    $(document).ready(function() {
        $('#select2Basic').on('change', function () {
            const provinceId = $(this).val();
            if (provinceId) {
            
                document.getElementById('loadingOverlay').style.display = 'flex';

            if (tomDistrict) {
                tomDistrict.destroy();
            }
            $('#select2District99').html('<option selected disabled hidden value="">เลือกอำเภอ</option>');

                $.ajax({
                    url: '/get-districts/' + provinceId,
                    type: 'GET',
                    success: function (data) {
                        data.forEach(function (district) {
                            $('#select2District99').append(
                                `<option value="${district.id}">${district.name_in_thai}</option>`
                            );
                        });

                        tomDistrict = new TomSelect("#select2District99", {
                            create: false,
                            maxItems: 1,
                            allowEmptyOption: true,
                            sortField: { field: "text", direction: "asc" }
                        });
                        document.getElementById('loadingOverlay').style.display = 'none';
                    }
                });
            }
        });

        $('#select2District99').on('change', function () {
            var districtId = $(this).val();
            
            if (districtId) {
            
                document.getElementById('loadingOverlay').style.display = 'flex';

            if (tomSubdistrict) {
                tomSubdistrict.destroy();
            }
            $('#select2Subdistrict').html('<option selected disabled hidden value="">เลือกตำบล</option>');

                $.ajax({
                    url: '/get-subdistricts/' + districtId,
                    type: 'GET',
                    success: function (data) {
                        data.forEach(function (subdistrict) {
                            $('#select2Subdistrict').append(
                                `<option value="${subdistrict.id}">${subdistrict.name_in_thai}</option>`
                            );
                        });

                        tomSubdistrict = new TomSelect("#select2Subdistrict", {
                            create: false,
                            maxItems: 1,
                            allowEmptyOption: true,
                            sortField: { field: "text", direction: "asc" }
                        });
                        document.getElementById('loadingOverlay').style.display = 'none';
                    }
                });
            }
        });

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
        
        $('#select2Subdistrict').change(function() {
            var subdistrictsid = $(this).val();
            if (subdistrictsid) {
                $.ajax({
                    url: '/get-zipcode/' + subdistrictsid,
                    type: 'GET',
                    success: function(data) {
                        $('#zipcode').val(data);
                    }
                });
            }
        });
    });

    $(document).ready(function() {
        $('.user-tags').on('itemAdded', function (event) {
            const value = event.item;
            $.ajax({
            url: 'room/reserve/chec-user',
            method: 'POST',
            data: {
                keyword: value,
                _token: '{{ csrf_token() }}'
            },
            success: function (res) {
                if (!res.found) {
                let tags = $('.bootstrap-tagsinput span.tag');
                    tags.each(function () {
                        if ($(this).text().trim() === value) {
                            $(this).addClass('invalid');
                        }
                    });
                }
            },
            error: function () {
                alert("เกิดข้อผิดพลาดในการเชื่อมต่อเซิร์ฟเวอร์");
            }
            });
        });
    });

</script>