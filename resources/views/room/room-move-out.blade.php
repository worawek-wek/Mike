{{-- ย้ายออก หลายห้อง --}}
<style>
    .table-detail-receipt th,
    .table-detail-receipt td {
        border: 1px solid #d9d9d9 !important;
    }
</style>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<div class="m-2 mt-4" style="border: 1px solid #dbdbdb;border-radius: 5px;">
    <h5 class="border-bottom p-2 m-0" style="background-color: rgb(255, 248, 237);">
        <i class="tf-icons ti ti-browser-plus text-main" style="font-size: 25px;vertical-align: baseline;"></i>
        รายการห้อง
    </h5>
    <div class="px-4 pb-4">
        @foreach ($room as $key => $row)
            <input type="hidden" name="room[{{$key}}][ref_renter_id]" value="{{ @$row->move_invoice_type_7->room_for_rent->ref_renter_id }}">
            <input type="hidden" name="room[{{$key}}][invoice_id]" value="{{ @$row->move_invoice_type_7->id }}">
            <input type="hidden" id="move_out_type" name="room[{{$key}}][move_out_type]" value="1">
            <input type="hidden" name="room[{{$key}}][room_id]" value="{{ $row->id }}">
            
            <div class="d-flex justify-content-between align-items-center mt-3 mb-1">
                <h4 class="my-3 text-success" style="font-weight: bold;text-align: center !important;" for="">
                    <u>{{ $row->name }}</u>
                </h4>
                <a href="javascript:void(0)" onclick="deleteMoveOutRoom({{$row->id}})">
                    <i class="fa fa-trash text-danger"></i>
                </a>
            </div>
            <label class="mb-4 text-black" style="font-weight: 500;font-size: large;" for="">
                <span class="badge badge-center rounded-pill me-1 label-move-out" style="background-color: #54BAB9 !important;">1</span>
                รายการบิล
            </label>
            @if (@$row['move_invoice_1'])
            
                {{-- //////////////////////////////////////////////// --}}
                    <div class="my-3" style="border: 1px solid #dbdade;padding: 15px 2px;">
                        <div class="d-flex">
                            <div class="flex-grow-1 ms-3">
                            <b class="text-black">รายละเอียดหัวบิล</b> <br>
                                {{ $row['move_invoice_1']->name }} <br>
                                เลขประจำตัวผู้เสียภาษี {{ $row['move_invoice_1']->id_card_number }} <br>
                                โทร {{ $row['move_invoice_1']->phone }}
                            </div>
                        </div>
                    </div>
                    <table class="table table-detail-receipt mb-4">
                        <thead>
                            <tr>
                                <th>รายการ</th>
                                <th width="30%">จำนวนเงิน (บาท)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($row['move_invoice_1']->payment_list as $key => $payment_list_item)
                                <tr>
                                    {{-- <td>ค่าเช่าห้อง (Room rate) {{ $row['move_invoice_1']->room_for_rent->room->name }} เดือน {{ $row['move_invoice_1']->month.'/'.$row['move_invoice_1']->year }}</td> --}}
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
                                    {{ number_format($row['move_invoice_1']->total_amount) }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>


                {{-- /////////////////////////////////////////////////////// --}}
                @if (@$row['move_invoice_paid_1']->receipt[0])

                    <div class="p-4 mb-4" style="border: 1px solid #59d57a;border-radius: 5px;">
                        <p align="right" style="color: black; font-weight: 500;">เลขที่ใบเสร็จ: &nbsp; <span class="text-success">{{ $row['move_invoice_paid_1']->receipt[0]->receipt_number }}</span></p>
                            <table class="table table-detail table-bordered">
                                <thead>
                                    <tr>
                                        <td width="50%">
                                            <span style="color: black; font-weight: 500;">รายละเอียดหัวบิล</span> <br>
                                            {{ $row['move_invoice_paid_1']->name }} <br>
                                            เลขประจำตัวผู้เสียภาษี {{ $row['move_invoice_paid_1']->id_card_number }} <br>
                                            โทร {{ $row['move_invoice_paid_1']->phone }}
                                        </td>
                                        <td style="color: black;">
                                                    @php
                                                        $date = new DateTime(date('Y-m-d', strtotime($row['move_invoice_paid_1']->created_at)));
                                                        $englishDay = $date->format('l');
                                                        $payment_channel = [1 => 'เงินสด', 2 => 'โอนเงิน', 3 => 'หักจากเงินประกัน'];
                                                    @endphp
                                                        <span style="color: black; font-weight: 500;">วันที่รับชำระเงิน</span> &nbsp; &nbsp; &nbsp; {!! $days[$englishDay].' &nbsp;'.date('d/m/Y', strtotime($row['move_invoice_paid_1']->created_at)) !!}<br>
                                                        <span style="color: black; font-weight: 500;">ช่องทางการชำระเงิน</span> &nbsp; &nbsp; &nbsp; <span @if($row['move_invoice_paid_1']->payment_channel == 3) class="text-danger" @endif>{{ $payment_channel[$row['move_invoice_paid_1']->payment_channel] }}</span><br>
                                                        <span style="color: black; font-weight: 500;">รับชำระโดย</span> &nbsp; &nbsp; &nbsp; {{ $row['move_invoice_paid_1']->user->name }}<br>
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
                                    @foreach ($row['move_invoice_paid_1']->receipt[0]->payment_list as $key => $item_payment_list)
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
                                <button type="button" class="btn btn-label-primary waves-effect" onclick="printPdf({{ $row['move_invoice_paid_1']->receipt[0]->id }})">
                                    <span class="ti-sm ti ti-printer me-2"></span>พิมพ์ใบเสร็จรับเงิน
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-warning mb-4">
                            <i class="ti ti-file-search" style="font-size: 24px;"></i><br>
                            <input type="hidden" id="check_bill" value="1">
                            โปรดชำระเงินใบเสร็จค้างชำระ.!
                        </div>
                    @endif
                @else
                    <div class="text-center text-muted mb-4">
                        <i class="ti ti-file-search" style="font-size: 24px;"></i><br>
                        ไม่พบใบเสร็จค้างชำระ
                    </div>
                @endif
            <div></div>
            <label class="mb-4 text-black" style="font-weight: 500;font-size: large;" for="">
                <span class="badge badge-center rounded-pill me-1 label-move-out" style="background-color: #54BAB9 !important;">2</span>
                ใบเสร็จย้ายออก
            </label>
            @if (@$row['move_invoice_4'])
            
                {{-- //////////////////////////////////////////////// --}}
                    <div class="my-3" style="border: 1px solid #dbdade;padding: 15px 2px;">
                        <div class="d-flex">
                            <div class="flex-grow-1 ms-3">
                            <b class="text-black">รายละเอียดหัวบิล</b> <br>
                                {{ $row['move_invoice_4']->name }} <br>
                                เลขประจำตัวผู้เสียภาษี {{ $row['move_invoice_4']->id_card_number }} <br>
                                โทร {{ $row['move_invoice_4']->phone }}
                            </div>
                        </div>
                    </div>
                    <table class="table table-detail-receipt mb-4">
                        <thead>
                            <tr>
                                <th>รายการ</th>
                                <th width="30%">จำนวนเงิน (บาท)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($row['move_invoice_4']->payment_list as $key => $payment_list_item)
                                <tr>
                                    {{-- <td>ค่าเช่าห้อง (Room rate) {{ $row['move_invoice_4']->room_for_rent->room->name }} เดือน {{ $row['move_invoice_4']->month.'/'.$row['move_invoice_4']->year }}</td> --}}
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
                                    {{ number_format($row['move_invoice_4']->total_amount) }}
                                </th>
                            </tr>
                        </tfoot>
                    </table>


                {{-- /////////////////////////////////////////////////////// --}}
                @if (@$row['move_invoice_4']->receipt[0])

                    <div class="p-4 mb-4" style="border: 1px solid #59d57a;border-radius: 5px;">
                        <p align="right" style="color: black; font-weight: 500;">เลขที่ใบเสร็จ: &nbsp; <span class="text-success">{{ $row['move_invoice_4']->receipt[0]->receipt_number }}</span></p>
                            <table class="table table-detail table-bordered">
                                <thead>
                                    <tr>
                                        <td width="50%">
                                            <span style="color: black; font-weight: 500;">รายละเอียดหัวบิล</span> <br>
                                            {{ $row['move_invoice_4']->name }} <br>
                                            เลขประจำตัวผู้เสียภาษี {{ $row['move_invoice_4']->id_card_number }} <br>
                                            โทร {{ $row['move_invoice_4']->phone }}
                                        </td>
                                        <td style="color: black;">
                                                    @php
                                                        $date = new DateTime(date('Y-m-d', strtotime($row['move_invoice_4']->created_at)));
                                                        $englishDay = $date->format('l');
                                                        $payment_channel = [1 => 'เงินสด', 2 => 'โอนเงิน', 3 => 'หักจากเงินประกัน'];
                                                    @endphp
                                                        <span style="color: black; font-weight: 500;">วันที่รับชำระเงิน</span> &nbsp; &nbsp; &nbsp; {!! $days[$englishDay].' &nbsp;'.date('d/m/Y', strtotime($row['move_invoice_4']->created_at)) !!}<br>
                                                        <span style="color: black; font-weight: 500;">ช่องทางการชำระเงิน</span> &nbsp; &nbsp; &nbsp; <span @if($row['move_invoice_4']->payment_channel == 3) class="text-danger" @endif>{{ $payment_channel[$row['move_invoice_4']->payment_channel] }}</span><br>
                                                        <span style="color: black; font-weight: 500;">รับชำระโดย</span> &nbsp; &nbsp; &nbsp; {{ $row['move_invoice_4']->user->name }}<br>
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
                                    @foreach ($row['move_invoice_4']->receipt[0]->payment_list as $key => $item_payment_list)
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
                                <button type="button" class="btn btn-label-primary waves-effect" onclick="printPdf({{ $row['move_invoice_4']->receipt[0]->id }})">
                                    <span class="ti-sm ti ti-printer me-2"></span>พิมพ์ใบเสร็จรับเงิน
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="text-center text-warning mb-4">
                            <i class="ti ti-file-search" style="font-size: 24px;"></i><br>
                            <input type="hidden" id="check_bill" value="1">
                            โปรดชำระเงินใบเสร็จย้ายออก.!
                        </div>
                    @endif
                @else
                    <div class="text-center text-muted mb-4">
                        <i class="ti ti-file-search" style="font-size: 24px;"></i><br>
                        ไม่พบใบเสร็จย้ายออก
                    </div>
                @endif

    {{-- ///////////////////////////////////////////////////////////////////////// --}}
    {{-- ///////////////////////////////////////////////////////////////////////// --}}
    {{-- ///////////////////////////////////////////////////////////////////////// --}}
                <div></div>
                <label class="mb-4 text-black" style="font-weight: 500;font-size: large;" for="">
                    <span class="badge badge-center rounded-pill me-1 label-move-out" style="background-color: #54BAB9 !important;">3</span>
                    เงินประกัน
                </label>
                <table class="table table-bordered table-detail mb-4" id="discount-table3" >
                    <thead>
                        <tr>
                            <th>รายการคืนเงินประกัน</th>
                            <th width="35%">จำนวนเงิน (บาท)</th>
                        </tr>
                    </thead>
                    <tbody>
                            @foreach ($row['move_invoice_6']->payment_list as $k => $prakan)
                            @php
                            // if ($prakan->discount == 1) {
                            //     continue;
                            // }
                                
                            @endphp
                                <tr>
                                    <td>
                                        @if ($k == 0)
                                            {{ $prakan->title }}
                                            <input name="payment_list_p[title][]" type="hidden" class="payment_list_title" value="{{ $prakan->title }}">
                                        @else
                                            <input name="payment_list_p[title][]" type="text" class="form-control payment_list_title" placeholder="หัวข้อรายการ" value="{{ $prakan->title }}">
                                        @endif
                                    </td>
                                    <td class="text-end">
                                        <input type="hidden" name="payment_list_p[price][]" class="form-control" value="{{ (int)$prakan->price }}" placeholder="จำนวนเงิน" max="" oninput="calculate_3Price()">
                                        {{ number_format((int)$prakan->price) }}
                                    </td>
                                </tr>
                            @endforeach
                        

                    </tbody>
                    <tfoot>
                            <input type="hidden" class="total-price_3" id="deposit_amount" value="{{ isset($row['move_invoice_6']) ? $row['move_invoice_6']->payment_list->sum('price') : 0 }}">
                        <tr>
                            <th>รวม</th>
                            <th class="text-end mb-0 fw-bold total-price_3">
                                {{ isset($row['move_invoice_6']) ? number_format($row['move_invoice_6']->payment_list->sum('price')) : 0 }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
                @if(!$loop->last)
                    <hr style="height: 15px; border-radius: 3px; background-color: var(--bs-warning); border: none;">
                @endif
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
                    <input type="hidden" name="insert_single[payment_format]" value="1">
                    <b class="text-black">ช่องทางการชำระเงิน</b> <br>
                    <div class="col-sm-11">
                        <input name="insert_single[move_out_payment_channel]" class="form-check-input me-1 reservation_payment_channel_Lhai" type="radio" id="reservation_payByCashLhai" value="1" checked>
                        <label class="form-check-label" for="reservation_payByCashLhai"> เงินสด </label>
                    </div>

                    <div id="paymentChanel_ResLhai2">
                        <div class="col-sm-6 mb-2">
                            <label for="payment_date_lhai">วันที่ชำระเงิน</label>
                            <input type="text" name="insert_single[payment_date]" class="form-control" placeholder="" id="payment_date_lhai" autocomplete="off" value="{{date('d/m/Y')}}"/>
                        </div>
                    </div>

                    <div class="col-sm-11">
                        <input name="insert_single[move_out_payment_channel]" class="form-check-input me-1 reservation_payment_channel_Lhai" type="radio" id="reservation_payByTransferLhai" value="2">
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
                        <h4 class="my-4" align="center">
                            @if ($calculate >= 0)
                            <span class="text-danger">
                                ยอดเงินประกันคืนผู้เช่า
                            @else
                            <span class="text-success">
                                เก็บเงินผู้เช่าเพิ่ม
                            @endif
                            &nbsp; {{ number_format(abs($calculate)) }}&nbsp; บาท
                            </span>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

  <script>    
        function deleteMoveOutRoom(room_id) {
            deleteMoveOutRooms.push(room_id);   // ✔ push room_id เข้า array
            get_room_move_out("{{ $renter_id }}")
        }
        function calculate_receipt(k){
            let total = 0;

            $('.receipt-list').each(function() {
                total += parseFloat($(this).val()) || 0; // ถ้าเป็น input
                // total += parseFloat($(this).text()) || 0; // ถ้าเป็น text ใน span/div
            });

            $('.total-receipt'+k).val(total);
            $('.total-receipt'+k).html(total);
        }
        const fpOpts = { dateFormat: 'd/m/Y', allowInput: true, static: true, disableMobile: true };
        flatpickr('#payment_date_lhai', fpOpts);
        flatpickr('#payment_date_lhai2', fpOpts);
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

        
    function deleteBillReserveRoom(id){
        if ($('.billReserveRoom').length > 1) {
            $("#billReserveRoom"+id).remove();
        } else {
            Swal.fire('ไม่สามารถลบได้', 'การชำระค่าจองต้องมีอย่างน้อย 1 ห้อง', 'warning');
        }
    }

  </script>