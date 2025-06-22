<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<link rel="stylesheet" href="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />

<script src="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>

<input name="ref_room_id" type="hidden" value="{{ $contract->ref_room_id }}">
<input name="ref_rent_bill_id" type="hidden" value="{{ $rent_bill->id }}">
<input name="ref_contract_id" type="hidden" value="{{ $contract->contract_id }}">
<input name="ref_renter_id" type="hidden" value="{{ $contract->renter_id }}">
<input name="ref_type_id" type="hidden" value="2">
<input name="amount" class="total-price" type="hidden">

<h4 class="text-center text-danger">ยอดค้างชำระเงินทั้งหมด&nbsp; <span class="">
    {{ number_format($receipt_amount) }}
    {{-- {{ number_format($invoice->room_for_rent->room->rent + $invoice->water_amount+$invoice->electricity_amount) }} --}}
    </span> &nbsp;บาท
</h4>
<div class="mb-3 pb-4" style="border: 1px solid #dbdade;padding: 15px 2px;">
    <div class="d-flex">
        <div class="flex-grow-1 ms-3 g-3 row">
            <b class="text-black">รูปแบบการชำระเงิน</b> <br>
                    <div class="col-sm-11">
                        <input name="payment_format" class="form-check-input me-1" type="radio" id="payfull2" value="1" @if (count($receipt_security_deposit) == 0)
                        checked
                        @else
                        disabled
                        @endif 
                        {{-- @if ($contract[0]->payment_format == 2)
                        disabled
                        @endif  --}}
                        >
                        <label class="form-check-label" for="payfull2"> จ่ายเต็มจำนวน </label>
                    </div>
                    <div class="col-sm-11">
                        <input name="payment_format" class="form-check-input me-1" type="radio" id="checksplit2" value="2" @if (count($receipt_security_deposit) > 0)
                        checked
                        @endif> 
                        <label class="form-check-label" for="checksplit2"> แบ่งจ่าย </label>
                    </div>
                    <div class="col-sm-11" id="divsplit2"
                    @if (count($receipt_security_deposit) == 0)
                        style="display: none;"
                    @endif
                    >
                        
                        <div class="mb-3" style="border: 1px solid #dbdade;padding: 15px 2px;">
                            <div class="d-flex">
                                <div class="flex-grow-1 ms-3">
                                <b class="text-black">รายละเอียดหัวบิล</b> <br>
                                    {{ $contract->full_name }} <br>
                                    เลขประจำตัวผู้เสียภาษี {{ $contract->id_card_number }} <br>
                                    โทร {{ $contract->phone }}
                                </div>
                            </div>
                        </div>
                        <table class="table border-dbdade" id="discount-table2">
                            <thead>
                                <tr>
                                    <th>รายการ</th>
                                    <th width="35%">จำนวนเงิน (บาท)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        ค่าเงินประกันห้อง
                                        <input name="payment_list[title][]" type="hidden" value="ค่าเงินประกันห้อง">
                                    </td>
                                    <td class="text-end">
                                        @php
                                            $receipt_amount_total = $receipt_amount;
                                            if (count($receipt_security_deposit) == 0){
                                                $receipt_amount_total = $contract->security_deposit;
                                            }
                                        @endphp
                                        {{-- {{ number_format($invoice->room_for_rent->room->rent) }} --}}
                                        <input type="number" name="payment_list[price][]" class="form-control calculate" value="{{ (int) $receipt_amount_total }}" placeholder="จำนวนเงิน" max="{{ $receipt_amount_total }}" oninput="calculatePrice()">
                                    </td>
                                </tr>
                            @if (count($receipt_security_deposit) == 0)
                                <tr style="background-color: #e6e6e6">
                                    <td>
                                        หักจากค่าจองห้องพัก
                                        <input name="payment_list[title][]" type="hidden" value="หักจากค่าจองห้องพัก">
                                        <input name="discount" type="hidden" value="1">
                                    </td>
                                    <td class="text-end">
                                        {{-- {{ number_format($invoice->room_for_rent->room->rent) }} --}}
                                        <input type="number" name="payment_list[price][]" class="form-control calculate discount_price" value="{{ (int) $receipt_reservation->amount }}" placeholder="จำนวนเงิน" max="{{ $receipt_reservation->amount }}" oninput="calculatePrice()" readonly>
                                    </td>
                                </tr>
                            @endif
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>รวม</th>
                                    <th class="text-end mb-0 fw-bold total-price">
                                        0
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                        
                        {{-- ////////////////////////////////////////////////// --}}
                        <div class="mt-4 text-end col-12">
                            {{-- <button
                                    id="add_discount2"
                                    style="padding-right: 14px;padding-left: 14px;"
                                    class="btn btn-sm buttons-collection btn-label-danger waves-effect waves-light me-2"
                                    tabindex="0" aria-controls="DataTables_Table_0"
                                    type="button" aria-haspopup="dialog"
                                    aria-expanded="false">
                                <span>
                                <i class="ti ti-plus"></i> เพิ่มส่วนลด</span>
                            </button> --}}
                            <button
                                    id="add_expenses2"
                                    style="padding-right: 14px;padding-left: 14px;"
                                    class="btn btn-sm buttons-collection btn-label-warning waves-effect waves-light me-2"
                                    tabindex="0" aria-controls="DataTables_Table_0"
                                    type="button" aria-haspopup="dialog"
                                    aria-expanded="false">
                                <span>
                                <i class="ti ti-plus"></i> เพิ่มรายการ</span>
                            </button>
                        </div>
                        
                    {{-- <b>ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price">{{ number_format($invoice->room_for_rent->room->rent + $invoice->water_amount+$invoice->electricity_amount) }}</span> &nbsp;บาท</b> --}}
                </div>
        </div>
    </div>
</div>

<div class="mb-3 pb-4" style="border: 1px solid #dbdade;padding: 15px 2px;">
    <div class="d-flex">
        <div class="flex-grow-1 ms-3 g-3 row">
            <b class="text-black">ช่องทางการชำระเงิน</b> <br>
            <div class="col-sm-11">
                <input name="payment_channel" class="form-check-input me-1 deposit_payment_channel" type="radio" id="payByCash" value="1" checked>
                <label class="form-check-label" for="payByCash"> เงินสด </label>
            </div>

            <div id="paymentChanel_2">
                <div class="col-sm-6 mb-2">
                    <label for="payment_date">วันที่ชำระเงิน</label>
                    <input type="text" name="payment_date" class="form-control" placeholder="" id="payment_date" autocomplete="off" value="{{date('d/m/Y')}}"/>
                </div>
            </div>

            <div class="col-sm-11">
                <input name="payment_channel" class="form-check-input me-1 deposit_payment_channel" type="radio" id="payByTransfer" value="2">
                <label class="form-check-label" for="payByTransfer"> โอนเงิน </label>
            </div>

            <!-- แสดงเมื่อเลือก โอนเงิน -->
            <div id="paymentChanel_" style="display:none;">
                <div class="col-sm-6 mb-2">
                    <label>เลือกบัญชีธนาคาร</label>
                    <select class="select2 form-select mb-2" name="ref_bank_id" id="exampleFormControlSelect1">
                        @foreach ($bank as $r_bank)
                            <option value="{{ $r_bank->id }}">{{ $r_bank->bank.' '.$r_bank->bank_account_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3 mb-2">
                    <label for="transfer_time">เวลาโอนเงิน</label>
                    <input type="time" name="transfer_time" class="form-control" placeholder="" id="transfer_time" autocomplete="off"/>
                </div>
                <div class="col-sm-6 mb-2">
                    <label for="payment_date2">วันที่โอนเงิน</label>
                    <input type="text" name="payment_date2" class="form-control" placeholder="" id="payment_date2" autocomplete="off" value="{{date('d/m/Y')}}"/>
                </div>
                <div class="col-sm-10 mt-3">
                    <label for="evidence_of_money_transfer">แนบหลักฐานการโอน</label>
                    <input type="file" class="form-control mb-2" id="evidence_of_money_transfer" name="evidence_of_money_transfer">
                    <div class="preview-container">
                        <img id="preview_evidence_of_money_transfer" src="" alt="Preview 1" style="display: none; width:30%">
                    </div>
                </div>
            </div>


            <div class="col-sm-11 mt-3">
                <b id="totalpayfull2">ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price">
                    0
                </span> &nbsp;บาท</b>
                <b id="totalsplit" style="display: none">ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price_2">0</span> &nbsp;บาท</b>
            </div>
        </div>
    </div>
</div>

<script>
    
</script>

  
  <div class="modal-footer rounded-0 justify-content-center">
      <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ยกเลิก</button>
      <button class="btn btn-info" type="submit">
        <span>
        <i class="ti-sm ti ti-report-money"></i>
        <b class="dam">
          ชำระ
        </b>
      </span></button>
  </div>
  <script>
    
        $('#payment_date').datepicker({
            format: 'dd/mm/yyyy', // กำหนดรูปแบบของวันที่
            todayBtn: "linked",   // เพิ่มปุ่มวันนี้
            clearBtn: true,       // เพิ่มปุ่มล้างข้อมูล
            autoclose: true       // เมื่อเลือกวันที่แล้วจะปิดปฏิทิน
        })
        $('#payment_date2').datepicker({
            format: 'dd/mm/yyyy', // กำหนดรูปแบบของวันที่
            todayBtn: "linked",   // เพิ่มปุ่มวันนี้
            clearBtn: true,       // เพิ่มปุ่มล้างข้อมูล
            autoclose: true       // เมื่อเลือกวันที่แล้วจะปิดปฏิทิน
        })
        $('#checksplit2').on('change', function () {
            if (this.checked) {
                $('#divsplit2').show();
                $('#totalsplit').show();
                $('#totalpayfull2').hide();
                calculatePrice();
            }
        });
        $(document).ready(function() {
            $('.total-price').html("{{ number_format($receipt_amount) }}");
            $('.total-price').val("{{ $contract->security_deposit }}");
        });
        $('#payfull2').on('change', function () {
            if (this.checked) {
                $('#divsplit2').hide();
                $('#totalsplit').hide();
                $('#totalpayfull2').show();
                $('.total-price').html("{{ number_format($receipt_amount) }}");
                $('.total-price').val("{{ $contract->security_deposit }}");
            }
        });
        $('.deposit_payment_channel').on('change', function() {
            const paymentChannel = $('.deposit_payment_channel:checked').val();

            if (paymentChannel === '2') {
                $('#paymentChanel_').show();
                $('#paymentChanel_2').hide();
            } else {
                $('#paymentChanel_').hide();
                $('#paymentChanel_2').show();
            }
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
        calculatePrice();
        
        // document.getElementById('add_discount2').addEventListener('click', function() {
        //     const tableBody = document.querySelector('#discount-table2 tbody');
        //     const newRow = document.createElement('tr');
        //     newRow.style.backgroundColor = 'rgb(252 228 228)'; // Set background color
            
        //     newRow.innerHTML = `
        //         <td>
        //             <input name="payment_list_discount[title][]" type="text" class="form-control" placeholder="หัวข้อส่วนลด" required />
        //         </td>
        //         <td class="text-end">
        //             <div style="display: flex; align-items: center; gap: 10px;">
        //                 <input name="payment_list_discount[price][]" type="number" class="form-control calculate discount_price" oninput="calculatePrice()" placeholder="จำนวนเงิน" required style="flex: 1;" autocomplete=off />
        //                 <button type="button" class="btn btn-danger btn-sm remove-row">ลบ</button>
        //             </div>
        //         </td>
        //     `;
            
        //     tableBody.appendChild(newRow);
        //     addRemoveEvent(newRow);
        // });

        document.getElementById('add_expenses2').addEventListener('click', function() {
            const tableBody = document.querySelector('#discount-table2 tbody');
            const newRow = document.createElement('tr');
            newRow.style.backgroundColor = 'rgb(255 240 225)'; // Set background color
            console.log(newRow);
            newRow.innerHTML = `
                <td>
                    <input name="payment_list[title][]" type="text" class="form-control" placeholder="หัวข้อรายการ" required />
                </td>
                <td class="text-end">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <input name="payment_list[price][]" type="number" class="form-control calculate add_expenses2_price" oninput="calculatePrice()" placeholder="จำนวนเงิน" required style="flex: 1;" autocomplete=off />
                        <button type="button" class="btn btn-danger btn-sm remove-row">ลบ</button>
                    </div>
                </td>
            `;
            
            tableBody.appendChild(newRow);
            addRemoveEvent(newRow);
        });
    
        function addRemoveEvent(row) {
            row.querySelector('.remove-row').addEventListener('click', function() {
                row.remove();
                calculatePrice();
            });
        }
        
        function calculatePrice() { 
            const inputs = document.querySelectorAll('.calculate');  // เลือกทุก input ที่มี class="calculate"
            let total = 0;

            inputs.forEach(input => {
                // ลบเครื่องหมายจุลภาคจากค่าที่รับมา
                let value = input.value.replace(/,/g, ''); 
                
                if (value.trim() !== "" && !isNaN(value)) {
                    // ตรวจสอบว่า input มี class="discount_price" หรือไม่
                    if (input.classList.contains('discount_price')) {
                        // ถ้ามี class="discount_price", ลบค่าออกจาก total
                        total -= parseFloat(value.replace(/[^0-9.-]+/g, ""));
                    } else {
                        // ถ้าไม่มี class="discount_price", เพิ่มค่าเข้าไปใน total
                        if (!isNaN(value) && value.trim() !== "") {
                            total += parseFloat(value);
                        }
                    }
                }
            });
            console.log(total);
            $('.total-price').html(total.toLocaleString());
            $('.total-price').val(total);

            // อัปเดตค่า total ใน span#total-price
            // document.getElementById('total-price').innerText = total.toLocaleString();
        }
        $('#select2RenterContract').select2();

        // เรียกใช้ฟังก์ชั่นเริ่มต้นเมื่อเพจโหลด
        // togglePaymentFields();
        

  </script>