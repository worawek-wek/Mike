{{-- ////////////////////////////////////////////////////////////////////////////////////////////////////////
ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก ย้ายออก
//////////////////////////////////////////////////////////////////////////////////////////////////////// --}}

<link href="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/css/tom-select.css" rel="stylesheet">
<!-- ก่อน </body> -->
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.3.1/dist/js/tom-select.complete.min.js"></script>

<link rel="stylesheet" href="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<script src="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>

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
                                            <th width="50%" style="vertical-align: middle;font-weight: 500;">วันที่ทำสัญญา : {{ date('d/m/Y', strtotime($move_contract->contract_date)) }}</th>
                                            <th width="50%" style="vertical-align: middle;font-weight: 500;">วันที่สิ้นสุดสัญญา : {{ date('d/m/Y', strtotime("+{$move_contract->period} months", strtotime($move_contract->contract_date))) }}</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td> สถานะสัญญา </td>
                                            @if (now()->lt(date('Y-m-d', strtotime("+{$move_contract->period} months", strtotime($move_contract->contract_date)))))
                                                <td class="text-danger">ยังไม่หมดสัญญา</td>
                                            @else
                                                <span class="text-success">หมดสัญญาแล้ว</span>
                                            @endif
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="row">
                                    
                                    <ul class="nav nav-pills nav-fill p-4" role="tablist">
                                        <li class="nav-item pe-4">
                                            <button type="button" class="nav-link btn-warning active" id="move-out-tab" role="tab"
                                                data-bs-toggle="tab" data-bs-target="#navs-pills-top-home"
                                                aria-controls="navs-pills-top-home"
                                                aria-selected="true"
                                                onclick="showMoveOut()"
                                                >
                                                <i class="ti ti-door-exit me-1"></i>ผู้เช่าย้ายออก
                                            </button>
                                        </li>
                                        <li class="nav-item">
                                            <button type="button" class="nav-link btn-label-danger" id="bad-debt-bill" role="tab"
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
        
        $('#bad-debt-bill').removeClass('active btn-danger btn-warning');
        $('#bad-debt-bill').addClass('btn-label-danger');
        $('#move-out-tab').removeClass('btn-label-warning');
        $('#move-out-tab').addClass('active btn-warning');

        $('#type_move_out').val(1);
        $('.showMoveOut').show();
        $('.label-move-out').css('background-color', '#54BAB9');
        $('#moveOutReceipt').show();
        $('#badDebtBill').hide();
        get_move_out_detail_receipt();
        $('#payment-receipt').show();
        $('#print-bad-debt-btn').attr('style', 'display: none !important;');
        $('#print-move-out-btn').show();
        
        
    }
    function showEscapes(){
        
        $('#move-out-tab').removeClass('active btn-danger btn-warning');
        $('#move-out-tab').addClass('btn-label-warning');
        $('#bad-debt-bill').removeClass('btn-label-danger');
        $('#bad-debt-bill').addClass('active btn-danger');

        $('#type_move_out').val(2);
        $('.showMoveOut').hide();
        $('.label-move-out').css('background-color', '#d34c4d');
        $('#badDebtBill').show();
        $('#moveOutReceipt').hide();
        get_move_out_detail_bad_debt_bill();
        $('#payment-receipt').hide();
        $('#print-bad-debt-btn').show();
        $('#print-move-out-btn').attr('style', 'display: none !important;');
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
                                    <span class="badge badge-center rounded-pill me-1 label-move-out" style="background-color: #54BAB9 !important;">1</span>
                                    รายการบิล
                                </label>
                                @if (@$move_invoice_7)
                                <input type="hidden" id="check-rent-bell" value="1">
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
                                                <input class="" type="hidden" value="{{ 0-$move_invoice_7->balance_amount }}">
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
                                        
                                        <input name="ref_room_for_rent_id" type="hidden" value="{{ $room_for_rent->id }}">
                                        <input name="ref_room_id" type="hidden" value="{{ $move_contract->ref_room_id }}">
                                        <input name="ref_rent_bill_id" type="hidden" value="{{ $move_invoice_7->id }}">
                                        <input name="ref_contract_id" type="hidden" value="{{ $move_contract->id }}">
                                        <input name="ref_renter_id" type="hidden" value="{{ $move_contract->ref_renter_id }}">
                                        <input name="ref_type_id" type="hidden" value="1">
                                        <input name="amount" class="total-price" type="hidden">

                                        <input type="hidden" name="id" value="{{$move_invoice_7->id}}">
                                    <div class="mt-3" id="pay1" style="display: none;">
                                        <div class="mb-3" style="padding: 15px 2px;">
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
                                                                {{-- @if (count($move_invoice_7->receipt) == 0)
                                                                    style="display: none;"
                                                                @endif --}}
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
                                                                <table class="table table-detail table-bordered" id="discount-table2" >
                                                                    <thead>
                                                                        <tr>
                                                                            <th>รายการ</th>
                                                                            <th width="35%">จำนวนเงิน (บาท)</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    @foreach ($move_invoice_7->payment_list as $key => $payment_list_item)
                                                                        <tr>
                                                                            {{-- <td>ค่าเช่าห้อง (Room rate) {{ $invoice->room_for_rent->room->name }} เดือน {{ $invoice->month.'/'.$invoice->year }}</td> --}}
                                                                            <td class="{{$payment_list_item->discount == 1 ? "text-danger fw-bold" : ""}}" style="align-items: center;">

                                                                                {{ $payment_list_item->title }}@if (strpos($payment_list_item->title, 'Water rate') !== false){{ number_format($payment_list_item->unit) }}&nbsp;- &nbsp;{{ $move_invoice_7->previous_water_unit ?? 0 }} = {{ $payment_list_item->unit-$move_invoice_7->previous_water_unit }} ยูนิต)@endif
                                                                            </td>
                                                                            <td class="text-end {{$payment_list_item->discount == 1 ? "text-danger fw-bold" : ""}}">
                                                                            @if ($key == 1)
                                                                                <input type="hidden" class="calculate" name="water_amount" id="water_amount" value="{{ $payment_list_item->price }}">
                                                                                    <span id="text_water_amount">
                                                                                        {{ number_format($payment_list_item->price) }}
                                                                                    </span>
                                                                            @else
                                                                                @if ($payment_list_item->discount == 1)
                                                                                    {{ number_format(0-$payment_list_item->price) }}
                                                                                    <input type="hidden" class="calculate" value="{{0-$payment_list_item->price}}">
                                                                                @else
                                                                                    {{ number_format($payment_list_item->price) }}
                                                                                    <input type="hidden" class="calculate" value="{{$payment_list_item->price}}">
                                                                                @endif
                                                                            @endif
                                                                            </td>
                                                                        </tr>
                                                                    @endforeach
                                                                    </tbody>
                                                                    <tfoot>
                                                                        <tr>
                                                                            <th>รวม</th>
                                                                            <th class="text-end mb-0 fw-bold total-price">
                                                                                {{ number_format($move_invoice_7->total_amount) }}
                                                                            </th>
                                                                        </tr>
                                                                    </tfoot>
                                                                </table>
                                                                
                                                                <div class="col-sm-12 mt-3 mb-3">
                                                                    <label>หมายเหตุ</label>
                                                                    <input name="remark" type="text" class="form-control" placeholder="หมายเหตุ" />
                                                                </div>
                                                    
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

                                        <div class="mb-3 pb-4" style="padding: 15px 2px;">
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
                                                            <input type="text" name="payment_date" class="form-control datepicker" placeholder="" id="payment_date" required autocomplete="off" value="{{date('d/m/Y')}}"/>
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
                                                                <input type="text" name="payment_date2" class="form-control datepicker" placeholder="" id="payment_date2" autocomplete="off" value="{{date('d/m/Y')}}" required/>
                                                            </div>
                                                        <div class="col-sm-10 mt-3">
                                                            <label for="paymentReceipt">แนบหลักฐานการโอน</label>
                                                            <input name="evidence_of_money_transfer" type="file" class="form-control mb-2" id="paymentReceipt" accept="image/*">
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
                                        <input type="text" id="deduct_date" name="deduct_date" class="form-control datepicker" value="21/04/2025" readonly>
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
                                @if (@$receipt_1)
                                {{-- @foreach ($receipt_1 as $key => $receipt) --}}
                                    <div class="p-4 mt-4" style="border: 1px solid #59d57a;border-radius: 5px;">
                                    <p align="right" style="color: black; font-weight: 500;">เลขที่ใบเสร็จ: &nbsp; <span class="text-success">{{ $receipt_1->receipt_number }}</span></p>
                                        <table class="table table-detail table-bordered">
                                            <thead>
                                                <tr>
                                                    <td width="50%">
                                                        <span style="color: black; font-weight: 500;">รายละเอียดหัวบิล</span> <br>
                                                        {{ $contract->full_name }} <br>
                                                        เลขประจำตัวผู้เสียภาษี {{ $contract->id_card_number }} <br>
                                                        โทร {{ $contract->phone }}
                                                    </td>
                                                    <td style="color: black;">
                                                                @php
                                                                    $date = new DateTime(date('Y-m-d', strtotime($receipt_1->created_at)));
                                                                    $englishDay = $date->format('l');
                                                                    
                                                                @endphp
                                                                    <span style="color: black; font-weight: 500;">วันที่รับชำระเงิน</span> &nbsp; &nbsp; &nbsp; {!! $days[$englishDay].' &nbsp;'.date('d/m/Y', strtotime($receipt_1->created_at)) !!}<br>
                                                                    <span style="color: black; font-weight: 500;">ช่องทางการชำระเงิน</span> &nbsp; &nbsp; &nbsp; {{ $receipt_1->payment_channel == 1 ? "เงินสด": "โอนเงิน"; }}<br>
                                                                    <span style="color: black; font-weight: 500;">รับชำระโดย</span> &nbsp; &nbsp; &nbsp; {{ $receipt_1->user->name }}<br>
                                                                    &nbsp;
                                                    </td>
                                                </tr>
                                            </thead>
                                        </table>
                                        <table class="table table-detail table-bordered mt-4">
                                            <thead>
                                                <tr>
                                                    <th width="70%" style="vertical-align: middle;font-weight: 500;">รายการ</th>
                                                    <th style="vertical-align: middle;font-weight: 500;">
                                                        จำนวนเงิน (บาท)
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $amount = 0;
                                                @endphp
                                                @foreach ($receipt_1->payment_list as $key => $item_payment_list)
                                                <tr>
                                                    <td class="{{$item_payment_list->discount == 1 ? "text-danger fw-bold" : ""}}">
                                                        {{ $item_payment_list->title }}
                                                    </td>

                                                        @if ($item_payment_list->discount == 1)
                                                            @php
                                                                $amount -= $item_payment_list->price;
                                                            @endphp
                                                            <td class="text-danger fw-bold">{{ number_format(0-$item_payment_list->price) }}</td>

                                                        @else
                                                            @php    
                                                            $amount += $item_payment_list->price;
                                                            @endphp
                                                            <td>{{ number_format($item_payment_list->price) }}</td>
                                                        @endif
                                                </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>รวม</th>
                                                    <th class=" mb-0 fw-bold" style="color: #28c76f !important;">
                                                    {{ number_format($amount) }}
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        {{--  --}}
                                        <div class="modal-footer rounded-0 justify-content-start mt-2 pb-0">
                                            <button type="button" class="btn btn-label-primary waves-effect" onclick="printPdf({{$receipt_1->id}})"><span
                                                    class="ti-sm ti ti-printer me-2"></span>พิมพ์ใบเสร็จรับเงิน</button>
                                        </div>
                                    </div>
                                @else
                                    <div class="no-data-box">
                                        ไม่มีข้อมูลบิลค้างชำระ
                                    </div>
                                @endif
                            @endif

                                {{-- /////////////////////////////// --}}

                                <label class="mt-4 mb-0 text-black" style="font-weight: 500;font-size: large;" for="">
                                    <span class="badge badge-center rounded-pill me-1 label-move-out" style="background-color: #54BAB9 !important;">2</span>
                                    รายการทรัพย์สิน (รับห้อง)
                                </label>
                                <style>
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
                                                    <input name="condition[{{$key}}][]" class="form-check-input" type="radio" id="notDamaged{{$key}}" onchange="sia(0,'1_damaged{{$key}}','')" @if($item->room_has_asset->condition == 1) checked @endif>
                                                    <label class="form-check-label" for="notDamaged{{$key}}"> ไม่เสียหาย </label>
                                                </div>
                                                <div>
                                                    <input name="condition[{{$key}}][]" class="form-check-input" type="radio" id="damaged{{$key}}" onchange="sia({{ $item->fine }},'1_damaged{{$key}}','{{$item->room_has_asset->asset->name}}')" @if($item->room_has_asset->condition == 0) checked @endif> 
                                                    <label class="form-check-label" for="damaged{{$key}}"> เสียหาย </label>
                                                    {{-- <input type="hidden" id="1_damaged{{$key}}" class="price_increase"> --}}
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
    function sia(fine, id, title){
        $('#'+id).val(0-fine);
        if(title == ''){
            $('#tr'+id).remove();
        }else{
            addRow(title, fine, 0, id)
        }
        calculateTotal()
        calculate_2Price();
    }
    document.querySelector('input[name="evidence_file"]').addEventListener('change', function(e) {
        const fileName = e.target.files[0]?.name;
        if (fileName) {
            alert("ไฟล์ที่เลือก: " + fileName);
        }
    });
</script>
                                {{-- //////////////// กรณี ย้ายออก /////////////// --}}
                                <div id="moveOutReceipt">
                                    <label class="mt-4 text-black" style="font-weight: 500;font-size: large;" for="">
                                        <span class="badge badge-center rounded-pill me-1 label-move-out" style="background-color: #54BAB9 !important;">3</span>
                                        ใบเสร็จย้ายออก
                                    </label>
                                    
                                    <form id="form_moveout_receipt">

                                        {{-- ajax ใส่ html ตรงนี้ นะจ๊ะ --}}
                                        {{-- @include('room/move-out-form-receipt') --}}
                                    
                                    </form>
                                </div>
                                {{-- /////////////////////////////// --}}

                                {{-- /////////////// กรณี ผู้เช่าหนี //////////////// --}}
                                <div id="badDebtBill" style="display: none;">
                                    <label class="mt-4 text-black" style="font-weight: 500;font-size: large;" for="">
                                        <span class="badge badge-center rounded-pill me-1 label-move-out" style="background-color: #54BAB9 !important;">3</span>
                                        รายการหนี้สูญ
                                    </label>
                                    
                                    <form id="form_bad_debt_bill">

                                        {{-- ajax ใส่ html ตรงนี้ นะจ๊ะ --}}
                                        {{-- @include('room/move-out-form-bad-debt-bill') --}}
                                    
                                    </form>
                                </div>
                                {{-- /////////////////////////////// --}}
                                <form id="form_edit_deposit_refund">
                                    @csrf
                                    <input type="hidden" name="invoice_id" value="{{ @$move_invoice_6->id }}">
                                    <label class="my-4 text-black" style="font-weight: 500;font-size: large;" for="">
                                        <span class="badge badge-center rounded-pill me-1 label-move-out" style="background-color: #54BAB9 !important;">4</span>
                                        เงินประกัน
                                    </label>
                                        @if (@$move_invoice_6->payment_list)
                                
                                        <table class="table table-bordered table-detail" id="discount-table3" >
                                            <thead>
                                                <tr>
                                                    <th>รายการ</th>
                                                    <th width="35%">จำนวนเงิน (บาท)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                    @foreach ($move_invoice_6->payment_list as $k => $prakan)
                                                    @php
                                                    if ($prakan->discount == 1) {
                                                        continue;
                                                    }
                                                        
                                                    @endphp
                                                        <tr>
                                                            <td>
                                                                @if ($k == 0)
                                                                    {{ $prakan->title }}
                                                                    <input name="payment_list_p[title][]" type="hidden" class="payment_list_title" value="{{ $prakan->title }}">
                                                                @else
                                                                    <input name="payment_list_p[title][]" type="text" class="form-control payment_list_title deposit-list" disabled placeholder="หัวข้อรายการ" value="{{ $prakan->title }}">
                                                                @endif
                                                            </td>
                                                            <td class="text-end">
                                                                <input type="number" name="payment_list_p[price][]" class="form-control calculate_3 price_increase deposit-list" value="{{ (int)$prakan->price }}" placeholder="จำนวนเงิน" max="" disabled oninput="calculate_3Price()">
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                

                                            </tbody>
                                            <tfoot>
                                                    <input type="hidden" class="total-price_3" id="deposit_amount" value="{{ $move_invoice_6->total_amount }}">
                                                <tr>
                                                    <th>รวม</th>
                                                    <th class="text-end mb-0 fw-bold total-price_3">
                                                        {{ $move_invoice_6->total_amount }}
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                                @endif
                                        
                                        <div id="save-deposit-refund" style="display: none;" align="right" class="mt-2">
                                            <button
                                                    id="add_expenses3"
                                                    style="padding-right: 14px;padding-left: 14px;"
                                                    class="btn btn-sm buttons-collection btn-label-warning waves-effect waves-light me-2"
                                                    tabindex="0" aria-controls="DataTables_Table_0"
                                                    type="button" aria-haspopup="dialog"
                                                    aria-expanded="false">
                                                <span>
                                                <i class="ti ti-plus"></i> เพิ่มรายการ</span>
                                            </button>
                                            
                                            <button 
                                                    style="padding-right: 14px;padding-left: 14px;"
                                                    class="btn buttons-collection btn-success waves-effect waves-light me-2"
                                                    tabindex="0" aria-controls="DataTables_Table_0"
                                                    type="submit" aria-haspopup="dialog"
                                                    aria-expanded="false">
                                                <span>
                                                <i class="fa fa-save me-1 fa-lg my-2"></i> บันทึกรายการคืนเงิน</span>
                                            </button>
                                        </div>
                                        <div id="edit-deposit-refund" align="right" class="mt-2">
                                            <button
                                                {{-- @if (@$receipt) disabled @endif --}}
                                                style="padding-right: 14px;padding-left: 14px;"
                                                class="btn buttons-collection btn-warning waves-effect waves-light"
                                                type="button"
                                                onClick="editFormDepositRefund()"
                                            >
                                                <i class="ti ti-pencil me-1"></i> แก้ไขรายการคืนเงินประกัน
                                            </button>
                                        </div>
                                        <div class="col-sm-11 mt-3 mb-3">
                                            <label>หมายเหตุ</label>
                                            <input name="remark" type="text" class="form-control" placeholder="หมายเหตุ" />
                                        </div>
                                </form>
                                        <script>
                                            function editFormDepositRefund(){
                                                $('#edit-deposit-refund').hide();
                                                $('#save-deposit-refund').show();
                                                $('.deposit-list').prop('disabled', false);
                                                
                                            }
                                        document.getElementById('add_expenses3').addEventListener('click', function() {
                                            const tableBody = document.querySelector('#discount-table3 tbody');
                                            const newRow = document.createElement('tr');
                                            newRow.style.backgroundColor = 'rgb(255 240 225)'; // Set background color
                                            newRow.innerHTML = `
                                                <td>
                                                    <input name="payment_list_p[title][]" type="text" class="form-control payment_list_title" placeholder="หัวข้อรายการ" required />
                                                </td>
                                                <td class="text-end">
                                                    <div style="display: flex; align-items: center; gap: 10px;">
                                                        <input name="payment_list_p[price][]" type="number" class="form-control calculate_3 add_expenses3_price" oninput="calculate_3Price()" placeholder="จำนวนเงิน" required style="flex: 1;" autocomplete=off />
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
                                            calculate_3Price();
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
                                            $('.amount').html('ยอดเงินประกันคืนผู้เช่า '+total.toLocaleString()+' บาท');
                                            $('.total-price_3').val(total);
                                            // อัปเดตค่า total ใน span#total-price
                                            // document.getElementById('total-price').innerText = total.toLocaleString();
                                        }
                                </script>

                                {{-- /////////////////////////////// --}}
                                <form id="move_out_submit" class="mb-5">
                                    @csrf
                                    <input type="hidden" id="type_move_out" name="type_move_out" value="1">
                                    <input type="hidden" name="room_id" value="{{ $room->id }}">
                                    <input type="hidden" name="ref_renter_id" value="{{ @$contract->ref_renter_id }}">
                                    <div class="text-center">
                                        <span class="badge bg-label-success text-black mt-5" style="width: 100%;font-size: larger;">
                                            สรุปการย้ายออก
                                        </span>
                                        {{-- <h4 class="my-4 amount">  </h4> --}}
                                        <h4 class="my-4">
                                            @if ($cal > 0)
                                            <span class="text-danger">
                                                ยอดเงินประกันคืนผู้เช่า
                                            @else
                                            <span class="text-success">
                                                เก็บเงินผู้เช่าเพิ่ม
                                            @endif
                                            &nbsp; {{ number_format(abs($cal)) }}&nbsp; บาท
                                            </span>
                                        </h4>
                                        <table class="table table-bordered mt-4 table-detail" style="width: 60%;margin: auto;">
                                            <thead>
                                            <tr class="text-start">
                                                <th>วันที่ย้ายออก</th>
                                                <th style="color: red !important;">
                                                    {{ date('d/m/Y') }}
                                                </th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </div>
                                    <div class="modal-footer rounded-0 justify-content-start mb-0">
                                        
                                        <button id="print-move-out-btn" type="button" class="btn btn-label-primary waves-effect text-black"
                                         onclick="printPdfInvoice({{ @$move_invoice_type_7->id }})"
                                        >
                                         <span
                                                class="ti-md ti ti-printer me-2"></span>พิมพ์ใบย้ายออก
                                        </button>

                                        <button id="print-bad-debt-btn" type="button" class="btn btn-label-primary waves-effect text-black"
                                        style="display: none!important;"
                                         onclick="printPdfInvoice({{ @$bad_debt_invoice->id }})"
                                        >
                                        
                                         <span
                                                class="ti-md ti ti-printer me-2"></span>พิมพ์ใบย้ายออก
                                        </button>
                                        {{-- <button type="button" class="btn btn-main waves-effect ms-auto"
                                        onclick="payment_bad_debt()"
                                        >
                                            บันทึกยอดเงินทั้งหมดแล้วย้ายออก
                                        </button> --}}
                                        {{-- <button type="submit" class="btn btn-main waves-effect ms-auto">
                                            บันทึกยอดเงินทั้งหมดแล้วย้ายออก
                                        </button> --}}
                                    </div>
                                    <script>
                                        
                                        function printPdfInvoice(id) {
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
                                        }
                                        function payment_bad_debt(){
                                            // $('#payment_bad_debt').show();
                                        }
                                    </script>
                                    <div id="payment_bad_debt">
                                        <input type="hidden" name="invoice_id" value="{{ @$move_invoice_type_7->id }}">
                                            <input name="ref_room_for_rent_id" type="hidden" value="{{ @$move_invoice_type_7->ref_room_for_rent_id }}">
                                            <input name="ref_room_id" type="hidden" value="{{ @$move_invoice_type_7->ref_room_id }}">
                                            <input name="ref_contract_id" type="hidden" value="{{ @$move_invoice_type_7->ref_contract_id }}">
                                            <input name="payment_format" type="hidden" value="1">
                                            
                                            <input name="ref_type_id" type="hidden" value="7">
                                            <input name="amount" type="hidden" value="{{ $cal }}">

                                            <input type="hidden" name="id" value="{{@$move_invoice_type_7->id}}">
                                            <h4 align="center">
                                                เคลียร์บิล
                                            </h4>
                                            <div class="mt-3" style="border: 1px solid #dbdade;padding: 15px 2px;">
                                                <div id="payment-receipt">
                                                    <div class="mb-3 pb-4" style="padding: 15px 2px;">
                                                        <div class="d-flex">
                                                            <div class="flex-grow-1 ms-3 g-3 row">
                                                                <b class="text-black">ช่องทางการชำระเงิน</b> <br>
                                                                <div class="col-sm-11">
                                                                    <input name="receipt_payment_channel" class="form-check-input" type="radio" id="radio_bad_debt1" value="1" checked onclick="togglePaymentBadDebtFields()">
                                                                    <label class="form-check-label" for="radio_bad_debt1"> เงินสด </label>
                                                                </div>
                                                                
                                                                <div id="bad_debtPaymentDetails2">
                                                                    <div class="col-sm-6 mb-2">
                                                                        <label for="payment_date">วันที่ชำระเงิน</label>
                                                                        <input type="text" name="payment_date" class="form-control datepicker" placeholder="" id="payment_date" required autocomplete="off" value="{{date('d/m/Y')}}"/>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-11">
                                                                    <input name="receipt_payment_channel" class="form-check-input" type="radio" id="radio_bad_debt2" value="2" onclick="togglePaymentBadDebtFields()"> 
                                                                    <label class="form-check-label" for="radio_bad_debt2"> โอนเงิน </label>
                                                                </div>
                                                    
                                                                <!-- แสดงเมื่อเลือก โอนเงิน -->
                                                                <div id="bad_debtPaymentDetails" style="display:none;">
                                                                    
                                                                    <div class="col-sm-6 mb-2">
                                                                        <label>เลือกบัญชีธนาคาร</label>
                                                                        <select class="select2 form-select mb-2" name="ref_bank_id" id="exampleFormControlSelect1">
                                                                            {{-- <option value="" disabled="" selected="selected">บัญชีธนาคาร</option> --}}
                                                                            @foreach ($move_bank as $move_r_bank)
                                                                                <option value="{{ $move_r_bank->id }}">{{ $move_r_bank->bank.' '.$move_r_bank->bank_account_name }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div class="col-sm-4 mb-2">
                                                                    </div>
                                                                        <div class="col-sm-3 mb-2">
                                                                            <label for="bad_debt_transfer_time">เวลาโอนเงิน</label><span class="text-danger"> *</span>
                                                                            <input type="time" name="transfer_time" class="form-control" placeholder="" id="bad_debt_transfer_time" autocomplete="off"/>
                                                                        </div>
                                                                        <div class="col-sm-3 mb-2">
                                                                            <label for="">วันที่โอนเงิน</label><span class="text-danger"> *</span>
                                                                            <input type="text" name="payment_date2" class="form-control datepicker" placeholder="" id="" autocomplete="off" value="{{date('d/m/Y')}}" required/>
                                                                        </div>
                                                                    <div class="col-sm-10 mt-3">
                                                                        <label for="paymentReceipt">แนบหลักฐานการโอน</label>
                                                                        <input name="evidence_of_money_transfer" type="file" class="form-control mb-2" id="paymentReceipt" accept="image/*">
                                                                        <div class="preview-container">
                                                                            <img id="preview1" src="" alt="Preview 1" style="display: none; width:30%">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                    
                                                                {{-- <div class="col-sm-11 mt-2">
                                                                    <b id="totalsplit" style="display: none">ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price_2">0</span> &nbsp;บาท</b>
                                                                    @if ($cal > 0)
                                                                    <span class="text-success">
                                                                        เก็บเงินผู้เช่าเพิ่ม
                                                                    @else
                                                                    <span class="text-danger">
                                                                        ยอดเงินประกันคืนผู้เช่า
                                                                    @endif
                                                                        {{ number_format(abs($cal)) }} บาท
                                                                    </span>
                                                                </div> --}}
                                                            </div>
                                                        </div>
                                                    </div>
                                                
                                                    <script>
                                                        $('.datepicker').datepicker({
                                                            format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่
                                                            autoclose: true,      // ปิด datepicker เมื่อเลือกวันที่
                                                            todayHighlight: true  // ไฮไลต์วันที่ปัจจุบัน
                                                        });
                                                        function togglePaymentBadDebtFields() {
                                                            const paymentChannel = document.querySelector('input[name="receipt_payment_channel"]:checked').value;
                                                            const bad_debtPaymentDetails = document.getElementById('bad_debtPaymentDetails');
                                                            const bad_debtPaymentDetails2 = document.getElementById('bad_debtPaymentDetails2');
                                                            // หากเลือก โอนเงิน (value=2) ให้แสดงฟอร์มเพิ่ม
                                                            if (paymentChannel == '2') {
                                                                bad_debtPaymentDetails.style.display = 'block';
                                                                bad_debtPaymentDetails2.style.display = 'none';
                                                                $('#bad_debt_ref_bank_id').attr('required', true);
                                                                $('#bad_debt_transfer_time').attr('required', true);
                                                                $('#bad_debt_payment_date2').attr('required', true);
                                                            } else {
                                                                bad_debtPaymentDetails.style.display = 'none';
                                                                bad_debtPaymentDetails2.style.display = 'block';
                                                                $('#bad_debt_ref_bank_id').removeAttr('required');
                                                                $('#bad_debt_transfer_time').removeAttr('required');
                                                                $('#bad_debt_payment_date2').removeAttr('required')
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
                                                        togglePaymentBadDebtFields();
                                                    </script>

                                                    <h4 class="text-center">
                                                        @if ($cal > 0)
                                                        <span class="text-danger">
                                                            ยอดเงินประกันคืนผู้เช่า
                                                        @else
                                                        <span class="text-success">
                                                            เก็บเงินผู้เช่าเพิ่ม
                                                        @endif
                                                             &nbsp; {{ number_format(abs($cal)) }}&nbsp; บาท
                                                        </span>
                                                    </h4>
                                                </div>
                                                <div class="modal-footer rounded-0 justify-content-center">
                                                    {{-- <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ยกเลิก</button> --}}
                                                    <button class="btn btn-info" type="submit">
                                                        <span>
                                                        <i class="ti-md ti ti-report-money"></i>
                                                        <b class="dam">
                                                        บันทึกยอดเงินทั้งหมดแล้วย้ายออก
                                                        </b>
                                                    </span></button>
                                                </div>
                                        </div>
                                    </div>

                                </form>
                                {{-- /////////////////////////////// --}}
                                <script>
                                    
                                    function calculateUsedRow(row) {
                                        // สำหรับน้ำ
                                        const waterOld = row.querySelector('.water-old');
                                        const waterNew = row.querySelector('.water-new');
                                        const waterUsed = row.querySelector('.water-used');

                                        if (waterOld && waterNew && waterUsed) {
                                            const old = parseFloat(waterOld.value) || 0;
                                            const _new = parseFloat(waterNew.value) || 0;
                                            const used = _new - old;
                                            waterUsed.value = used >= 0 ? used : 0;
                                        }

                                        // สำหรับไฟฟ้า
                                        const electricOld = row.querySelector('.electric-old');
                                        const electricNew = row.querySelector('.electric-new');
                                        const electricUsed = row.querySelector('.electric-used');

                                        if (electricOld && electricNew && electricUsed) {
                                            const old = parseFloat(electricOld.value) || 0;
                                            const _new = parseFloat(electricNew.value) || 0;
                                            const used = _new - old;
                                            electricUsed.value = used >= 0 ? used : 0;
                                        }
                                    }

                                    function calculateUsed(input) {
                                        const row = input.closest('tr');
                                        calculateUsedRow(row);
                                    }

                                    function editMeter() {
                                        const moveOutEditMeter = new bootstrap.Modal(document.getElementById('move-out-edit-meter'));
                                        moveOutEditMeter.show();
                                        $('.water-old').val('{{ intval(@$move_invoice_5->water_unit) }}');
                                        $('.electric-old').val('{{ intval(@$move_invoice_5->electricity_unit) }}');
                                        $('.water-new').val('{{ intval(@$meter->water_unit) }}');
                                        $('.electric-new').val('{{ intval(@$meter->electricity_unit) }}');

                                       document.querySelectorAll('tr').forEach(row => {
                                            calculateUsedRow(row);
                                        });
                                        
                                        // calculateUsed();
                                        // $('#view-edit-meter').html($('#v-edit-meter').html());
                                    }
                                    $('#move_out_submit').on('submit', function(event) {
                                        event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
                                        if(!this.checkValidity()) {
                                            // ถ้าฟอร์มไม่ถูกต้อง
                                            this.reportValidity();
                                            return console.log('ฟอร์มไม่ถูกต้อง');
                                        }
                                        // if(total_amount < 0){
                                        //     return Swal.fire('โปรดชำระเงินให้ครบก่อน.!', '', 'warning');
                                        // }
                                        var check = $('#check-rent-bell').val();
                                        if(check == 1){
                                            return Swal.fire('กรุณาเคลียร์บิลค่าเช่าก่อน.!', '', 'warning');
                                        }
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
                                    $('#form_moveout_receipt').on('submit', function(event) { // บันทึกบิลย้ายออก ใบเสร็จย้ายออก function save_moveout_receipt()
                                        event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
                                        if(!this.checkValidity()) {
                                            // ถ้าฟอร์มไม่ถูกต้อง
                                            this.reportValidity();
                                            return console.log('ฟอร์มไม่ถูกต้อง');
                                        }
                                        var amount_receipt_move_out = parseFloat($('#amount_receipt_move_out').html());

                                        // ถ้าไม่ใช่ตัวเลข ให้ตั้งค่าเป็น 0 เพื่อกัน error
                                        if (isNaN(amount_receipt_move_out)) {
                                            amount_receipt_move_out = 0;
                                        }

                                        if (amount_receipt_move_out < 0) {
                                            console.log('ยอดติดลบ');
                                            // เช่น เปลี่ยนสีข้อความให้เป็นแดง
                                            return Swal.fire('ยอดต้องไม่ติดลบ', '', 'warning');
                                        }

                                        Swal.fire({
                                            title: 'ยืนยันการดำเนินการ?',
                                            text: 'คุณต้องการ บันทึกใบเสร็จย้ายออก หรือไม่?',
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
                                                    url: '/room/save-move-out-receipt',
                                                    type: 'POST',
                                                    data: $(this).serialize(),
                                                    success: function(response) {
                                                        if(response == true){
                                                            get_move_out();
                                                            calculateTotal()
                                                            calculate_2Price()
                                                            loadData(page);
                                                            summary();
                                                            Swal.fire('บันทึกใบเสร็จย้ายออกเรียบร้อยแล้ว', '', 'success');
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
                                    $('#form_edit_deposit_refund').on('submit', function(event) { // บันทึกบิลย้ายออก ใบเสร็จย้ายออก function save_moveout_receipt()
                                        event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
                                        if(!this.checkValidity()) {
                                            // ถ้าฟอร์มไม่ถูกต้อง
                                            this.reportValidity();
                                            return console.log('ฟอร์มไม่ถูกต้อง');
                                        }
                                        // var amount_receipt_move_out = parseFloat($('#amount_receipt_move_out').html());

                                        // // ถ้าไม่ใช่ตัวเลข ให้ตั้งค่าเป็น 0 เพื่อกัน error
                                        // if (isNaN(amount_receipt_move_out)) {
                                        //     amount_receipt_move_out = 0;
                                        // }

                                        // if (amount_receipt_move_out < 0) {
                                        //     console.log('ยอดติดลบ');
                                        //     // เช่น เปลี่ยนสีข้อความให้เป็นแดง
                                        //     return Swal.fire('ยอดต้องไม่ติดลบ', '', 'warning');
                                        // }

                                        Swal.fire({
                                            title: 'ยืนยันการดำเนินการ?',
                                            text: 'คุณต้องการ บันทึกรายการคืนเงิน หรือไม่?',
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
                                                    url: '/room/update-deposit-refund',
                                                    type: 'POST',
                                                    data: $(this).serialize(),
                                                    success: function(response) {
                                                        if(response == true){
                                                            get_move_out();
                                                            calculateTotal()
                                                            calculate_2Price()
                                                            loadData(page);
                                                            summary();
                                                            Swal.fire('บันทึกรายการคืนเงินเรียบร้อยแล้ว', '', 'success');
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
                                    $('#form_bad_debt_bill').on('submit', function(event) { // บันทึกบิลย้ายออก ใบเสร็จย้ายออก function save_moveout_receipt()
                                        event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
                                        if(!this.checkValidity()) {
                                            // ถ้าฟอร์มไม่ถูกต้อง
                                            this.reportValidity();
                                            return console.log('ฟอร์มไม่ถูกต้อง');
                                        }
                                        var amount_receipt_move_out = parseFloat($('#amount_receipt_move_out').html());

                                        // ถ้าไม่ใช่ตัวเลข ให้ตั้งค่าเป็น 0 เพื่อกัน error
                                        if (isNaN(amount_receipt_move_out)) {
                                            amount_receipt_move_out = 0;
                                        }

                                        if (amount_receipt_move_out < 0) {
                                            console.log('ยอดติดลบ');
                                            // เช่น เปลี่ยนสีข้อความให้เป็นแดง
                                            return Swal.fire('ยอดต้องไม่ติดลบ', '', 'warning');
                                        }

                                        Swal.fire({
                                            title: 'ยืนยันการดำเนินการ?',
                                            text: 'คุณต้องการ บันทึกรายการหนี้สูญ หรือไม่?',
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
                                                    url: '/room/save-move-out-bad-debt-bill',
                                                    type: 'POST',
                                                    data: $(this).serialize(),
                                                    success: function(response) {
                                                        if(response == true){
                                                            get_move_out();
                                                            setTimeout(() => {
                                                                showEscapes();
                                                                calculateTotal()
                                                                calculate_2Price()
                                                                loadData(page);
                                                                summary();
                                                            }, 1000);
                                                            Swal.fire('บันทึกรายการหนี้สูญเรียบร้อยแล้ว', '', 'success');
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
                                    
                                    
                                    function calculate_2Price() {
                                        let total = 0;

                                        $('#discount-table2 tbody tr').each(function () {
                                            const priceInput = $(this).find('input[name="payment_list[price][]"]');
                                            const price = parseFloat(priceInput.val());

                                            if (!isNaN(price)) {
                                                // ถ้ามี class discount-value คือรายการส่วนลด (ลบ)
                                                if (priceInput.hasClass('form-price_increase')) {
                                                    total -= price;
                                                } else {
                                                    // รายการปกติ บวกเพิ่ม
                                                    total += price;
                                                }
                                            }
                                        });

                                        $('.total-price_2').text(
                                            total.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })
                                        );
                                    }
                                    var total_amount = 0;
                                    // setTimeout(() => {
                                    //     calculateTotal()
                                    // }, 2000);
                                    function calculateTotal() {
                                        let total = 0;

                                        // รวบรวมค่าปกติ
                                        document.querySelectorAll('.price_increase').forEach(input => {
                                            const value = parseFloat(input.value) || 0;
                                            total += value;
                                            // alert(value);
                                        });
                                        // alert(total);
                                        // ลบค่าที่เป็นส่วนลด
                                        document.querySelectorAll('.discount-value').forEach(input => {
                                            const value = parseFloat(input.value) || 0;
                                            total -= value; // คิดเป็นลบเสมอ
                                            // alert(value);
                                        });
                                        
                                        const formatted = total.toLocaleString('th-TH', { minimumFractionDigits: 2 });
                                        const amountText = document.querySelector('.amount');

                                        if (amountText) {

                                            // เปลี่ยนสีตามค่าบวกหรือลบ
                                            if (total < 0) {
                                                total = total*(-1);
                                                const formatted = total.toLocaleString('th-TH', { minimumFractionDigits: 2 });
                                                amountText.style.color = '#28c76f';
                                                amountText.textContent = `เก็บเงินผู้เช่าเพิ่ม ${formatted} บาท`;
                                            } else if (total > 0) {
                                                amountText.style.color = 'red';
                                                amountText.textContent = `ยอดเงินประกันคืนผู้เช่า ${formatted} บาท`;
                                            } else {
                                                amountText.style.color = ''; // default
                                            }
                                        }
                                        total_amount = total;
                                        // alert(total);
                                    }
                                    $(document).on('input', '.price_increase, .discount-value', function () {
                                        calculateTotal();
                                    });
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
                                                            get_move_out()
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
                                </script>
                                