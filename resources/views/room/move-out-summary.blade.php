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
                                            @if ($cal >= 0)
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
                                                        @if ($cal >= 0)
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