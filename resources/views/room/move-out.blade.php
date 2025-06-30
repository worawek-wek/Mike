{{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////

ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก
ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก

////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////////////////////////////////////////////////////////// --}}
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">

<style>
.no-data-box {
    background-color: #f8f9fa; /* สีเทาอ่อน */
    border: 1px dashed #dee2e6; /* ขอบเส้นประ */
    padding: 30px;
    text-align: center;
    color: rgb(40 199 111); /* สีน้ำเงินอ่อน (Bootstrap primary) */
    font-size: 1.1rem;
    border-radius: 6px;
    margin-top: 15px;
}
.modal-dialog {
  position: static !important;
}
</style>
                            <div class="alert alert-success text-black p-2" role="alert"> รายละเอียดสัญญาเช่า</div>
                                <table class="table table-detail table-bordered">
                                    <thead>
                                        <tr>
                                            <th width="50%" style="vertical-align: middle;font-weight: 500;">วันที่ทำสัญญา : 03/06/2024</th>
                                            <th width="50%" style="vertical-align: middle;font-weight: 500;">วันที่สิ้นสุดสัญญา : 28/06/2024</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> สถานะสัญญา </td>
                                            <td class="text-success">ยังไม่หมดสัญญา</td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    
                                    <ul class="nav nav-pills nav-fill p-4" role="tablist">
                                        <li class="nav-item pe-4">
                                            <button type="button" class="nav-link btn-warning active" id="meter_water" role="tab"
                                                data-bs-toggle="tab" data-bs-target="#navs-pills-top-home"
                                                aria-controls="navs-pills-top-home"
                                                aria-selected="true"
                                                onclick="showMoveOut()"
                                                >
                                                <i class="ti ti-door-exit me-1"></i>ผู้เช่าย้ายออก
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link btn-label-danger" id="meter_electricity" role="tab"
                                                data-bs-toggle="tab"
                                                data-bs-target="#navs-pills-top-profile"
                                                aria-controls="navs-pills-top-profile"
                                                aria-selected="false"
                                                onclick="showEscapes()"
                                                >
                                                <i class="ti ti-run me-1"></i>ผู้เช่าหนี
                                            </button>
                                        </li>
                                    </ul>
<script>
    function showMoveOut(){
        $('.showMoveOut').show();
    }
    function showEscapes(){
        $('.showMoveOut').hide();
    }
</script>
                                    <div class="tab-content p-0">
                                        <div class="tab-pane fade show active" id="navs-pills-top-home"
                                            role="tabpanel">
                                        </div>
                                        <div class="tab-pane fade" id="navs-pills-top-profile" role="tabpanel">
                                        </div>
                                    </div>
                                </div>

                                {{-- /////////////////////////////// --}}
                                
                                <label class="mb-0 text-black" style="font-weight: 500;font-size: large;" for="">
                                    <span class="badge badge-center rounded-pill bg-primary me-1" style="background-color: #54BAB9 !important;">1</span>
                                    รายการบิล
                                </label>
                                @if (@$move_invoice_7)

                                <table class="table table-detail table-bordered mt-4">
                                    <thead>
                                        <tr>
                                            <th style="vertical-align: middle;font-weight: 500;">รายการ</th>
                                            <th style="vertical-align: middle;font-weight: 500;">
                                                จำนวนเงิน (บาท)
                                            </th>
                                            <th class="showMoveOut">
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                บิลค่าเช่าห้องเดือน {{ $move_invoice_7->month.'/'.$move_invoice_7->year }}
                                                    <span class="mx-2 badge bg-label-danger">ค้างชำระ</span>
                                            </td>
                                            <td>
                                                <input class="price_increase" type="hidden" value="{{ 0-$move_invoice_7->balance_amount }}">
                                                <span>
                                                    {{-- {{ @$move_invoice_7->receipts->sum(fn($r) => $r->total_amount) }} --}}
                                                    {{-- @if ($move_invoice_7 && $move_invoice_7->receipts)
                                                        {{ $move_invoice_7->receipts->sum(fn($r) => $r->total_amount) }} บาท
                                                    @else --}}
                                                        {{ number_format($move_invoice_7->balance_amount) }}
                                                    {{-- @endif --}}
                                                </span>
                                            </td>
                                            <td class="showMoveOut">
                                                <div class="dropdown">
                                                  <button class="btn btn-main dropdown-toggle" type="button" id="paymentDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                    ยืนยันการชำระเงิน
                                                  </button>
                                                  <ul class="dropdown-menu" aria-labelledby="paymentDropdown">
                                                    <li><a class="dropdown-item" href="javascript:void(0)" onclick="pay(1)">ชำระเงิน</a></li>
                                                    {{-- <li><a class="dropdown-item" href="javascript:void(0)" onclick="pay(2)">หักจากเงินประกัน</a></li> --}}
                                                  </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <script>
                                    function pay(id){
                                        $('#pay_or').css('border', '1px solid rgb(219, 218, 222)');
                                        if(id == 1){
                                            $('#pay1').show();
                                            $('#pay2').hide();
                                        }else{
                                            $('#pay1').hide();
                                            $('#pay2').show();
                                        }
                                    }
                                  </script>
                                  <div id="pay_or" class="showMoveOut" style="padding: 15px 2px;">
                                    
                                    <form id="payment_bill" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <input name="ref_room_id" type="hidden" value="{{ $move_contract->ref_room_id }}">
                                        <input name="ref_rent_bill_id" type="hidden" value="{{ $move_invoice_7->id }}">
                                        <input name="ref_contract_id" type="hidden" value="{{ $move_contract->id }}">
                                        <input name="ref_renter_id" type="hidden" value="{{ $move_contract->ref_renter_id }}">
                                        <input name="ref_type_id" type="hidden" value="1">
                                        <input name="amount" class="total-price" type="hidden">

                                        <input type="hidden" name="id" value="{{$move_invoice_7->id}}">
                                    <div class="mt-3" id="pay1" style="display: none;">
                                        <div class="mb-3 pb-4" style="border: 1px solid #dbdade;padding: 15px 2px;">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 ms-3 g-3 row">
                                                    <b class="text-black">รูปแบบการชำระเงิน</b> <br>
                                                            <div class="col-sm-11">
                                                                <input name="payment_format" class="form-check-input" type="radio" id="payfull" value="1" 
                                                                @if (count($move_invoice_7->receipt) == 0)
                                                                checked    
                                                                @else
                                                                disabled
                                                                @endif
                                                                >
                                                                <label class="form-check-label" for="payfull"> จ่ายเต็มจำนวน </label>
                                                            </div>
                                                            <div class="col-sm-11">
                                                                <input name="payment_format" class="form-check-input" type="radio" id="checksplit" value="2"
                                                                @if (count($move_invoice_7->receipt) > 0)
                                                                checked    
                                                                @endif
                                                                disabled
                                                                > 
                                                                <label class="form-check-label" for="checksplit"> แบ่งจ่าย </label>
                                                            </div>
                                                
                                                            <div class="col-sm-11" id="divsplit" 
                                                                @if (count($move_invoice_7->receipt) == 0)
                                                                    style="display: none;"
                                                                @endif
                                                            >
                                                                
                                                                <div class="mb-3" style="border: 1px solid #dbdade;padding: 15px 2px;">
                                                                    <div class="d-flex">
                                                                        <div class="flex-grow-1 ms-3">
                                                                        <b class="text-black">รายละเอียดหัวบิล</b> <br>
                                                                            {{ $move_invoice_7->room_for_rent->renter->prefix.' '.$move_invoice_7->room_for_rent->renter->name.' '.$move_invoice_7->room_for_rent->renter->surname }} <br>
                                                                            เลขประจำตัวผู้เสียภาษี {{ $move_invoice_7->room_for_rent->renter->id_card_number }} <br>
                                                                            โทร {{ $move_invoice_7->room_for_rent->renter->phone }}
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <table class="table table-bordered" id="discount-table2" >
                                                                    <thead>
                                                                        <tr>
                                                                            <th>รายการ</th>
                                                                            <th width="35%">จำนวนเงิน (บาท)</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        <tr>
                                                                            <td>
                                                                                <input name="payment_list[title][]" type="text" class="form-control payment_list_title" value="แบ่งจ่ายค่าห้อง {{ $move_invoice_7->room_for_rent->room->name }}" placeholder="หัวข้อรายการ">
                                                                            </td>
                                                                            <td class="text-end">
                                                                                <input type="number" name="payment_list[price][]" class="form-control calculate_2" value="" placeholder="จำนวนเงิน" max="" oninput="calculate_2Price()">
                                                                            </td>
                                                                        </tr>
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th>รวม</th>
                                                                            <th class="text-end mb-0 fw-bold total-price_2">
                                                                                0
                                                                            </th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                                
                                                                <div align="right">
                                                                    <button
                                                                            id="add_expenses2"
                                                                            style="padding-right: 14px;padding-left: 14px;"
                                                                            class="btn btn-sm buttons-collection btn-label-warning waves-effect waves-light me-2 mt-2"
                                                                            tabindex="0" aria-controls="DataTables_Table_0"
                                                                            type="button" aria-haspopup="dialog"
                                                                            aria-expanded="false">
                                                                        <span>
                                                                        <i class="ti ti-plus"></i> เพิ่มรายการ</span>
                                                                    </button>
                                                                </div>
                                                                <div class="col-sm-11 mt-3 mb-3">
                                                                    <label>หมายเหตุ</label>
                                                                    <input name="remark" type="text" class="form-control" placeholder="หมายเหตุ" />
                                                                </div>
                                                                
                                                                <script>
                                                                    
                                                                document.getElementById('add_expenses2').addEventListener('click', function() {
                                                                    const tableBody = document.querySelector('#discount-table2 tbody');
                                                                    const newRow = document.createElement('tr');
                                                                    newRow.style.backgroundColor = 'rgb(255 240 225)'; // Set background color
                                                                    newRow.innerHTML = `
                                                                        <td>
                                                                            <input name="payment_list[title][]" type="text" class="form-control payment_list_title" placeholder="หัวข้อรายการ" required />
                                                                        </td>
                                                                        <td class="text-end">
                                                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                                                <input name="payment_list[price][]" type="number" class="form-control calculate_2 add_expenses2_price" oninput="calculate_2Price()" placeholder="จำนวนเงิน" required style="flex: 1;" autocomplete=off />
                                                                                <button type="button" class="btn btn-danger btn-sm remove-row2">ลบ</button>
                                                                            </div>
                                                                        </td>
                                                                    `;
                                                                    
                                                                    tableBody.appendChild(newRow);
                                                                    addRemoveEvent_2(newRow);
                                                                });
                                                            
                                                                function addRemoveEvent_2(row) {
                                                                    row.querySelector('.remove-row2').addEventListener('click', function() {
                                                                        row.remove();
                                                                        calculate_2Price();
                                                                    });
                                                                }

                                                                function calculate_2Price() { 
                                                                    const inputs = document.querySelectorAll('.calculate_2');  // เลือกทุก input ที่มี class="calculate"
                                                                    let total = 0;

                                                                    inputs.forEach(input => {
                                                                        // ลบเครื่องหมายจุลภาคจากค่าที่รับมา
                                                                        let value = input.value.replace(/,/g, ''); 
                                                                        
                                                                        if (value.trim() !== "" && !isNaN(value)) {
                                                                            // ตรวจสอบว่า input มี class="discount_price_2" หรือไม่
                                                                            if (input.classList.contains('discount_price_2')) {
                                                                                // ถ้ามี class="discount_price_2", ลบค่าออกจาก total
                                                                                total -= parseFloat(value.replace(/[^0-9.-]+/g, ""));
                                                                            } else {
                                                                                // ถ้าไม่มี class="discount_price_2", เพิ่มค่าเข้าไปใน total
                                                                                if (!isNaN(value) && value.trim() !== "") {
                                                                                    total += parseFloat(value);
                                                                                }
                                                                            }
                                                                        }
                                                                    });
                                                                    $('.total-price_2').html(total.toLocaleString());
                                                                    $('.total-price_2').val(total);

                                                                    // อัปเดตค่า total ใน span#total-price
                                                                    document.getElementById('total-price').innerText = total.toLocaleString();
                                                                }

                                                                </script>
                                                    
                                                    {{-- <b>ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price">{{ number_format($invoice->room_for_rent->room->rent + $invoice->water_amount+$invoice->electricity_amount) }}</span> &nbsp;บาท</b> --}}
                                                </div>
                                                        <div class="row mt-2" id="expenses-split-container">
                                                        </div>
                                                <script>
                                                    document.getElementById('checksplit').addEventListener('change', function() {
                                                        document.getElementById('divsplit').style.display = this.checked ? 'block' : 'none';
                                                        document.getElementById('totalsplit').style.display = this.checked ? 'block' : 'none';
                                                        document.getElementById('totalpayfull').style.display = this.checked ? 'none' : 'block';
                                                        $('.payment_list_title').attr('required', true);
                                                    });

                                                    document.getElementById('payfull').addEventListener('change', function() {
                                                        document.getElementById('divsplit').style.display = this.checked ? 'none' : 'block';
                                                        document.getElementById('totalsplit').style.display = this.checked ? 'none' : 'block';
                                                        document.getElementById('totalpayfull').style.display = this.checked ? 'block' : 'none';
                                                        $('.payment_list_title').removeAttr('required');

                                                    });
                                                </script>
                                            </div>
                                            </div>
                                        </div>

                                        <div class="mb-3 pb-4" style="border: 1px solid #dbdade;padding: 15px 2px;">
                                            <div class="d-flex">
                                                <div class="flex-grow-1 ms-3 g-3 row">
                                                    <b class="text-black">ช่องทางการชำระเงิน</b> <br>
                                                    <div class="col-sm-11">
                                                        <input name="payment_channel" class="form-check-input" type="radio" id="defaultRadio1" value="1" checked onclick="togglePaymentFields()">
                                                        <label class="form-check-label" for="defaultRadio1"> เงินสด </label>
                                                    </div>
                                                    
                                                    <div id="paymentDetails2">
                                                        <div class="col-sm-6 mb-2">
                                                            <label for="payment_date">วันที่ชำระเงิน</label>
                                                            <input type="text" name="payment_date" class="form-control" placeholder="" id="payment_date" required autocomplete="off" value="{{date('d/m/Y')}}"/>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-11">
                                                        <input name="payment_channel" class="form-check-input" type="radio" id="defaultRadio2" value="2" onclick="togglePaymentFields()"> 
                                                        <label class="form-check-label" for="defaultRadio2"> โอนเงิน </label>
                                                    </div>
                                        
                                                    <!-- แสดงเมื่อเลือก โอนเงิน -->
                                                    <div id="paymentDetails" style="display:none;">
                                                        
                                                        <div class="col-sm-6 mb-2">
                                                            <label>เลือกบัญชีธนาคาร</label>
                                                            <select class="select2 form-select mb-2" name="bank" id="exampleFormControlSelect1">
                                                                {{-- <option value="" disabled="" selected="selected">บัญชีธนาคาร</option> --}}
                                                                @foreach ($move_bank as $move_r_bank)
                                                                    <option value="{{ $move_r_bank->id }}">{{ $move_r_bank->bank.' '.$move_r_bank->bank_account_name }}</option>
                                                                @endforeach

                                                        </div>
                                                        <div class="col-sm-4 mb-2">
                                                            <input type="hidden" name="">
                                                        </div>
                                                            <div class="col-sm-3 mb-2">
                                                                <label for="transfer_time">เวลาโอนเงิน</label><span class="text-danger"> *</span>
                                                                <input type="time" name="transfer_time" class="form-control" placeholder="" id="transfer_time" autocomplete="off"/>
                                                            </div>
                                                            <div class="col-sm-6 mb-2">
                                                                <label for="payment_date2">วันที่โอนเงิน</label><span class="text-danger"> *</span>
                                                                <input type="text" name="payment_date2" class="form-control" placeholder="" id="payment_date2" autocomplete="off" value="{{date('d/m/Y')}}" required/>
                                                            </div>
                                                        <div class="col-sm-10 mt-3">
                                                            <label for="paymentReceipt">แนบหลักฐานการโอน</label>
                                                            <input name="evidence_of_money_transfer" type="file" class="form-control mb-2" id="paymentReceipt">
                                                            <div class="preview-container">
                                                                <img id="preview1" src="" alt="Preview 1" style="display: none; width:30%">
                                                            </div>
                                                        </div>
                                                    </div>
                                        
                                                    <div class="col-sm-11 mt-2">
                                                        <b id="totalpayfull">ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price">{{ number_format($move_invoice_7->balance_amount) }}</span> &nbsp;บาท</b>
                                                        <b id="totalsplit" style="display: none">ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price_2">0</span> &nbsp;บาท</b>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <script>
                                            function togglePaymentFields() {
                                                const paymentChannel = document.querySelector('input[name="payment_channel"]:checked').value;
                                                const paymentDetails = document.getElementById('paymentDetails');
                                                const paymentDetails2 = document.getElementById('paymentDetails2');
                                                // หากเลือก โอนเงิน (value=2) ให้แสดงฟอร์มเพิ่ม
                                                if (paymentChannel == '2') {
                                                    paymentDetails.style.display = 'block';
                                                    paymentDetails2.style.display = 'none';
                                                    $('#ref_bank_id').attr('required', true);
                                                    $('#transfer_time').attr('required', true);
                                                    $('#payment_date2').attr('required', true);
                                                } else {
                                                    paymentDetails.style.display = 'none';
                                                    paymentDetails2.style.display = 'block';
                                                    $('#ref_bank_id').removeAttr('required');
                                                    $('#transfer_time').removeAttr('required');
                                                    $('#payment_date2').removeAttr('required')
                                                }
                                            }
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
                                        
                                            handleFileInput('paymentReceipt', 'preview1');
                                            // เรียกใช้ฟังก์ชั่นเริ่มต้นเมื่อเพจโหลด
                                            togglePaymentFields();
                                        </script>

                                        <h4 class="text-center text-danger">ยอดค้างชำระเงินทั้งหมด&nbsp; <span class="">{{ number_format($move_invoice_7->total_amount - $move_invoice_7->receipt->pluck('payment_list')->flatten()->sum('price')) }}</span> &nbsp;บาท
                                        
                                        
                                        <div class="modal-footer rounded-0 justify-content-center">
                                            {{-- <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ยกเลิก</button> --}}
                                            <button class="btn btn-info" type="submit">
                                                <span>
                                                <i class="ti-md ti ti-report-money"></i>
                                                <b class="dam">
                                                ชำระ
                                                </b>
                                            </span></button>
                                        </div>
                                </div>
                                </form>
                                <form method="POST" action="/deduct-from-deposit" class="p-4 rounded" id="pay2" style="display: none;">
                                    <!-- หัวเรื่อง -->
                                    <h5 class="mb-3">บิลค้างชำระ</h5>
                                <hr>
                                    <!-- รายละเอียด -->
                                    <p><strong>เคลียร์บิลค้างชำระด้วยการนำไปหักจากเงินประกัน</strong></p>
                                    <div style="display: flex; justify-content: space-between;">
                                        <p>บิลค่าเช่าห้องเดือน {{ $move_invoice_7->month.'/'.$move_invoice_7->year }}</p>
                                        <p class="text-danger">ค้างชำระ: {{ number_format($move_invoice_7->balance_amount) }} บาท</p>
                                    </div>
                                      
                                
                                    <!-- วันที่หักเงิน -->
                                    <div class="mb-3">
                                        <label for="deduct_date" class="form-label" style="font-size: medium;"><strong>วันที่หักเงินประกัน</strong></label>
                                        <input type="text" id="deduct_date" name="deduct_date" class="form-control" value="21/04/2025" readonly>
                                    </div>
                                
                                    <!-- ปุ่ม -->
                                    <div class="d-flex justify-content-end">
                                        {{-- <a href="#" class="btn btn-outline-secondary me-2">ยกเลิก</a> --}}
                                        <button type="submit" class="btn btn-success">ตกลง</button>
                                    </div>
                                </form>
                            </div>
                                <div class="my-5 p-2 text-white" style="background-color: rgb(255, 73, 73);" align="center">
                                    ยอดค้างชำระ {{ number_format($move_invoice_7->balance_amount) }}
                                </div>
                            @else
                                <div class="no-data-box">
                                    ไม่มีข้อมูลบิลค้างชำระ
                                </div>
                            @endif

                                {{-- /////////////////////////////// --}}

                                <label class="mt-4 mb-0 text-black" style="font-weight: 500;font-size: large;" for="">
                                    <span class="badge badge-center rounded-pill bg-primary me-1" style="background-color: #54BAB9 !important;">2</span>
                                    รายการทรัพย์สิน (รับห้อง)
                                </label>
                                <style>
                                    .table-detail {
                                        border-collapse: collapse; /* รวมเส้นขอบของตาราง */
                                        /* border-radius: 10px; */
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
                                    .custom-file-upload {
                                        display: inline-block;
                                        cursor: pointer;
                                    }
                                    .custom-file-upload input[type="file"] {
                                        display: none;
                                    }
                                </style>
                                <table class="table table-bordered mt-4 table-detail">
                                    <thead>
                                        <tr>
                                            <th class="text-center">รายการ</th>
                                            <th class="text-center">
                                                สถานะทรัพย์สิน
                                            </th>
                                            <th class="text-center">
                                                ค่าปรับ
                                            </th>
                                            <th class="text-center">
                                                รูปภาพก่อนเข้าพัก
                                            </th>
                                            <th class="text-center">
                                                รูปภาพก่อนย้ายออก
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($asset as $key => $item)
                                        @if (@$item->room_has_asset->status == 0)
                                            @continue
                                        @endif
                                        <tr class="text-center">
                                            <td>
                                                {{ $item->name }}
                                            </td>
                                            <td class="text-start">
                                                <div>
                                                    <input name="condition[{{$key}}][]" class="form-check-input" type="radio" id="notDamaged{{$key}}" onclick="sia(0,'1_damaged{{$key}}')" @if($item->room_has_asset->condition == 1) checked @endif>
                                                    <label class="form-check-label" for="notDamaged{{$key}}"> ไม่เสียหาย </label>
                                                </div>
                                                <div>
                                                    <input name="condition[{{$key}}][]" class="form-check-input" type="radio" id="damaged{{$key}}" onclick="sia({{ $item->fine }},'1_damaged{{$key}}')" @if($item->room_has_asset->condition == 0) checked @endif> 
                                                    <label class="form-check-label" for="damaged{{$key}}"> เสียหาย </label>
                                                    <input type="hidden" id="1_damaged{{$key}}" class="price_increase">
                                                </div>
                                            </td>
                                            <td>
                                                <span >{{ number_format($item->fine) }}</span>
                                            </td>
                                            <td>
                                                @if ($item->room_has_asset->image_name == '')
                                                    ไม่ได้อัพโหลดรูป
                                                @else
                                                    <button class="btn btn-xs btn-label-info waves-effect text-black px-2"
                                                            onclick="showImage('{{ asset('upload/asset/' . $item->room_has_asset->image_name) }}')">
                                                        <i class="ti ti-photo me-1"></i>
                                                        ภาพก่อนเข้าพัก
                                                    </button>
                                                @endif
                                            </td>
                                            <td id="id_image_move_out{{$item->room_has_asset->id}}">
                                                @if (!$item->room_has_asset->image_move_out)
                                                    <button class="btn btn-xs btn-label-secondary waves-effect text-black px-2"
                                                            onclick="showUploadImage('{{ $item->room_has_asset->id }}')">
                                                        <i class="ti ti-photo me-1"></i> อัพโหลดหลักฐาน
                                                    </button>
                                                @else
                                                    <button class="btn btn-xs btn-label-info waves-effect text-black px-2"
                                                            onclick="showImage('{{ asset('upload/asset/' . $item->room_has_asset->image_move_out) }}')">
                                                        <i class="ti ti-photo me-1"></i>
                                                        ภาพก่อนย้ายออก
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                               
<script>
    function sia(fine, id){
        $('#'+id).val(0-fine);
        calculateTotal()
    }
    document.querySelector('input[name="evidence_file"]').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            alert("ไฟล์ที่เลือก: " + fileName);
        }
    });
    // setTimeout(() => {
    //     new TomSelect('#select2RenterMove');
    // }, 1000);
</script>

                                {{-- /////////////////////////////// --}}
                                
                                <label class="mt-4 text-black" style="font-weight: 500;font-size: large;" for="">
                                    <span class="badge badge-center rounded-pill bg-primary me-1" style="background-color: #54BAB9 !important;">3</span>
                                    ใบเสร็จย้ายออก
                                </label>
                                <div class="row g-2 pt-1">
                                    <div class="p-2">
                                        <label class="mb-1 text-black"><i class="ti ti-license text-main mb-1"></i> รายละเอียดหัวบิล</label>
                                            <select name="ref_renter_id" id="select2RenterMove" onchange="get_room_rental_contract(this.value)" required>
                                                <option selected disabled hidden value="no">เลือกข้อมูลจากผู้เช่า</option>
                                                @foreach ($renter as $rent)
                                                    <option value="{{ $rent->id }}">{{ $rent->prefix.' '.$rent->name.' '.$rent->surname }}</option>
                                                @endforeach
                                            </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="exampleFormControlInput1" class="form-label">ชื่อผู้เข้าพัก</label>
                                        <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="" value="" />
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="exampleFormControlInput2" class="form-label">ที่อยู่ผู้เข้าพัก</label>
                                        <input type="text" name="homeland" class="form-control" id="exampleFormControlInput2" placeholder="" value="" />
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="exampleFormControlInput3" class="form-label">เบอร์โทรผู้เข้าพัก</label>
                                        <input type="text" name="phone" class="form-control" id="exampleFormControlInput3" placeholder="" value="" />
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="exampleFormControlInput4" class="form-label">หมายเลขบัตรประชาชนผู้เข้าพัก</label>
                                        <input type="text" name="id_card_number" class="form-control" id="exampleFormControlInput4" placeholder="" value="" />
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="" class="form-label">หมายเหตุ</label>
                                        <textarea name="remark" class="form-control"></textarea>
                                    </div>
                                </div>
                                
                                {{-- <table class="table table-bordered mt-4 table-detail">
                                    <thead>
                                        <tr>
                                            <th width="70%">รายการ</th>
                                            <th>
                                                จำนวนเงิน(บาท)
                                            </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>
                                                ค่าเช่าห้อง
                                            </td>
                                            <td>
                                                0
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>
                                                รวมทั้งหมด
                                            </th>
                                            <th>
                                                0
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                                <div class="mt-4 text-end col-12">
                                    <button
                                            id="add_discount"
                                            style="padding-right: 14px;padding-left: 14px;"
                                            class="btn btn-sm buttons-collection btn-info waves-effect waves-light me-2"
                                            tabindex="0" aria-controls="DataTables_Table_0"
                                            type="button" aria-haspopup="dialog"
                                            aria-expanded="false">
                                        <span>
                                        <i class="ti ti-plus"></i> ค่าน้ำ-ค่าไฟฟ้าสุดท้าย</span>
                                    </button>
                                    <button
                                            id="add_discount"
                                            style="padding-right: 14px;padding-left: 14px;"
                                            class="btn btn-sm buttons-collection btn-danger waves-effect waves-light me-2"
                                            tabindex="0" aria-controls="DataTables_Table_0"
                                            type="button" aria-haspopup="dialog"
                                            aria-expanded="false">
                                        <span>
                                        <i class="ti ti-plus"></i> เพิ่มส่วนลด</span>
                                    </button>
                                    <button
                                            id="add_expenses"
                                            style="padding-right: 14px;padding-left: 14px;"
                                            class="btn btn-sm buttons-collection btn-warning waves-effect waves-light me-2"
                                            tabindex="0" aria-controls="DataTables_Table_0"
                                            type="button" aria-haspopup="dialog"
                                            aria-expanded="false">
                                        <span>
                                        <i class="ti ti-plus"></i> เพิ่มรายการ</span>
                                    </button>
                                </div> --}}

                                {{-- /////////////////////////////// --}}

                                <label class="my-4 text-black" style="font-weight: 500;font-size: large;" for="">
                                    <span class="badge badge-center rounded-pill bg-primary me-1" style="background-color: #54BAB9 !important;">3</span>
                                    เงินประกัน
                                </label>
                                        @if (@$move_invoice_2->payment_list)
                                
                                        <table class="table table-bordered" id="discount-table3" >
                                            <thead>
                                                <tr>
                                                    <th>รายการ</th>
                                                    <th width="35%">จำนวนเงิน (บาท)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach ($move_invoice_2->payment_list as $prakan)
                                                        <tr>
                                                            <td>
                                                                <input name="payment_list[title][]" type="text" class="form-control payment_list_title"  placeholder="หัวข้อรายการ" value="{{ $prakan->title }}">
                                                            </td>
                                                            <td class="text-end">
                                                                <input type="number" name="payment_list[price][]" class="form-control calculate_3 price_increase" value="{{ $prakan->price }}" placeholder="จำนวนเงิน" max="" oninput="calculate_3Price()">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                

                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>รวม</th>
                                                    <th class="text-end mb-0 fw-bold total-price_3">
                                                        {{ $move_invoice_2->payment_list->sum('price') }}
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                                @endif
                                        
                                        <div align="right">
                                            <button
                                                    id="add_expenses3"
                                                    style="padding-right: 14px;padding-left: 14px;"
                                                    class="btn btn-sm buttons-collection btn-label-warning waves-effect waves-light me-2 mt-2"
                                                    tabindex="0" aria-controls="DataTables_Table_0"
                                                    type="button" aria-haspopup="dialog"
                                                    aria-expanded="false">
                                                <span>
                                                <i class="ti ti-plus"></i> เพิ่มรายการ</span>
                                            </button>
                                        </div>
                                        <div class="col-sm-11 mt-3 mb-3">
                                            <label>หมายเหตุ</label>
                                            <input name="remark" type="text" class="form-control" placeholder="หมายเหตุ" />
                                        </div>
                                        
                                        <script>
                                            
                                        document.getElementById('add_expenses3').addEventListener('click', function() {
                                            const tableBody = document.querySelector('#discount-table3 tbody');
                                            const newRow = document.createElement('tr');
                                            newRow.style.backgroundColor = 'rgb(255 240 225)'; // Set background color
                                            newRow.innerHTML = `
                                                <td>
                                                    <input name="payment_list[title][]" type="text" class="form-control payment_list_title" placeholder="หัวข้อรายการ" required />
                                                </td>
                                                <td class="text-end">
                                                    <div style="display: flex; align-items: center; gap: 10px;">
                                                        <input name="payment_list[price][]" type="number" class="form-control calculate_3 add_expenses3_price price_increase" oninput="calculate_3Price()" placeholder="จำนวนเงิน" required style="flex: 1;" autocomplete=off />
                                                        <button type="button" class="btn btn-danger btn-sm remove-row3">ลบ</button>
                                                    </div>
                                                </td>
                                            `;
                                            
                                            tableBody.appendChild(newRow);
                                            addRemoveEvent_3(newRow);
                                        });
                                    
                                        function addRemoveEvent_3(row) {
                                            row.querySelector('.remove-row3').addEventListener('click', function() {
                                                row.remove();
                                                calculate_3Price();
                                            });
                                        }

                                        function calculate_3Price() { 
                                            const inputs = document.querySelectorAll('.calculate_3');  // เลือกทุก input ที่มี class="calculate"
                                            let total = 0;

                                            inputs.forEach(input => {
                                                // ลบเครื่องหมายจุลภาคจากค่าที่รับมา
                                                let value = input.value.replace(/,/g, ''); 
                                                
                                                if (value.trim() !== "" && !isNaN(value)) {
                                                    // ตรวจสอบว่า input มี class="discount_price_3" หรือไม่
                                                    if (input.classList.contains('discount_price_3')) {
                                                        // ถ้ามี class="discount_price_3", ลบค่าออกจาก total
                                                        total -= parseFloat(value.replace(/[^0-9.-]+/g, ""));
                                                    } else {
                                                        // ถ้าไม่มี class="discount_price_3", เพิ่มค่าเข้าไปใน total
                                                        if (!isNaN(value) && value.trim() !== "") {
                                                            total += parseFloat(value);
                                                        }
                                                    }
                                                }
                                            });
                                            $('.total-price_3').html(total.toLocaleString());
                                            $('.total-price_3').val(total);

                                            // อัปเดตค่า total ใน span#total-price
                                            // document.getElementById('total-price').innerText = total.toLocaleString();
                                            calculateTotal()
                                        }
                                </script>

                                {{-- /////////////////////////////// --}}
                                <div class="text-center">
                                    <span class="badge bg-label-success text-black mt-5" style="width: 100%;font-size: larger;">
                                        สรุปการย้ายออก
                                    </span>
                                    <h4 class="mt-2 amount">เงินจากการหักเงินประกัน 0 บาท</h4>
                                    
                                    <table class="table table-bordered mt-4 table-detail" style="width: 60%;margin: auto;">
                                        <thead>
                                        <tr class="text-start">
                                            <th>วันที่ย้ายออก</th>
                                            <th style="color: red !important;">
                                                25/06/2024
                                            </th>
                                        </tr>
                                        </thead>
                                    </table>
                                </div>
                                {{-- /////////////////////////////// --}}
                                <form id="move_out_submit">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $room->id }}">
                                    <div class="modal-footer rounded-0 justify-content-start mb-0">
                                        {{-- <button type="button" class="btn btn-label-primary waves-effect text-black"><span
                                                class="ti-md ti ti-printer me-2"></span>พิมพ์ใบย้ายออก
                                        </button> --}}
                                        <button type="submit" class="btn btn-main waves-effect ms-auto" onclick="paymentChannel(1)">
                                            บันทึกยอดเงินทั้งหมดแล้วย้ายออก
                                        </button>
                                    </div>
                                </form>
                                {{-- /////////////////////////////// --}}
                                <script>
                                    
                                    $('#move_out_submit').on('submit', function(event) {
                                        event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
                                        if(!this.checkValidity()) {
                                            // ถ้าฟอร์มไม่ถูกต้อง
                                            this.reportValidity();
                                            return console.log('ฟอร์มไม่ถูกต้อง');
                                        }
                                        // return alert(123);
                                        Swal.fire({
                                            title: 'ยืนยันการดำเนินการ?',
                                            text: 'คุณต้องการ ย้ายออก หรือไม่?',
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
                                                    url: '/room/move-out-submit', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                                                    type: 'POST',
                                                    data: $(this).serialize(),
                                                    success: function(response) {
                                                        if(response == true){
                                                            
                                                            var modalEl = document.getElementById('insurance');
                                                            var modalInstance = bootstrap.Modal.getInstance(modalEl); // <-- ดึง instance ที่เปิดอยู่
                                                            if (modalInstance) {
                                                                modalInstance.hide(); // <-- ซ่อน modal ที่เปิดอยู่จริง
                                                            }
                                                            
                                                            loadData(page);
                                                            summary();
                                                            Swal.fire('ย้ายออกเรียบร้อยแล้ว', '', 'success');
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
                                    calculateTotal()
                                    function calculateTotal() {
                                        let total = 0;
                                        const inputs = document.querySelectorAll('.price_increase');

                                        inputs.forEach(input => {
                                            const value = parseFloat(input.value) || 0;
                                            total += value;
                                        });

                                        const formatted = total.toLocaleString('th-TH', { minimumFractionDigits: 2 });
                                        const amountText = document.querySelector('.amount');

                                        if (amountText) {
                                            amountText.textContent = `ยอดเงินประกันคืนผู้เช่า ${formatted} บาท`;

                                            // เปลี่ยนสีตามค่าบวกหรือลบ
                                            if (total < 0) {
                                                amountText.style.color = 'red';
                                            } else if (total >= 0) {
                                                amountText.style.color = '#28c76f';
                                            } else {
                                                amountText.style.color = ''; // ค่าเป็น 0 กลับไปใช้ค่า default
                                            }
                                        }
                                    }
                                </script>
                                <script>
                                    $('#payment_bill').on('submit', function(event) {
                                        event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
                                        if(!this.checkValidity()) {
                                            // ถ้าฟอร์มไม่ถูกต้อง
                                            this.reportValidity();
                                            return console.log('ฟอร์มไม่ถูกต้อง');
                                        }
                                        // return alert(123);
                                        Swal.fire({
                                            title: 'ยืนยันการดำเนินการ?',
                                            text: 'คุณต้องการ บันทึกการเปลี่ยนแปลง หรือไม่?',
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

                                                var formData = new FormData($('#payment_bill')[0]);

                                                $.ajax({
                                                    url: 'bill/payment_bill', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                                                    type: 'POST',
                                                    data: formData,
                                                    processData: false,
                                                    contentType: false,
                                                    success: function(response) {
                                                        if(response == true){
                                                            // $('#invoice').modal('hide');
                                                            // summary();
                                                            loadData(page);
                                                            Swal.fire('บันทึกเรียบร้อยแล้ว', '', 'success');
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
                                    $('#meter_water').on('click', function() {
                                        $('.nav-link').removeClass('active btn-danger');
                                        $('#meter_electricity').addClass('btn-label-danger');
                                        $(this).removeClass('btn-label-warning');
                                        $(this).addClass('active btn-warning');
                                    });
                                    $('#meter_electricity').on('click', function() {
                                        $('.nav-link').removeClass('active btn-warning');
                                        $('#meter_water').addClass('btn-label-warning');
                                        $(this).removeClass('btn-label-danger');
                                        $(this).addClass('active btn-danger');
                                    });
                                </script>