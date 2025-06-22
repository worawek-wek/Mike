    <input type="hidden" name="ref_renter_id" value="{{ $renter->id }}">
    <div class="m-2" style="border: 1px solid #dbdbdb;border-radius: 5px;">
        <h5 class="border-bottom p-2" style="background-color: rgb(255, 248, 237);">
            <i class="tf-icons ti ti-vocabulary text-main" style="font-size: 25px;"></i>
            กรุณากรอกรายละเอียดสัญญาเช่า
        </h5>
        <div class="row g-3 p-4 pt-1">
            <div class="col-sm-5">
                <label for="exampleFormControlInput1" class="form-label">ชื่อผู้เข้าพัก</label>
                <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="" value="{{ $renter->prefix.' '.$renter->name.' '.$renter->surname }}" />
            </div>
            <div class="col-sm-7">
                <label for="exampleFormControlInput2" class="form-label">ที่อยู่ผู้เข้าพัก</label>
                <input type="text" name="address" class="form-control" id="exampleFormControlInput2" placeholder="" value="{{ $address }}" />
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
                <label for="contract_date" class="form-label">วันที่ทำสัญญา</label>
                <input type="text" name="contract_date" class="form-control" placeholder="" id="contract_date" value="{{ date('d/m/Y', strtotime('+1 day')) }}" required autocomplete="off"/>
            </div>
            <div class="col-sm-6">
                <label class="form-label">ระยะเวลาทำสัญญา(เดือน)</label>
                <input type="text" name="period" class="form-control" placeholder="" value="" required/>
            </div>
            <div class="col-sm-6">
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
            if(count($item->rent_bill_not_pay) > 0){
                continue;
            }
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
        $receipt = \App\Models\Receipt::where('ref_room_id', $item->ref_room_id)->where('ref_type_id', 3)->orderBy('id','DESC')->first();

        @endphp

        <input type="hidden" name="contract[{{$key}}][ref_room_for_rent_id]" value="{{ $item->id }}">
        <input type="hidden" name="contract[{{$key}}][ref_room_id]" value="{{ $item->ref_room_id }}">
        <div class="row g-3 p-4 pt-1">
            <h5 class="mt-3 mb-1 text-success">{{ $item->room->name }}</h5>
            <div class="col-sm-6">
                <label for="security_deposit" class="form-label">เงินประกันห้อง(บาท)</label>
                <input type="text" name="contract[{{$key}}][security_deposit]" class="form-control" id="security_deposit" placeholder="" value=""/>
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
                <label for="deduction_booking_date" class="form-label">หักค่าจองห้องเมื่อวันที่</label>
                <input type="text" name="contract[{{$key}}][deduction_booking_date]" class="form-control" id="deduction_booking_date{{$item->id}}" placeholder="" autocomplete="off" value="{{ @$contract->payment_received_date != null ? date('d/m/Y', strtotime($contract->payment_received_date)) : ''; }}"/>
            </div>
            <div class="col-sm-6">
                <label for="receipt_no" class="form-label">อ้างอิงจากใบเสร็จค่าจองเลขที่</label>
                <input type="text" name="contract[{{$key}}][receipt_no]" class="form-control" id="receipt_no" placeholder="" value="{{ @$receipt->receipt_number }}"/>
            </div>

        </div>
        <script>
            $('#deduction_booking_date{{$item->id}}').datepicker({
                format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่
                autoclose: true,      // ปิด datepicker เมื่อเลือกวันที่
                todayHighlight: true  // ไฮไลต์วันที่ปัจจุบัน
            });
        </script>
        @endforeach
    </div>
<script>
    $('#contract_date').datepicker({
            format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่
            autoclose: true,      // ปิด datepicker เมื่อเลือกวันที่
            todayHighlight: true  // ไฮไลต์วันที่ปัจจุบัน
        });
</script>