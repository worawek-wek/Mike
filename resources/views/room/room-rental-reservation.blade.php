{{-- Form ชำระ ค่า จองหลายห้อง --}}
{{-- @php
    $id = []
@endphp --}}

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

@foreach ($rent_bill_s as $key => $rent_bill)

{{-- @php
    $id[] = [$rent_bill->room_name]
@endphp --}}
<div class="mb-3 pb-4 billReserveRoom" style="border: 1px solid #dbdade;padding: 15px 2px;" id="billReserveRoom{{$rent_bill->id}}">
    
<input name="insert[{{ $key }}][ref_room_id]" type="hidden" value="{{ $rent_bill->ref_room_id }}">
<input name="insert[{{ $key }}][ref_rent_bill_id]" type="hidden" value="{{ $rent_bill->id }}">
<input name="insert[{{ $key }}][ref_contract_id]" type="hidden" value="{{ $rent_bill->contract_id }}">
<input name="insert[{{ $key }}][ref_renter_id]" type="hidden" value="{{ $rent_bill->ref_renter_id }}">
<input name="insert[{{ $key }}][ref_type_id]" type="hidden" value="3">
<input name="insert[{{ $key }}][amount]" class="total-price-lhai" type="hidden">

        <div class="d-flex justify-content-end align-items-center">
            <a href="javascript:void(0)" onclick="deleteBillReserveRoom({{$rent_bill->id}})" class="pb-4 pe-4">
                <i class="fa fa-trash text-danger"></i>
            </a>
        </div>
<h4 class="text-center text-danger">ยอดค้างชำระเงินทั้งหมด&nbsp; <span class="">
    {{ number_format($rent_bill->deposit) }}
    {{-- {{ number_format($rent_bill->room_for_rent->room->rent + $rent_bill->water_amount+$rent_bill->electricity_amount) }} --}}
    </span> &nbsp;บาท
</h4>
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
                                        <input type="hidden" name="insert[{{ $key }}][payment_list][price][]" class="calculateLhai" value="{{ $rent_bill->deposit }}">

                                    </td>
                                </tr>
                            </tbody>
                            <tfoot>
                                <tr>
                                    <th>รวม</th>
                                    <th class="text-end mb-0 fw-bold">
                                        {{ number_format($rent_bill->deposit) }}
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

  <script>
    
        flatpickr('#payment_date_lhai', { dateFormat: 'd/m/Y', allowInput: true });
        flatpickr('#payment_date_lhai2', { dateFormat: 'd/m/Y', allowInput: true });
        // $('#checksplit2').on('change', function () {
        //     if (this.checked) {
        //         $('#divsplit2').show();
        //         $('#totalsplit').show();
        //         calculateLhaiPrice();
        //     }
        // });
        // $(document).ready(function() {
        //     $('.total-price-lhai').html("{{ number_format($rent_bill->deposit) }}");
        //     $('.total-price-lhai').val("{{ $rent_bill->deposit }}");
        // });
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