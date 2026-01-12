    {{-- ทำสัญญาหลายห้อง --}}
    {{-- ทำสัญญาหลายห้อง --}}
    {{-- ทำสัญญาหลายห้อง --}}
    {{-- ทำสัญญาหลายห้อง --}}

<link rel="stylesheet" href="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<script src="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
    <input type="hidden" name="ref_renter_id" value="{{ $renter->id }}">
    <div class="m-2" style="border: 1px solid #dbdbdb;border-radius: 5px;">
        <h5 class="border-bottom p-2" style="background-color: rgb(255, 248, 237);">
            <i class="tf-icons ti ti-vocabulary text-main" style="font-size: 25px;"></i>
            กรุณากรอกรายละเอียดสัญญาเช่า {{count($room_for_rent)}}
        </h5>
        <div class="row g-3 p-4 pt-1">
            <div class="col-sm-5">
                <label for="exampleFormControlInput1" class="form-label">ชื่อผู้เข้าพัก</label>
                <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="" value="{{ $renter->prefix.' '.$renter->name.' '.$renter->surname }}" />
            </div>
            <div class="col-sm-7">
                <label for="exampleFormControlInput2" class="form-label">ที่อยู่ผู้เข้าพัก</label>
                <input type="text" name="address" class="form-control" id="exampleFormControlInput2" placeholder="" value="{{ $renter->address.' '.$address }}" />
            </div>
            <div class="col-sm-6">
                <label for="exampleFormControlInput3" class="form-label">เบอร์โทรผู้เข้าพัก</label>
                <input type="text" name="phone" class="form-control" id="exampleFormControlInput3" placeholder="" value="{{ $renter->phone }}" />
            </div>
            <div class="col-sm-6">
                <label for="exampleFormControlInput4" class="form-label">หมายเลขบัตรประชาชนผู้เข้าพัก</label>
                <input type="text" name="id_card_number" class="form-control" id="exampleFormControlInput4" placeholder="" value="{{ $renter->id_card_number }}" />
            </div>
            <div class="col-sm-6">
                <label for="contract_date_all" class="form-label">วันที่ทำสัญญา</label>
                <input type="text" name="contract_date" class="form-control date_contract_all" placeholder="" id="contract_date_all" value="{{ date('d/m/Y') }}" required autocomplete="off"/>
            </div>
            <div class="col-sm-6">
                <label class="form-label">ระยะเวลาทำสัญญา(เดือน)</label>
                <input type="number" name="period" class="form-control" placeholder="" value="" id="period" required/>
            </div>
            
            <div class="col-sm-6">
                <label for="contract_date_to_all" class="form-label">วันที่สิ้นสุดสัญญา </label>
                <input type="text" name="contract_date_to" class="form-control date_contract_all" placeholder="" id="contract_date_to_all" required autocomplete="off" value=""/>
            </div>
            <div class="col-sm-12">
                <label for="remark" class="form-label">หมายเหตุ</label>
                <input type="text" name="remark" class="form-control" id="remark" placeholder="" value="" value="" />
            </div>
        </div>
    </div>

    <div class="m-2 mt-4" style="border: 1px solid #dbdbdb;border-radius: 5px;">
        <h5 class="border-bottom p-2" style="background-color: rgb(255, 248, 237);">
            <i class="tf-icons ti ti-browser-plus text-main" style="font-size: 25px;vertical-align: baseline;"></i>
            รายการห้อง
        </h5>
        @foreach ($room_for_rent as $key => $item)
        @php
            // if(count($item->rent_bill_not_pay) > 0){
            //     continue;
            // }
            
            $receipt = \App\Models\Receipt::where('ref_room_id', $item->ref_room_id)->where('ref_type_id', 3)->orderBy('id','DESC')->first();
            // if($receipt->ref_status_id != 5){
            //    continue; 
            // }
            $contract = \App\Models\Renter::leftJoin('contracts', 'renters.id', '=', 'contracts.ref_renter_id')
                        ->leftJoin('room_for_rents', 'renters.id', '=', 'room_for_rents.ref_renter_id')
                        ->where('room_for_rents.ref_room_id', $item->ref_room_id)
                        ->select(
                            'contracts.*',
                            'renters.*',
                            'room_for_rents.deposit',
                            'room_for_rents.payment_received_date',
                            'contracts.id as contract_id',
                            'renters.id as renter_id',
                            DB::raw("CONCAT(renters.name, ' ', IFNULL(renters.surname, '')) as full_name")
                        )
                        ->orderByDesc('contracts.created_at')
                        ->first();
        $meter = \App\Models\Meter::where('ref_room_id', $item->ref_room_id)->orderBy('id','DESC')->first();

        @endphp

        <div class="row g-3 p-4 pt-1 contractRoom contractRoomBox{{$item->id}}" id="contractRoom{{$item->id}}">
        <input type="hidden" name="contract[{{$key}}][ref_room_for_rent_id]" value="{{ $item->id }}">
        <input type="hidden" name="contract[{{$key}}][ref_room_id]" value="{{ $item->ref_room_id }}">
            <div class="d-flex justify-content-between align-items-center mt-3 mb-1">
                <h5 class="text-success mb-0">{{ $item->room->name }}</h5>
                <a href="javascript:void(0)" onclick="deleteContractRoom({{$item->id}})">
                    <i class="fa fa-trash text-danger"></i>
                </a>
            </div>
            <div class="col-sm-6">
                <input type="hidden" name="contract[{{$key}}][deposit][0][title]" class="form-control" required value="เงินประกันห้อง" />
                <label for="security_deposit" class="form-label">เงินประกันห้อง(บาท) <span class="text-danger">*</span></label>
                <input type="number" name="contract[{{$key}}][deposit][0][security_deposit]" class="form-control" id="security_deposit" placeholder="" value="" required/>
            </div>
            {{-- <div class="col-sm-6 d-flex align-items-end pb-1">
                <button
                    id="add_expenses"
                    class="btn btn-sm buttons-collection btn-warning waves-effect waves-light me-2"
                    tabindex="0" aria-controls="DataTables_Table_0"
                    type="button" aria-haspopup="dialog"
                    aria-expanded="false">
                    <span>
                    <i class="ti ti-plus"></i> เพิ่มรายการเงินประกัน</span>
                </button>
            </div> --}}
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
                <input type="text" name="contract[{{$key}}][deduction_booking_amount]" class="form-control" id="deduction_booking_amount" placeholder="" value="{{ @$contract->deposit }}" />
            </div>
            <div class="col-sm-6">
                <label for="deduction_booking_date_all{{$item->id}}" class="form-label">หักค่าจองห้องเมื่อวันที่</label>
                <input type="text" name="contract[{{$key}}][deduction_booking_date]" class="form-control date_contract_all" id="deduction_booking_date_all{{$item->id}}" placeholder="" autocomplete="off" value="{{ @$contract->payment_received_date != null ? date('d/m/Y', strtotime($contract->payment_received_date)) : ''; }}"/>
            </div>
            <div class="col-sm-6">
                <label for="receipt_no" class="form-label">อ้างอิงจากใบเสร็จค่าจองเลขที่</label>
                <input type="text" name="contract[{{$key}}][receipt_no]" class="form-control" id="receipt_no" placeholder="" value="{{ @$receipt->receipt_number }}"/>
            </div>
            <div class="col-sm-6"></div>
            <div class="col-sm-6">
                <label for="water_meter_start_living" class="form-label">เลขมิเตอร์น้ำประปา(เข้าพัก)*</label>
                <input type="text" name="contract[{{$key}}][water_meter_start_living]" class="form-control" id="water_meter_start_living" placeholder="" value="{{ (int) $meter->water_unit }}"/>
            </div>
            <div class="col-sm-6">
                <label for="electricity_meter_start_living" class="form-label">เลขมิเตอร์ค่าไฟ(เข้าพัก)*</label>
                <input type="text" name="contract[{{$key}}][electricity_meter_start_living]" class="form-control" placeholder="" required value="{{ (int) $meter->electricity_unit }}"/>
            </div>
        </div>
        <script>
                $('#submit_insert_contract').prop('disabled', false);
        </script>
            @if (!$loop->last)
                <hr class="contractRoomBox{{$item->id}}">
            @endif
        @endforeach
    </div>
        
    <div class="m-2 mt-4" style="border: 1px solid #dbdbdb;border-radius: 5px;">
        <h5 class="border-bottom p-2" style="background-color: rgb(255, 248, 237);">
            <i class="tf-icons ti ti-browser-plus text-main" style="font-size: 25px;vertical-align: baseline;"></i>
            ชำระเงิน
        </h5>
        <div class="row g-3 p-4 pt-1">
            <div class="col-sm-12">
                <div>
                    <label for="exampleFormControlInput31" class="form-label">วิธีการชำระเงิน</label>
                </div>
                {{-- ///////////////////////////////////////////////////// --}}
                <div class="col-sm-11 mb-3">
                    <input name="payment_channel" class="form-check-input me-1 reservation_payment_channel" type="radio" id="reservation_payByCash" value="1" checked>
                    <label class="form-check-label" for="reservation_payByCash"> เงินสด </label>
                </div>

                <div id="paymentChanel_Res2">
                    <div class="col-sm-6 mb-3">
                        <label for="payment_date_all">วันที่ชำระเงิน</label>
                        <input type="text" name="payment_date" class="form-control date_contract_all" placeholder="" id="payment_date_all" autocomplete="off" value="{{date('d/m/Y')}}"/>
                    </div>
                </div>

                <div class="col-sm-11 mb-3">
                    <input name="payment_channel" class="form-check-input me-1 reservation_payment_channel" type="radio" id="reservation_payByTransfer" value="2">
                    <label class="form-check-label" for="reservation_payByTransfer"> โอนเงิน </label>
                </div>

                <!-- แสดงเมื่อเลือก โอนเงิน -->
                <div id="paymentChanel_Res" style="display:none;">
                    <div class="col-sm-6 mb-2">
                        <label>เลือกบัญชีธนาคาร</label><span class="text-danger"> *</span>
                        <select class="select2 form-select mb-2" name="ref_bank_id" id="exampleFormControlSelect1">
                            @foreach ($bank as $r_bank)
                                <option value="{{ $r_bank->id }}">{{ $r_bank->bank.' '.$r_bank->bank_account_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-sm-3 mb-2">
                        <label for="transfer_time">เวลาโอนเงิน</label><span class="text-danger"> *</span>
                        <input type="time" name="transfer_time" class="form-control" placeholder="" id="transfer_time" autocomplete="off"/>
                    </div>
                    <div class="col-sm-6 mb-2">
                        <label for="payment_date2_all">วันที่โอนเงิน</label><span class="text-danger"> *</span>
                        <input type="text" name="payment_date" class="form-control date_contract_all" placeholder="" id="payment_date2_all" autocomplete="off" value="{{date('d/m/Y')}}" required/>
                    </div>
                    <div class="col-sm-10 mt-3">
                        <label for="evidence_of_money_transfer">แนบหลักฐานการโอน</label><span class="text-danger"> *</span>
                        <input type="file" name="evidence_of_money_transfer" class="form-control mb-2" id="evidence_of_money_transfer" accept="image/*" required>
                        <div class="preview-container">
                            <img id="preview1" src="" alt="Preview 1" style="display: none; width:30%">
                        </div>
                    </div>
                </div>
                {{-- ///////////////////////////////////////////////////// --}}
            </div>
        </div>
    </div>
</div>
    <script>
        document.getElementById('evidence_of_money_transfer').addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview1');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }

                reader.readAsDataURL(file);
            } else {
                preview.src = "";
                preview.style.display = "none";
            }
        });
        $('.date_contract_all').datepicker({
                format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่
                autoclose: true,      // ปิด datepicker เมื่อเลือกวันที่
                todayHighlight: true  // ไฮไลต์วันที่ปัจจุบัน
            });
    </script>
    <script>
        $('.reservation_payment_channel').on('change', function() {
            const paymentChannel = $('.reservation_payment_channel:checked').val();

            if (paymentChannel === '2') {
                // แสดงช่องโอนเงิน
                $('#paymentChanel_Res').show();
                $('#paymentChanel_Res2').hide();

                // ใส่ required
                $('#ref_bank_id').attr('required', true);
                $('#transfer_time').attr('required', true);
                $('#payment_date2_all').attr('required', true);
                $('#evidence_of_money_transfer').attr('required', true);
            } else {
                // แสดงช่องเงินสด
                $('#paymentChanel_Res').hide();
                $('#paymentChanel_Res2').show();

                // เอา required ออก
                $('#ref_bank_id').removeAttr('required');
                $('#transfer_time').removeAttr('required');
                $('#payment_date2_all').removeAttr('required');
                $('#evidence_of_money_transfer').removeAttr('required');
            }
        });

        // ให้รันตอนโหลดหน้าด้วย (กรณีมีค่า checked อยู่แล้ว)
        $(document).ready(function() {
            $('.reservation_payment_channel:checked').trigger('change');
        });
    </script>
    <script>
        function updateContractDateTo() {
            const contractDate = $('#contract_date_all').val();
            const periodMonths = parseInt($('#period').val(), 10);
            const contractDateToField = $('#contract_date_to_all');

            if (contractDate && periodMonths && !isNaN(periodMonths)) {
                const dateParts = contractDate.split('/');
                const contractDateObject = new Date(dateParts[2], dateParts[1] - 1, dateParts[0]);
                contractDateObject.setMonth(contractDateObject.getMonth() + periodMonths);
                const endDate = contractDateObject.toLocaleDateString('en-GB');
                contractDateToField.val(endDate);
            }
        }

        function initContractFormScript() {
            $('#contract_date_all').on('input', updateContractDateTo);
            $('#period').on('input', updateContractDateTo);
            updateContractDateTo(); // คำนวณครั้งแรก
        }

        // เรียกตอนโหลดเสร็จ
        $(document).ready(function(){
            initContractFormScript();
        });
    </script>
    <script>
        function deleteContractRoom(id){
            if ($('.contractRoom').length > 1) {
                $(".contractRoomBox"+id).remove();
            } else {
                Swal.fire('ไม่สามารถลบได้', 'การทำสัญญาต้องมีอย่างน้อย 1 ห้อง', 'warning');
            }
        }
    </script>