{{-- Form ชำระ ค่า จองห้อง --}}
{{-- @php
    $id = []
@endphp --}}
@foreach ($rent_bill_s as $key => $rent_bill)

<input name="insert[{{ $key }}][ref_room_id]" type="hidden" value="{{ $rent_bill->ref_room_id }}">
<input name="insert[{{ $key }}][ref_rent_bill_id]" type="hidden" value="{{ $rent_bill->id }}">
<input name="insert[{{ $key }}][ref_contract_id]" type="hidden" value="{{ $rent_bill->contract_id }}">
<input name="insert[{{ $key }}][ref_renter_id]" type="hidden" value="{{ $rent_bill->ref_renter_id }}">
<input name="insert[{{ $key }}][ref_type_id]" type="hidden" value="3">
<input name="insert[{{ $key }}][amount]" class="total-price" type="hidden">

<h4 class="text-center text-danger">ยอดค้างชำระเงินทั้งหมด&nbsp; <span class="">
    {{ number_format($rent_bill->deposit) }}
    {{-- {{ number_format($rent_bill->room_for_rent->room->rent + $rent_bill->water_amount+$rent_bill->electricity_amount) }} --}}
    </span> &nbsp;บาท
</h4>
{{-- @php
    $id[] = [$rent_bill->room_name]
@endphp --}}
<div class="mb-3 pb-4" style="border: 1px solid #dbdade;padding: 15px 2px;">
    <div class="d-flex">
        <div class="flex-grow-1 ms-3 g-3 row">
            <b class="text-black">รูปแบบการชำระเงิน</b> <br>
                    <div class="col-sm-11">
                        <input name="insert[{{ $key }}][payment_format]" class="form-check-input me-1" type="hidden" id="payfullRes" value="1">
                        <label class="form-check-label" for="payfullRes"> จ่ายเต็มจำนวน </label>
                    </div>
                    <div class="col-sm-11" id="divsplit2">
                        
                        <div class="mb-3" style="border: 1px solid #dbdade;padding: 15px 2px;">
                            <div class="d-flex">
                                <div class="flex-grow-1 ms-3">
                                <b class="text-black">รายละเอียดหัวบิล</b> <br>
                                    {{ $rent_bill->full_name }} <br>
                                    เลขประจำตัวผู้เสียภาษี &nbsp; {{ $rent_bill->id_card_number }} <br>
                                    โทร &nbsp; {{ $rent_bill->phone }}
                                </div>
                            </div>
                        </div>
                        <table class="table table-detail border-dbdade" id="discount-table2">
                            <thead>
                                <tr>
                                    <th>รายการ</th>
                                    <th width="35%">จำนวนเงิน (บาท)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        รับชำระค่าจองห้อง {{ $rent_bill->room_name }}
                                        <input name="insert[{{ $key }}][payment_list][title][]" type="hidden" value="รับชำระค่าจองห้อง {{ $rent_bill->room_name }}">
                                    </td>
                                    <td class="text-end">
                                        {{-- {{ number_format($rent_bill->room_for_rent->room->rent) }} --}}
                                        {{ number_format($rent_bill->deposit) }}
                                        <input type="hidden" name="insert[{{ $key }}][payment_list][price][]" value="{{ $rent_bill->deposit }}">

                                    </td>
                                </tr>
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
                </div>
        </div>
    </div>
</div>
@endforeach

