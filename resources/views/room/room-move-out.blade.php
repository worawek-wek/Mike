{{-- Form ชำระ ค่า จองหลายห้อง --}}
{{-- @php
    $id = []
@endphp --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<link rel="stylesheet" href="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />

<script src="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>

<div class="m-2 mt-4" style="border: 1px solid #dbdbdb;border-radius: 5px;">
    <h5 class="border-bottom p-2 m-0" style="background-color: rgb(255, 248, 237);">
        <i class="tf-icons ti ti-browser-plus text-main" style="font-size: 25px;vertical-align: baseline;"></i>
        รายการห้อง
    </h5>
    <div class="px-4 pb-4">
        @foreach ($room as $key => $row)
        <input type="hidden" name="invoice_id" value="{{ @$row['move_invoice_4']->id }}">
        <label class="my-4 text-success" style="font-weight: 500;font-size: large;" for="">
            {{ $row->name }}
        </label>
        {{-- @if (@$row['move_invoice_4']->payment_list) --}}
            <table class="table table-bordered table-detail mb-4" id="discount-table3" >
                <thead>
                    <tr>
                        <th>รายการใบเสร็จย้ายออก</th>
                        <th width="35%">จำนวนเงิน (บาท)</th>
                    </tr>
                </thead>
                <tbody>
                        @php
                            $amount_receipt = 0;
                        @endphp
                        @forelse ($row['move_invoice_4']->payment_list ?? [] as $key => $row)
                        @php
                            $amount_receipt += $row->price;
                        @endphp
                            <tr>
                                <td>
                                    <input name="payment_list_p[title][]" type="text" class="form-control payment_list_title" placeholder="หัวข้อรายการ" value="{{ $row->title }}">
                                </td>
                                <td class="text-end">
                                    <input type="number" name="payment_list_p[price][]" class="form-control calculate_3 price_increase receipt-list" value="{{ (int)$row->price }}" placeholder="จำนวนเงิน" max="" oninput="calculate_receipt({{ $key }})">
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td>
                                    <input name="payment_list_p[title][]" type="text" class="form-control payment_list_title" placeholder="หัวข้อรายการ" value="">
                                </td>
                                <td class="text-end">
                                    <input type="number" name="payment_list_p[price][]" class="form-control calculate_3 price_increase receipt-list" value="0" placeholder="จำนวนเงิน" max="" oninput="calculate_receipt({{ $key }})">
                                </td>
                            </tr>
                        @endforelse
                </tbody>
                <tfoot>
                        <input type="hidden" class="total-receipt{{ $key }}" value="{{ $amount_receipt }}">
                    <tr>
                        <th>รวม</th>
                        <th class="text-end mb-0 fw-bold total-receipt{{ $key }}">
                            {{ $amount_receipt }}
                        </th>
                    </tr>
                </tfoot>
            </table>
            <table class="table table-bordered table-detail" id="discount-table3" >
                <thead>
                    <tr>
                        <th>รายการคืนเงินประกัน</th>
                        <th width="35%">จำนวนเงิน (บาท)</th>
                    </tr>
                </thead>
                <tbody>
                        @foreach ($row['move_invoice_6']->payment_list ?? [] as $k => $prakan)
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
                                        <input name="payment_list_p[title][]" type="text" class="form-control payment_list_title deposit-list" placeholder="หัวข้อรายการ" value="{{ $prakan->title }}">
                                    @endif
                                </td>
                                <td class="text-end">
                                    <input type="number" name="payment_list_p[price][]" class="form-control calculate_3 price_increase deposit-list" value="{{ (int)$prakan->price }}" placeholder="จำนวนเงิน" max="" oninput="calculate_3Price()">
                                </td>
                            </tr>
                        @endforeach
                    

                </tbody>
                <tfoot>
                        <input type="hidden" class="total-price_3" id="deposit_amount" value="{{ isset($row['move_invoice_6']) ? $row['move_invoice_6']->payment_list->sum('price') : 0 }}">
                    <tr>
                        <th>รวม</th>
                        <th class="text-end mb-0 fw-bold total-price_3">
                            {{ isset($row['move_invoice_6']) ? $row['move_invoice_6']->payment_list->sum('price') : 0 }}
                        </th>
                    </tr>
                </tfoot>
            </table>
        {{-- @endif --}}
        @endforeach
    </div>
</div>
<div class="m-2 mt-4" style="border: 1px solid #dbdbdb;border-radius: 5px;">
    <h5 class="border-bottom p-2" style="background-color: rgb(255, 248, 237);">
        <i class="tf-icons ti ti-browser-plus text-main" style="font-size: 25px;vertical-align: baseline;"></i>
        ชำระเงิน
    </h5>
    <div class="px-4">
        <div class="mb-3 pb-4" style="border: 1px solid #dbdade;padding: 15px 2px;">
            <div class="d-flex">
                <div class="flex-grow-1 ms-3 g-3 row">
                    <b class="text-black">ช่องทางการชำระเงิน</b> <br>
                    <div class="col-sm-11">
                        <input name="insert_single[payment_channel]" class="form-check-input me-1 reservation_payment_channel_Lhai" type="radio" id="reservation_payByCashLhai" value="1" checked>
                        <label class="form-check-label" for="reservation_payByCashLhai"> เงินสด </label>
                    </div>

                    <div id="paymentChanel_ResLhai2">
                        <div class="col-sm-6 mb-2">
                            <label for="payment_date_lhai">วันที่ชำระเงิน</label>
                            <input type="text" name="insert_single[payment_date]" class="form-control" placeholder="" id="payment_date_lhai" autocomplete="off" value="{{date('d/m/Y')}}"/>
                        </div>
                    </div>

                    <div class="col-sm-11">
                        <input name="insert_single[payment_channel]" class="form-check-input me-1 reservation_payment_channel_Lhai" type="radio" id="reservation_payByTransferLhai" value="2">
                        <label class="form-check-label" for="reservation_payByTransferLhai"> โอนเงิน </label>
                    </div>

                    <!-- แสดงเมื่อเลือก โอนเงิน -->
                    <div id="paymentChanel_ResLhai" style="display:none;">
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
                            <label for="payment_date_lhai2">วันที่โอนเงิน</label><span class="text-danger"> *</span>
                            <input type="text" name="insert_single[payment_date]" class="form-control" placeholder="" id="payment_date_lhai2" autocomplete="off" value="{{date('d/m/Y')}}" required/>
                        </div>
                        <div class="col-sm-10 mt-3">
                            <label for="evidence_of_money_transfer">แนบหลักฐานการโอน</label>
                            <input type="file" name="insert_single[evidence_of_money_transfer]" class="form-control mb-2" id="evidence_of_money_transfer" accept="image/*">
                            <div class="preview-container">
                                <img id="preview1" src="" alt="Preview 1" style="display: none; width:30%">
                            </div>
                        </div>
                    </div>

                    <div class="col-sm-11 mt-3">
                        <b id="totalpayfull2">ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price-lhai">
                            0
                        </span> &nbsp;บาท</b>
                        <b id="totalsplit" style="display: none">ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price-lhai_2">0</span> &nbsp;บาท</b>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  <script>
        function calculate_receipt(k){
            let total = 0;

            $('.receipt-list').each(function() {
                total += parseFloat($(this).val()) || 0; // ถ้าเป็น input
                // total += parseFloat($(this).text()) || 0; // ถ้าเป็น text ใน span/div
            });

            $('.total-receipt'+k).val(total);
            $('.total-receipt'+k).html(total);
        }
        $('#payment_date_lhai').datepicker({
            format: 'dd/mm/yyyy', // กำหนดรูปแบบของวันที่
            todayBtn: "linked",   // เพิ่มปุ่มวันนี้
            clearBtn: true,       // เพิ่มปุ่มล้างข้อมูล
            autoclose: true       // เมื่อเลือกวันที่แล้วจะปิดปฏิทิน
        })
        $('#payment_date_lhai2').datepicker({
            format: 'dd/mm/yyyy', // กำหนดรูปแบบของวันที่
            todayBtn: "linked",   // เพิ่มปุ่มวันนี้
            clearBtn: true,       // เพิ่มปุ่มล้างข้อมูล
            autoclose: true       // เมื่อเลือกวันที่แล้วจะปิดปฏิทิน
        })
        $('.reservation_payment_channel_Lhai').on('change', function() {
            const paymentChannelLhai = $('.reservation_payment_channel_Lhai:checked').val();

            if (paymentChannelLhai === '2') {
                // แสดงช่องโอนเงิน
                $('#paymentChanel_ResLhai').show();
                $('#paymentChanel_ResLhai2').hide();

                // ใส่ required
                $('#ref_bank_id').attr('required', true);
                $('#transfer_time').attr('required', true);
                $('#payment_date_lhai2').attr('required', true);
            } else {
                // แสดงช่องเงินสด
                $('#paymentChanel_ResLhai').hide();
                $('#paymentChanel_ResLhai2').show();

                // เอา required ออก
                $('#ref_bank_id').removeAttr('required');
                $('#transfer_time').removeAttr('required');
                $('#payment_date_lhai2').removeAttr('required');
            }
        });

        // ให้รันตอนโหลดหน้าด้วย (กรณีมีค่า checked อยู่แล้ว)
        $(document).ready(function() {
            $('.reservation_payment_channel_Lhai:checked').trigger('change');
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

        calculateLhaiPrice();
        
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
                        <input name="discount_lhai_price" type="number" class="form-control calculateLhai discount_lhai_price" oninput="calculateLhaiPrice()" placeholder="จำนวนเงิน" required style="flex: 1;" autocomplete=off />
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
                        <input name="expenses_price" type="number" class="form-control calculateLhai add_expenses2_price" oninput="calculateLhaiPrice()" placeholder="จำนวนเงิน" required style="flex: 1;" autocomplete=off />
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
                calculateLhaiPrice();
            });
        }
        
        function calculateLhaiPrice() { 
            const inputs = document.querySelectorAll('.calculateLhai');  // เลือกทุก input ที่มี class="calculateLhai"
            let total = 0;

            inputs.forEach(input => {
                // ลบเครื่องหมายจุลภาคจากค่าที่รับมา
                let value = input.value.replace(/,/g, ''); 
                
                if (value.trim() !== "" && !isNaN(value)) {
                    // ตรวจสอบว่า input มี class="discount_lhai_price" หรือไม่
                    if (input.classList.contains('discount_lhai_price')) {
                        // ถ้ามี class="discount_lhai_price", ลบค่าออกจาก total
                        total -= parseFloat(value.replace(/[^0-9.-]+/g, ""));
                    } else {
                        // ถ้าไม่มี class="discount_lhai_price", เพิ่มค่าเข้าไปใน total
                        if (!isNaN(value) && value.trim() !== "") {
                            total += parseFloat(value);
                        }
                    }
                }
            });
            console.log(total);
            $('.total-price-lhai').html(total.toLocaleString());
            $('.total-price-lhai').val(total);

            // อัปเดตค่า total ใน span#total-price-lhai
            // document.getElementById('total-price-lhai').innerText = total.toLocaleString();
        }
        $('#select2RenterReservation').select2();

        // เรียกใช้ฟังก์ชั่นเริ่มต้นเมื่อเพจโหลด
        // togglePaymentFields();
        
    function deleteBillReserveRoom(id){
        if ($('.billReserveRoom').length > 1) {
            $("#billReserveRoom"+id).remove();
        } else {
            Swal.fire('ไม่สามารถลบได้', 'การชำระค่าจองต้องมีอย่างน้อย 1 ห้อง', 'warning');
        }
    }

  </script>