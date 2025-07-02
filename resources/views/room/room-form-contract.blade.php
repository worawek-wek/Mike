        {{-- อันนี้แหละ หน้า สัญญาเช่า -> Form ทำสัญญา --}}
        {{-- อันนี้แหละ หน้า สัญญาเช่า -> Form ทำสัญญา --}}
        {{-- อันนี้แหละ หน้า สัญญาเช่า -> Form ทำสัญญา --}}
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
        <link rel="stylesheet" href="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
        
        <script src="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>

        <div class="col-sm-5">
            <label for="exampleFormControlInput1" class="form-label">ชื่อผู้เข้าพัก</label>
            <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="" value="{{ @$contract->full_name }}" />
        </div>
        <div class="col-sm-7">
            <label for="exampleFormControlInput2" class="form-label">ที่อยู่ผู้เข้าพัก</label>
            <input type="text" name="address" class="form-control" id="exampleFormControlInput2" placeholder="" value="{{ @$contract->address }}" />
        </div>
        <div class="col-sm-6">
            <label for="exampleFormControlInput3" class="form-label">เบอร์โทรผู้เข้าพัก</label>
            <input type="text" name="phone" class="form-control" id="exampleFormControlInput3" placeholder="" value="{{ @$contract->phone }}" />
        </div>
        <div class="col-sm-6">
            <label for="exampleFormControlInput4" class="form-label">หมายเลขบัตรประชาชนผู้เข้าพัก</label>
            <input type="text" name="id_card_number" class="form-control" id="exampleFormControlInput4" placeholder="" value="{{ @$contract->id_card_number }}" />
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
                        {{ number_format($room->rent) }}
                        <input type="hidden" id="room-rent" value="{{ $room->rent }}">
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
        <div class="col-sm-6">
            <label for="security_deposit" class="form-label">เงินประกันห้อง(บาท)</label>
            <input type="text" name="contract[1][security_deposit]" class="form-control" id="security_deposit" placeholder="" value="" required/>
        </div>
        <div class="col-sm-6 d-flex align-items-end pb-1">
            <button
                id="add_expenses"
                class="btn btn-sm buttons-collection btn-warning waves-effect waves-light me-2"
                tabindex="0" aria-controls="DataTables_Table_0"
                type="button" aria-haspopup="dialog"
                aria-expanded="false">
                <span>
                <i class="ti ti-plus"></i> เพิ่มรายการเงินประกัน</span>
            </button>
        </div>
        <div></div>

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

        <div class="col-sm-6">
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
        </div>
        @endif

        <div></div>
        <div class="col-sm-6">
            <label for="water_meter_start_living" class="form-label">เลขมิเตอร์น้ำประปา(เข้าพัก)*</label>
            <input type="text" name="contract[1][water_meter_start_living]" class="form-control" id="water_meter_start_living" placeholder="" value="{{ $meter->water_unit }}"/>
        </div>
        <div class="col-sm-6">
            <label for="electricity_meter_start_living" class="form-label">เลขมิเตอร์ค่าไฟ(เข้าพัก)*</label>
            <input type="text" name="contract[1][electricity_meter_start_living]" class="form-control" placeholder="" required value="{{ $meter->electricity_unit }}"/>
        </div>
        <div class="col-sm-12">
            <label for="" class="form-label">หมายเหตุ</label>
            <textarea name="remark" class="form-control"></textarea>
        </div>
        
        <!-- JavaScript คำนวณรวม -->
        <script>
            // คำนวณวันที่เริ่มต้นเมื่อเอกสารโหลดเสร็จ
            updateContractDateTo();

            function initContractFormScript() {
                const contractDateField = $('#contract_date');
                const periodField = $('#period');
                const contractDateToField = $('#contract_date_to');

                // ใช้ on('input') แทน .change() เพื่อให้ตอบสนองทันทีที่พิมพ์
                contractDateField.on('input', updateContractDateTo);
                periodField.on('input', updateContractDateTo);

                function updateContractDateTo() {
                    const contractDate = contractDateField.val();
                    const periodMonths = parseInt(periodField.val(), 10);

                    if (contractDate && periodMonths && !isNaN(periodMonths)) {
                        const dateParts = contractDate.split('/');
                        const contractDateObject = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
                        contractDateObject.setMonth(contractDateObject.getMonth() + periodMonths);
                        const endDate = contractDateObject.toLocaleDateString('en-GB');
                        contractDateToField.val(endDate);
                    }
                }

                updateContractDateTo(); // คำนวณค่าตอนเริ่ม
            }

        </script>
        
        <script>
            $('#deduction_booking_date').datepicker({
                format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่
                autoclose: true,      // ปิด datepicker เมื่อเลือกวันที่
                todayHighlight: true  // ไฮไลต์วันที่ปัจจุบัน
            });
        </script>
        <script>
            $('#contract_date').datepicker({
                    format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่
                    autoclose: true,      // ปิด datepicker เมื่อเลือกวันที่
                    todayHighlight: true  // ไฮไลต์วันที่ปัจจุบัน
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