<div class="mb-3 pb-4" style="border: 1px solid #dbdade;padding: 15px 2px;">
    <div class="d-flex">
        <div class="flex-grow-1 ms-3 g-3 row">
            <b class="text-black">ช่องทางการชำระเงิน</b> <br>
            <div class="col-sm-11">
                <input name="insert_single[payment_channel]" class="form-check-input me-1 reservation_payment_channel" type="radio" id="reservation_payByCash" value="1" checked>
                <label class="form-check-label" for="reservation_payByCash"> เงินสด </label>
            </div>

            <div id="paymentChanel_Res2">
                <div class="col-sm-6 mb-2">
                    <label for="payment_date">วันที่ชำระเงิน</label>
                    <input type="text" name="insert_single[payment_date]" class="form-control" placeholder="" id="payment_date" autocomplete="off" value="{{date('d/m/Y')}}"/>
                </div>
            </div>

            <div class="col-sm-11">
                <input name="insert_single[payment_channel]" class="form-check-input me-1 reservation_payment_channel" type="radio" id="reservation_payByTransfer" value="2">
                <label class="form-check-label" for="reservation_payByTransfer"> โอนเงิน </label>
            </div>

            <!-- แสดงเมื่อเลือก โอนเงิน -->
            <div id="paymentChanel_Res" style="display:none;">
                <div class="col-sm-6 mb-2">
                    <label>เลือกบัญชีธนาคาร</label><span class="text-danger"> *</span>
                    <select class="select2 form-select mb-2" name="insert_single[ref_bank_id]" id="select2RenterReservation">
                        @foreach ($bank as $r_bank)
                            <option value="{{ $r_bank->id }}">{{ $r_bank->bank.' '.$r_bank->bank_account_name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-sm-3 mb-2">
                    <label for="transfer_time">เวลาโอนเงิน</label><span class="text-danger"> *</span>
                    <input type="time" name="insert_single[transfer_time]" class="form-control" placeholder="" id="transfer_time" autocomplete="off"/>
                </div>
                <div class="col-sm-6 mb-2">
                    <label for="payment_date2">วันที่โอนเงิน</label><span class="text-danger"> *</span>
                    <input type="text" name="insert_single[payment_date2]" class="form-control" placeholder="" id="payment_date2" autocomplete="off" value="{{date('d/m/Y')}}" required/>
                </div>
                <div class="col-sm-10 mt-3">
                    <label for="evidence_of_money_transfer">แนบหลักฐานการโอน</label>
                    <input type="file" name="insert_single[evidence_of_money_transfer]" class="form-control mb-2" id="evidence_of_money_transfer">
                    <div class="preview-container">
                        <img id="preview1" src="" alt="Preview 1" style="display: none; width:30%">
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
                calculatePrice();
            }
        });
        $(document).ready(function() {
            $('.total-price').html("{{ number_format($rent_bill->deposit) }}");
            $('.total-price').val("{{ $rent_bill->deposit }}");
        });
        $('.reservation_payment_channel').on('change', function() {
            const paymentChannel = $('.reservation_payment_channel:checked').val();

            if (paymentChannel === '2') {
                // แสดงช่องโอนเงิน
                $('#paymentChanel_Res').show();
                $('#paymentChanel_Res2').hide();

                // ใส่ required
                $('#ref_bank_id').attr('required', true);
                $('#transfer_time').attr('required', true);
                $('#payment_date2').attr('required', true);
            } else {
                // แสดงช่องเงินสด
                $('#paymentChanel_Res').hide();
                $('#paymentChanel_Res2').show();

                // เอา required ออก
                $('#ref_bank_id').removeAttr('required');
                $('#transfer_time').removeAttr('required');
                $('#payment_date2').removeAttr('required');
            }
        });

        // ให้รันตอนโหลดหน้าด้วย (กรณีมีค่า checked อยู่แล้ว)
        $(document).ready(function() {
            $('.reservation_payment_channel:checked').trigger('change');
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
        handleFileInput('evidence_of_money_transfer', 'preview1');

        calculatePrice();
        
        document.getElementById('add_discount2').addEventListener('click', function() {
            const tableBody = document.querySelector('#discount-table2 tbody');
            const newRow = document.createElement('tr');
            newRow.style.backgroundColor = 'rgb(252 228 228)'; // Set background color
            
            newRow.innerHTML = `
                <td>
                    <input name="discount_title" type="text" class="form-control" placeholder="หัวข้อส่วนลด" required />
                </td>
                <td class="text-end">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <input name="discount_price" type="number" class="form-control calculate discount_price" oninput="calculatePrice()" placeholder="จำนวนเงิน" required style="flex: 1;" autocomplete=off />
                        <button type="button" class="btn btn-danger btn-sm remove-row">ลบ</button>
                    </div>
                </td>
            `;
            
            tableBody.appendChild(newRow);
            addRemoveEvent(newRow);
        });

        document.getElementById('add_expenses2').addEventListener('click', function() {
            const tableBody = document.querySelector('#discount-table2 tbody');
            const newRow = document.createElement('tr');
            newRow.style.backgroundColor = 'rgb(255 240 225)'; // Set background color
            console.log(newRow);
            newRow.innerHTML = `
                <td>
                    <input name="expenses_title" type="text" class="form-control" placeholder="หัวข้อรายการ" required />
                </td>
                <td class="text-end">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <input name="expenses_price" type="number" class="form-control calculate add_expenses2_price" oninput="calculatePrice()" placeholder="จำนวนเงิน" required style="flex: 1;" autocomplete=off />
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
        $('#select2RenterReservation').select2();

        // เรียกใช้ฟังก์ชั่นเริ่มต้นเมื่อเพจโหลด
        // togglePaymentFields();
        

  </script>