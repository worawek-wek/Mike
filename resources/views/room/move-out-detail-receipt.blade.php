    @php
        $permission_bill_move_edit = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 32)->where('status', 0)->first();
    @endphp
<style>
    .table-detail-receipt th,
    .table-detail-receipt td {
        border: 1px solid #d9d9d9 !important;
    }
</style>
            <div class="my-3" style="border: 1px solid #dbdade;padding: 15px 2px;">
                <div class="d-flex">
                    <div class="flex-grow-1 ms-3">
                    <b class="text-black">รายละเอียดหัวบิล</b> <br>
                        {{ $invoice->name }} <br>
                        เลขประจำตัวผู้เสียภาษี {{ $invoice->id_card_number }} <br>
                        โทร {{ $invoice->phone }}
                    </div>
                </div>
            </div>
            <table class="table table-detail-receipt">
                <thead>
                    <tr>
                        <th>รายการ</th>
                        <th width="20%">จำนวนเงิน (บาท)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->payment_list as $key => $payment_list_item)
                        <tr>
                            {{-- <td>ค่าเช่าห้อง (Room rate) {{ $invoice->room_for_rent->room->name }} เดือน {{ $invoice->month.'/'.$invoice->year }}</td> --}}
                            <td>
                                {{ $payment_list_item->title }}
                            </td>
                            <td class="text-end {{$payment_list_item->discount == 1 ? "text-danger fw-bold" : ""}}">
                                @if ($payment_list_item->discount == 1)
                                    {{ number_format(0-$payment_list_item->price) }}
                                    <input type="hidden" class="calculate" value="{{0-$payment_list_item->price}}">
                                @else
                                    {{ number_format($payment_list_item->price) }}
                                    <input type="hidden" class="calculate" value="{{$payment_list_item->price}}">
                                @endif
                                <input type="hidden" name="payment_list[price][]" class="{{ $payment_list_item->discount == 1 ? "" : "" ; }} calculate_2" value="{{ $payment_list_item->price }}">
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <th>รวม</th>
                        <th class="text-end mb-0 fw-bold total-price">
                            {{ number_format($invoice->total_amount) }}
                        </th>
                    </tr>
                </tfoot>
            </table>
            
            <div class="mt-4 col-12 d-flex justify-content-end gap-2"
                    @if($permission_bill_move_edit || @$receipt || $invoice->payment_channel == 3)
                        {{-- style="pointer-events: none;  /* ปิดคลิก */
                                opacity: 0.6;          /* ให้ดูจางลง */
                                cursor: not-allowed;   /* เปลี่ยนเมาส์เป็นรูปห้าม */" --}}
                    @endif
                    {{-- @if () disabled @endif  --}}
                    >
                <button
                    @if (@$receipt) disabled @endif
                    style="padding-right: 14px;padding-left: 14px;"
                    class="btn buttons-collection btn-warning waves-effect waves-light"
                    type="button"
                    onClick="editFormReceipt()"
                >
                    <i class="ti ti-pencil me-1"></i> แก้ไขใบเสร็จ
                </button>
                <div class="dropdown">
                    <button class="btn btn-main dropdown-toggle" type="button" id="paymentDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                        เคลียร์ใบเสร็จย้ายออก
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="paymentDropdown">
                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="payReceiptMoveOut(1)">ชำระเงิน</a></li>
                        <li><a class="dropdown-item" href="javascript:void(0)" onclick="payReceiptMoveOutByDeposit(1)">หักจากเงินประกัน</a></li>
                        {{-- <li><a class="dropdown-item" href="javascript:void(0)" onclick="pay(2)">หักจากเงินประกัน</a></li> --}}
                    </ul>
                </div>
            </div>
                @if (@$receipt->payment_channel == 3)
                    <h4 class="text-danger mt-4" align="center">หมายเหตุ : ยอดชำระด้วยวิธี “หักจากเงินประกัน” จะถูกนำไปดำเนินการในขั้นตอนเคลียร์บิลย้ายออก</h4>
                    <input type="hidden" class="discount-value" value="{{ $invoice->total_amount }}"> <!-- เอายอดนี้ ไปหักค่าประกัน ถ้า payment_channel = 3 (ชำระโดย หักจากเงินประกัน) -->
                @endif
            <script>
                function payReceiptMoveOut(ch){
                    $('#payment_receipt').show();
                    $('#payment_receipt_by_deposit').hide();
                    $('#defaultRadio1').prop('checked', true);
                }
                function payReceiptMoveOutByDeposit(ch){
                    $('#payment_receipt_by_deposit').show();
                    $('#payment_receipt').hide();
                    $('#defaultRadio123').prop('checked', true);
                }
            </script>

            @if (@$receipt)
                <div class="p-4 mt-4" style="border: 1px solid #59d57a;border-radius: 5px;">
                    <p align="right" style="color: black; font-weight: 500;">เลขที่ใบเสร็จ: &nbsp; <span class="text-success">{{ $receipt->receipt_number }}</span></p>
                        <table class="table table-detail table-bordered">
                            <thead>
                                <tr>
                                    <td width="50%">
                                        <span style="color: black; font-weight: 500;">รายละเอียดหัวบิล</span> <br>
                                        {{ $invoice->name }} <br>
                                        เลขประจำตัวผู้เสียภาษี {{ $invoice->id_card_number }} <br>
                                        โทร {{ $invoice->phone }}
                                    </td>
                                    <td style="color: black;">
                                                @php
                                                    $date = new DateTime(date('Y-m-d', strtotime($receipt->created_at)));
                                                    $englishDay = $date->format('l');
                                                    $payment_channel = [1 => 'เงินสด', 2 => 'โอนเงิน', 3 => 'หักจากเงินประกัน'];
                                                @endphp
                                                    <span style="color: black; font-weight: 500;">วันที่รับชำระเงิน</span> &nbsp; &nbsp; &nbsp; {!! $days[$englishDay].' &nbsp;'.date('d/m/Y', strtotime($receipt->created_at)) !!}<br>
                                                    <span style="color: black; font-weight: 500;">ช่องทางการชำระเงิน</span> &nbsp; &nbsp; &nbsp; {{ $payment_channel[$receipt->payment_channel] }}<br>
                                                    <span style="color: black; font-weight: 500;">รับชำระโดย</span> &nbsp; &nbsp; &nbsp; {{ $receipt->user->name }}<br>
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
                                @foreach ($receipt->payment_list as $key => $item_payment_list)
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
                        <div class="modal-footer rounded-0 d-flex justify-content-between mt-2 pb-0">
                            <button type="button" class="btn btn-label-primary waves-effect" onclick="printPdf({{ $receipt->id }})">
                                <span class="ti-sm ti ti-printer me-2"></span>พิมพ์ใบเสร็จรับเงิน
                            </button>

                            <button type="button" class="btn btn-danger me-2" onclick="changeDeleteReceipt({{ $receipt->id }}, {{ $invoice->id }})">
                                <span>
                                    <i class="ti ti-x"></i>
                                    ยกเลิกใบเสร็จ
                                </span>
                            </button>
                        </div>
                    </div>
            @endif

                                    <form id="payment_receipt_move_out_bill" enctype="multipart/form-data">
                                        @csrf
                                        
                                        <input type="hidden" name="invoice_id" value="{{ @$invoice->id }}">
                                        <input name="ref_room_for_rent_id" type="hidden" value="{{ $invoice->ref_room_for_rent_id }}">
                                        <input name="ref_room_id" type="hidden" value="{{ $invoice->ref_room_id }}">
                                        <input name="ref_contract_id" type="hidden" value="{{ $invoice->ref_contract_id }}">
                                        <input name="payment_format" type="hidden" value="1">
                                        
                                        <input name="ref_type_id" type="hidden" value="4">
                                        <input name="amount" class="total-price" type="hidden">

                                        <input type="hidden" name="id" value="{{$invoice->id}}">
                                        <div class="mt-3" id="payment_receipt" style="display: none;border: 1px solid #dbdade;padding: 15px 2px;">

                                            <div class="mb-3 pb-4" style="padding: 15px 2px;">
                                                <div class="d-flex">
                                                    <div class="flex-grow-1 ms-3 g-3 row">
                                                        <b class="text-black">ช่องทางการชำระเงิน</b> <br>
                                                        <div class="col-sm-11">
                                                            <input name="receipt_payment_channel" class="form-check-input" type="radio" id="defaultRadio1" value="1" checked onclick="togglePaymentReceiptFields()">
                                                            <label class="form-check-label" for="defaultRadio1"> เงินสด </label>
                                                        </div>
                                                        
                                                        <div id="receiptPaymentDetails2">
                                                            <div class="col-sm-6 mb-2">
                                                                <label for="payment_date">วันที่ชำระเงิน</label>
                                                                <input type="text" name="payment_date" class="form-control" placeholder="" id="payment_date" required autocomplete="off" value="{{date('d/m/Y')}}"/>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-11">
                                                            <input name="receipt_payment_channel" class="form-check-input" type="radio" id="defaultRadio2" value="2" onclick="togglePaymentReceiptFields()"> 
                                                            <label class="form-check-label" for="defaultRadio2"> โอนเงิน </label>
                                                        </div>
                                            
                                                        <!-- แสดงเมื่อเลือก โอนเงิน -->
                                                        <div id="receiptPaymentDetails" style="display:none;">
                                                            
                                                            <div class="col-sm-6 mb-2">
                                                                <label>เลือกบัญชีธนาคาร</label>
                                                                <select class="select2 form-select mb-2" name="ref_bank_id" id="exampleFormControlSelect1">
                                                                    {{-- <option value="" disabled="" selected="selected">บัญชีธนาคาร</option> --}}
                                                                    @foreach ($move_bank as $move_r_bank)
                                                                        <option value="{{ $move_r_bank->id }}">{{ $move_r_bank->bank.' '.$move_r_bank->bank_account_name }}</option>
                                                                    @endforeach
                                                            </div>
                                                            <div class="col-sm-4 mb-2">
                                                                <input type="hidden" name="">
                                                            </div>
                                                                <div class="col-sm-3 mb-2">
                                                                    <label for="receipt_transfer_time">เวลาโอนเงิน</label><span class="text-danger"> *</span>
                                                                    <input type="time" name="transfer_time" class="form-control" placeholder="" id="receipt_transfer_time" autocomplete="off"/>
                                                                </div>
                                                                <div class="col-sm-6 mb-2">
                                                                    <label for="receipt_payment_date2">วันที่โอนเงิน</label><span class="text-danger"> *</span>
                                                                    <input type="text" name="payment_date2" class="form-control" placeholder="" id="receipt_payment_date2" autocomplete="off" value="{{date('d/m/Y')}}" required/>
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
                                                            <b id="totalpayfull">ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price">{{ number_format($invoice->balance_amount) }}</span> &nbsp;บาท</b>
                                                            <b id="totalsplit" style="display: none">ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price_2">0</span> &nbsp;บาท</b>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        
                                        <script>
                                            function togglePaymentReceiptFields() {
                                                const paymentChannel = document.querySelector('input[name="receipt_payment_channel"]:checked').value;
                                                const receiptPaymentDetails = document.getElementById('receiptPaymentDetails');
                                                const receiptPaymentDetails2 = document.getElementById('receiptPaymentDetails2');
                                                // หากเลือก โอนเงิน (value=2) ให้แสดงฟอร์มเพิ่ม
                                                if (paymentChannel == '2') {
                                                    receiptPaymentDetails.style.display = 'block';
                                                    receiptPaymentDetails2.style.display = 'none';
                                                    $('#receipt_ref_bank_id').attr('required', true);
                                                    $('#receipt_transfer_time').attr('required', true);
                                                    $('#receipt_payment_date2').attr('required', true);
                                                } else {
                                                    receiptPaymentDetails.style.display = 'none';
                                                    receiptPaymentDetails2.style.display = 'block';
                                                    $('#receipt_ref_bank_id').removeAttr('required');
                                                    $('#receipt_transfer_time').removeAttr('required');
                                                    $('#receipt_payment_date2').removeAttr('required')
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
                                            togglePaymentReceiptFields();
                                        </script>

                                        <h4 class="text-center text-danger">ยอดค้างชำระเงินทั้งหมด&nbsp; <span class="">{{ number_format($invoice->total_amount - $invoice->receipt->pluck('payment_list')->flatten()->sum('price')) }}</span> &nbsp;บาท
                                        
                                        
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
                                    
                                <div class="mt-3" id="payment_receipt_by_deposit" style="display: none;border: 1px solid #dbdade;padding: 15px 2px;">

                                    <div class="mb-3 pb-4" style="padding: 15px 2px;">
                                        <div class="d-flex">
                                            <div class="flex-grow-1 ms-3 g-3 row">
                                                <b class="text-black">ช่องทางการชำระเงิน</b> <br>
                                                <div class="col-sm-11">
                                                    <input name="receipt_payment_channel" class="form-check-input" type="radio" id="defaultRadio123" value="3">
                                                    <label class="form-check-label" for="defaultRadio123"> หักจากเงินประกัน </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    
                                        <div class="col-sm-11 mt-2 px-4">
                                            <b id="totalpayfullDeposit">ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price">{{ number_format($invoice->balance_amount) }}</span> &nbsp;บาท</b>
                                            <b id="totalsplitDeposit" style="display: none">ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price_2">0</span> &nbsp;บาท</b>
                                        </div>
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
                                <script>
                                    setTimeout(() => {
                                        calculateTotal()
                                    }, 2000);

                                    $('#payment_receipt_move_out_bill').on('submit', function(event) { // บันทึกบิลย้ายออก ใบเสร็จย้ายออก function save_moveout_receipt()
                                        event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
                                        if(!this.checkValidity()) {
                                            // ถ้าฟอร์มไม่ถูกต้อง
                                            this.reportValidity();
                                            return console.log('ฟอร์มไม่ถูกต้อง');
                                        }
                                        Swal.fire({
                                            title: 'ยืนยันการดำเนินการ?',
                                            text: 'คุณต้องการ ชำระเงิน ใบเสร็จย้ายออก หรือไม่?',
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
                                                    url: '/room/payment-receipt-move-out-bill',
                                                    type: 'POST',
                                                    data: $(this).serialize(),
                                                    success: function(response) {
                                                        if(response == true){
                                                            get_move_out();
                                                            calculateTotal()
                                                            calculate_2Price()
                                                            loadData(page);
                                                            summary();
                                                            Swal.fire('ชำระเงินใบเสร็จย้ายออกเรียบร้อยแล้ว', '', 'success');
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
                                    
                                    function changeDeleteReceipt(receipt_id, invoice_id){
                                        Swal.fire({
                                            title: 'ยืนยันการดำเนินการ?',
                                            text: 'คุณต้องการ ยกเลิก ใบเสร็จ หรือไม่?',
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
                                                    type: "POST",
                                                    url: "bill/delete-receipt/"+receipt_id,
                                                    data: {
                                                        _token: "{{ csrf_token() }}",
                                                    },
                                                    success: function(response) {
                                                        if(response == true){
                                                            Swal.fire('ยกเลิก ใบเสร็จ เรียบร้อยแล้ว', '', 'success');
                                                            get_move_out();
                                                            calculateTotal()
                                                            calculate_2Price()
                                                            loadData(page);
                                                            summary();
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
                                    }
                                </script>