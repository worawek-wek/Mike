<div class="m-2 mt-4" style="border: 1px solid #dbdbdb;border-radius: 5px;">
    <h5 class="border-bottom p-2" style="background-color: rgb(255, 248, 237);">
        <i class="tf-icons ti ti-browser-plus text-main" style="font-size: 25px;vertical-align: baseline;"></i>
        รายการห้อง
    </h5>
    <div class="px-4">
                @php
                    $total_amount = 0;
                @endphp
    @forelse ($invoice_alls as $key => $invoice)
    @php 
        if(count($invoice->receipt) > 0){
            continue;
        }
    @endphp
    <div class="mb-3 billReserveRoom" id="billReserveRoom{{$invoice->id}}">
    <input name="insert[{{ $key }}][ref_room_id]" type="hidden" value="{{ $invoice->ref_room_id }}">
    <input name="insert[{{ $key }}][ref_rent_bill_id]" type="hidden" value="{{ $invoice->id }}">
    <input name="insert[{{ $key }}][ref_contract_id]" type="hidden" value="{{ $invoice->ref_contract_id }}">
    <input name="insert[{{ $key }}][ref_renter_id]" type="hidden" value="{{ $invoice->contract->ref_renter_id }}">
    <input name="insert[{{ $key }}][ref_type_id]" type="hidden" value="1">
    <input type="hidden" name="insert[{{ $key }}][id]" value="{{$invoice->id}}">
    <input name="insert[{{ $key }}][payment_format]" class="form-check-input" type="hidden" id="checksplit" value="2" > 

        <div class="d-flex justify-content-between align-items-center mt-3 mb-1">
            <h5 class="text-success mb-0">{{ $invoice->room->name }}</h5>
            <a href="javascript:void(0)" onclick="deleteBillRoom({{$invoice->id}})">
                <i class="fa fa-trash text-danger"></i>
            </a>
        </div>
        <div class="mb-3" style="border: 1px solid #dbdade;padding: 15px 2px;">
            <div class="d-flex">
                <div class="flex-grow-1 ms-3">
                <b class="text-black">รายละเอียดหัวบิล</b> <br>
                    {{ $invoice->room_for_rent->renter->prefix.' '.$invoice->room_for_rent->renter->name.' '.$invoice->room_for_rent->renter->surname }} <br>
                    เลขประจำตัวผู้เสียภาษี {{ $invoice->room_for_rent->renter->id_card_number }} <br>
                    โทร {{ $invoice->room_for_rent->renter->phone }}
                </div>
            </div>
        </div>
        <table class="table table-bordered mb-4" id="discount-table2" >
            <thead>
                <tr>
                    <th>รายการ</th>
                    <th width="35%">จำนวนเงิน (บาท)</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $amount = 0;
                @endphp
                @foreach ($list as $item_list)
                    @foreach ($invoice[$item_list] as $key_2 => $payment_list)
                    @php
                        $total_amount += $payment_list->price;
                        $amount += $payment_list->price;
                    @endphp
                        <tr>
                            <td>
                                <input name="insert[{{ $key }}][payment_list][title][]" type="text" class="form-control payment_list_title" value="{{ $payment_list->title }}" placeholder="หัวข้อรายการ" readonly>
                            </td>
                            <td class="text-end">
                                <input type="number" name="insert[{{ $key }}][payment_list][price][]" class="form-control calculate_2" value="{{ $payment_list->price }}" placeholder="จำนวนเงิน" max="" oninput="calculate_2Price()" readonly>
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <th>รวม</th>
                    <th class="text-end mb-0 fw-bold total-price_2">
                        <input name="insert[{{ $key }}][amount]" class="total-price" value="{{ $amount }}" type="hidden">
                        {{ number_format($amount) }} บาท
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
    @empty
    <div> ไม่พบข้อมูล</div>
    @endforelse
    </div>
    </div>
    
    <div class="m-2 mt-4" style="border: 1px solid #dbdbdb;border-radius: 5px;">
        <h5 class="border-bottom p-2 m-0" style="background-color: rgb(255, 248, 237);">
            <i class="tf-icons ti ti-browser-plus text-main" style="font-size: 25px;vertical-align: baseline;"></i>
            ชำระเงิน
        </h5>
        <div class="row g-3 pb-4">
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
                        {{ number_format($total_amount) }}
                    </span> &nbsp;บาท</b>
                    <b id="totalsplit" style="display: none">ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price-lhai_2">{{ number_format($total_amount) }}</span> &nbsp;บาท</b>
                </div>
            </div>
        </div>
    </div>
<script>
        // setTimeout(() => {
            if({{$total_amount}} > 0){
                $('#submit_payment_bill_form_all').prop('disabled', false);
            }else{
                $('#submit_payment_bill_form_all').prop('disabled', true);
            }
        // }, 2000);
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
</script>
<script>
    function deleteBillRoom(id){
        if ($('.billReserveRoom').length > 1) {
            $("#billReserveRoom"+id).remove();
            document.getElementById("check-table-"+id).checked = false; // ยกเลิก "เต็มจำนวน"
            payMultipleRentBills();
        } else {
            Swal.fire('ไม่สามารถลบได้', 'การชำระค่าจองต้องมีอย่างน้อย 1 ห้อง', 'warning');
        }
    }
</script>