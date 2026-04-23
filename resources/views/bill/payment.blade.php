<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<div class="modal-header rounded-0">
    <span class="modal-title">
        <span class="h5" style="color: rgb(232, 255, 226);">ห้อง {{ $invoice->room_for_rent->room->name }}</span>
        <span class="ms-2">
            {{-- {{ date('m/Y', strtotime($invoice->month.' '.$invoice->year)) }} --}}
            @php
            $monthNames = [
                            '1' => 'มกราคม', '2' => 'กุมภาพันธ์', '3' => 'มีนาคม', '4' => 'เมษายน',
                            '5' => 'พฤษภาคม', '6' => 'มิถุนายน', '7' => 'กรกฎาคม', '8' => 'สิงหาคม',
                            '9' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม'
                        ];
                        echo $monthNames[$invoice->month].' '.$invoice->year;
            @endphp

        </span>
        <span class="ms-2" style="border: 1px solid #69c2c1;padding: 7px 12px;border-radius: 5px;font-size: smaller;">{{ $invoice->invoice_number }}</span>
    </span>
    <span class="badge bg-label-{{ $invoice->status->color }} m-auto" text-capitalized="" style="font-size: unset;" >
        <span class="ti-md ti {{ $invoice->status->icon }} me-2"></span>{{ $invoice->status->name }}
    </span>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

    <div class="modal-body pb-1">
        <div class="card shadow-none bg-transparent ms-auto mb-4">
            <ul class="nav nav-pills" role="tablist" style="">
                <li class="nav-item" role="presentation">
                    <button type="button" class="btn btn-outline-primary nav-link active" 
                    role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-edit" aria-controls="navs-pills-top-edit" aria-selected="false" tabindex="-1">
                    <span>
                        <i class="ti-md ti ti-file"></i>
                        <b class="dam">
                        รายละเอียด
                        </b>
                    </span>
                    </button>
                </li>
                @if (@$overdue == null)
                    @if ($invoice->total_amount - $receipt_total_amount > 0)
                        <li class="nav-item" role="presentation">
                            <button type="button" class="btn btn-outline-info nav-link"
                            role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-contract" aria-controls="navs-pills-top-contract" aria-selected="false" tabindex="-1">
                            <span>
                                <i class="ti-md ti ti-report-money"></i>
                                <b class="dam">
                                ชำระเงิน
                                </b>
                            </span>
                            </button>
                        </li>
                    @endif
                @endif
            </ul>
        </div>
        <div class="tab-content" style="box-shadow: unset;padding:0px">
            <div class="tab-pane fade active show" id="navs-pills-top-edit" role="tabpanel">
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
            <table class="table table-bordered" id="discount-table">
                <thead>
                    <tr>
                        <th>รายการ</th>
                        <th>จำนวนเงิน (บาท)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($invoice->payment_list as $key => $payment_list_item)
                        <tr>
                            {{-- <td>ค่าเช่าห้อง (Room rate) {{ $invoice->room_for_rent->room->name }} เดือน {{ $invoice->month.'/'.$invoice->year }}</td> --}}
                            <td class="{{$payment_list_item->discount == 1 ? "text-danger fw-bold" : ""}}" style="display: flex; align-items: center;">
                                {{ $payment_list_item->title }}@if (strpos($payment_list_item->title, 'Water rate') !== false){{ number_format($payment_list_item->unit) }}&nbsp;- &nbsp;{{ $invoice->previous_water_unit ?? 0 }} = {{ $payment_list_item->unit-$invoice->previous_water_unit }} ยูนิต)@endif
                            </td>
                            <td class="text-end {{$payment_list_item->discount == 1 ? "text-danger fw-bold" : ""}}">
                            @if ($payment_list_item->unit > 0)
                                <input type="hidden" class="calculate" name="water_amount" id="water_amount" value="{{ $payment_list_item->price }}">
                                    <span id="text_water_amount">
                                        {{ number_format($payment_list_item->price) }}
                                    </span>
                            @else
                                @if ($payment_list_item->discount == 1)
                                    {{ number_format(0-$payment_list_item->price) }}
                                    <input type="hidden" class="calculate" value="{{0-$payment_list_item->price}}">
                                @else
                                    {{ number_format($payment_list_item->price) }}
                                    <input type="hidden" class="calculate" value="{{$payment_list_item->price}}">
                                @endif
                            @endif
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
            <div class="my-2 mx-2"><b>หมายเหตุ: </b>{{ $invoice->remark }}</div>
            <div class="modal-footer d-flex justify-content-between rounded-0">
                <div>
                    <button type="button" class="btn btn-primary waves-effect" onclick="printPdf({{ $invoice->id }})">
                        <span class="ti-md ti ti-printer me-2"></span>พิมพ์ใบแจ้งหนี้
                    </button>
                </div>
                    @if (@$overdue == null)
                        @if(Auth::user()->user_has_branch->position->id == 1)
                            @if ($invoice->ref_status_id == 7 & count($invoice->receipt) == 0)
                                <button class="btn btn-danger" onclick="changeStatusBill({{ $invoice->id }},3,'ยกเลิกใบแจ้งหนี้')">
                                    <span>
                                        <i class="ti-md ti ti-x"></i>
                                        ยกเลิกใบแจ้งหนี้
                                    </span>
                                </button>
                            @endif
                        @endif
                    @endif
                    @foreach ($invoice->receipt as $key => $item_receipt)
                        
                            <table class="table table-detail table-bordered">
                                <thead>
                                    <tr>
                                        <th width="50%" style="vertical-align: middle;font-weight: 500;">สถานะบิล</th>
                                        <th style="vertical-align: middle; font-weight: 500;">
                                            <div style="display: flex; align-items: center; gap: 4px;">
                                                <i class="ti ti-checkbox text-success" style="font-size: 34px"></i>
                                                <div>
                                                    <span class="text-success">ชำระเงิน (ผ่านเคาน์เตอร์หอพัก)</span><br>
                                                    <span style="font-weight: 500; font-size: smaller;">
                                                        เมื่อ {{ date('d/m/Y , H:i น.', strtotime($item_receipt->created_at)) }} โดย {{ $item_receipt->user->name }}
                                                    </span>
                                                </div>
                                            </div>
                                            {{-- <span class="text-danger">ค้างชำระ</span><br> --}}
                                        </th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td> วันที่รับชำระเงิน </td>
                                        <td>
                                        @php
                                            $date = new DateTime(date('Y-m-d', strtotime($item_receipt->created_at)));
                                            $englishDay = $date->format('l');
                                            
                                        @endphp
                                            {!! $days[$englishDay].' &nbsp;'.date('d/m/Y', strtotime($item_receipt->created_at)) !!}</td>
                                    </tr>
                                    <tr>
                                        <td> ช่องทางการชำระเงิน </td>
                                        <td>{{ $item_receipt->payment_channel == 1 ? "เงินสด": "โอนเงิน"; }}</td>
                                    </tr>
                                </tbody>
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
                                    @foreach ($item_receipt->payment_list as $key => $item_payment_list)
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
                            <div class="modal-footer rounded-0 justify-content-start mt-2 pb-0">
                                <button type="button" class="btn btn-label-primary waves-effect" onclick="printPdfReceipt({{$item_receipt->id}})"><span
                                        class="ti-sm ti ti-printer me-2"></span>พิมพ์ใบเสร็จรับเงิน</button>
                            </div>
                            @if ($key+1 < count($invoice->receipt))
                                <hr class="mb-4">
                            @endif
                            {{-- @if ($invoice->ref_status_id != 5) --}}
                            @php
                                $permission_cancel_confirm = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 24)->where('status', 0)->first();
                            @endphp
                                <button class="btn btn-danger me-2" onclick="changeDeleteReceipt({{ $item_receipt->id }},{{$invoice->id}})" @if ($permission_cancel_confirm) style="display: none!important;" @endif>
                                    <span>
                                        <i class="ti-md ti ti-x"></i>
                                        ยกเลิกใบเสร็จ
                                    </span>
                                </button>
                            {{-- @endif --}}
                    @endforeach
                </div>
                </div>
            </div>
          </div>
        </div>
        
<form id="payment_bill" enctype="multipart/form-data">
    @csrf
    
    <input name="ref_room_id" type="hidden" value="{{ $contract->ref_room_id }}">
    <input name="ref_rent_bill_id" type="hidden" value="{{ $invoice->id }}">
    <input name="ref_contract_id" type="hidden" value="{{ $contract->id }}">
    <input name="ref_renter_id" type="hidden" value="{{ $contract->ref_renter_id }}">
    <input name="ref_type_id" type="hidden" value="1">
    <input name="amount" class="total-price" type="hidden">
    {{-- <input type="hidden" name="id_invoice" value="{{ $invoice->id }}"> --}}
    <input type="hidden" name="id" value="{{$invoice->id}}">
        {{-- ////////////////////////////////////////////////// --}}
        <div class="tab-content" style="box-shadow: unset;padding:0px">
            <div class="tab-pane fade show px-4" id="navs-pills-top-contract" role="tabpanel">
                <div class="tab-content" style="box-shadow: unset;padding:0px">
                        </h4>
                        <div class="mb-3 pb-4" style="border: 1px solid #dbdade;padding: 15px 2px;">
                            <div class="d-flex">
                                <div class="flex-grow-1 ms-3 g-3 row">
                                    <b class="text-black">รูปแบบการชำระเงิน</b> <br>
                                            <div class="col-sm-11">
                                                <input name="payment_format" class="form-check-input" type="radio" id="payfull" value="1" 
                                                @if (count($invoice->receipt) == 0)
                                                checked    
                                                @else
                                                disabled
                                                @endif
                                                >
                                                <label class="form-check-label" for="payfull"> จ่ายเต็มจำนวน </label>
                                            </div>
                                            <div class="col-sm-11">
                                                <input name="payment_format" class="form-check-input" type="radio" id="checksplit" value="2"
                                                @if (count($invoice->receipt) > 0)
                                                checked    
                                                @endif
                                                > 
                                                <label class="form-check-label" for="checksplit"> แบ่งจ่าย </label>
                                            </div>
                                
                                            <div class="col-sm-11" id="divsplit" 
                                                @if (count($invoice->receipt) == 0)
                                                    style="display: none;"
                                                @endif
                                            >
                                                
                                            <div class="p-2">
                                                <label class="h5 mb-2 d-block">เลือกรายการจากใบแจ้งหนี้</label>
                                                <div class="d-flex flex-wrap gap-4 mb-2">

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input bill-list-payment-checkbox" type="checkbox"
                                                            value="payment_list_not_paid"
                                                            id="payment_list_not_paid"
                                                            checked
                                                            >
                                                        <label class="form-check-label" for="payment_list_not_paid">
                                                            เต็มจำนวน
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input bill-list-payment-checkbox list-payment-check-box" type="checkbox"
                                                            value="payment_rent_room_array"
                                                            id="payment_rent_room_array"
                                                            >
                                                        <label class="form-check-label" for="payment_rent_room_array">
                                                            ค่าเช่าห้อง
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input bill-list-payment-checkbox list-payment-check-box" type="checkbox"
                                                            value="payment_meter_array"
                                                            id="payment_meter_array"
                                                            >
                                                        <label class="form-check-label" for="payment_meter_array">
                                                            ค่าน้ำ-ค่าไฟฟ้า
                                                        </label>
                                                    </div>

                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input bill-list-payment-checkbox list-payment-check-box" type="checkbox"
                                                            value="payment_parking_fee_array"
                                                            id="payment_parking_fee_array"
                                                            >
                                                        <label class="form-check-label" for="payment_parking_fee_array">
                                                            ค่าที่จอดรถ
                                                        </label>
                                                    </div>
                                                    
                                                    <div class="form-check form-check-inline">
                                                        <input class="form-check-input bill-list-payment-checkbox list-payment-check-box" type="checkbox"
                                                            value="payment_other_array"
                                                            id="payment_other_array"
                                                            >
                                                        <label class="form-check-label" for="payment_other_array">
                                                            อื่น ๆ
                                                        </label>
                                                    </div>

                                                </div>
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
                                            <div id="div-form-payment-rent-bill">
                                                <table class="table table-bordered" id="discount-table2" >
                                                    <thead>
                                                        <tr>
                                                            <th>รายการ</th>
                                                            <th width="35%">จำนวนเงิน (บาท)</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        @if ($fine_price > 0)
                                                        <input type="hidden" name="fine_paid_at" value="1">
                                                            <tr>
                                                                <td style="display: flex; align-items: center;">
                                                                    ค่าปรับ เกินชำระ
                                                                    {{ date_diff(date_create(date('Y-m', strtotime($invoice->created_at)).'-'.str_pad($invoice->room_for_rent->room->start_fine_day, 2, '0', STR_PAD_LEFT)), date_create(date('Y-m-d')))->days }}
                                                                    วัน
                                                                    <input type="hidden" name="payment_list[title][]"
                                                                    value="ค่าปรับ เกินชำระ
                                                                    {{ date_diff(date_create(date('Y-m', strtotime($invoice->created_at)).'-'.str_pad($invoice->room_for_rent->room->start_fine_day, 2, '0', STR_PAD_LEFT)), date_create(date('Y-m-d')))->days }}
                                                                    วัน">
                                                                </td>
                                                                <td class="text-end">
                                                                    {{ number_format($fine_price) }}
                                                                    <input type="hidden" name="payment_list[price][]" class="calculate_2"
                                                                    value="{{ $fine_price }}">
                                                                    <input type="hidden" name="payment_list[discount][]" value="0">
                                                                </td>
                                                            </tr>
                                                        @endif
                                                            <tr>
                                                                <td>
                                                                    <input name="payment_list[title][]" type="text" class="form-control payment_list_title" value="แบ่งจ่ายค่าห้อง {{ $invoice->room_for_rent->room->name }}" placeholder="หัวข้อรายการ">
                                                                </td>
                                                                <td class="text-end">
                                                                    <input type="number" name="payment_list[price][]" class="form-control calculate_2" value="{{ $invoice->total_amount - $receipt_total_amount-$fine_price }}" placeholder="จำนวนเงิน" max="" oninput="calculate_2Price()">
                                                                    <input type="hidden" name="payment_list[discount][]" value="0">
                                                                </td>
                                                            </tr>
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <th>รวม</th>
                                                            <th class="text-end mb-0 fw-bold total-price_2">
                                                                0
                                                            </th>
                                                        </tr>
                                                    </tfoot>
                                                </table>
                                            </div>
                                                
                                                {{-- <div align="right">
                                                    <button id="add_discount2"
                                                            style="padding-right: 14px;padding-left: 14px;"
                                                            class="btn btn-sm buttons-collection btn-label-danger waves-effect waves-light me-2 mt-2"
                                                            tabindex="0" aria-controls="DataTables_Table_0"
                                                            type="button" aria-haspopup="dialog"
                                                            aria-expanded="false">
                                                        <i class="ti ti-plus"></i> เพิ่มส่วนลด
                                                    </button>

                                                    <button id="add_expenses2"
                                                            style="padding-right: 14px;padding-left: 14px;"
                                                            class="btn btn-sm buttons-collection btn-label-warning waves-effect waves-light me-2 mt-2"
                                                            tabindex="0" aria-controls="DataTables_Table_0"
                                                            type="button" aria-haspopup="dialog"
                                                            aria-expanded="false">
                                                        <i class="ti ti-plus"></i> เพิ่มรายการ
                                                    </button>
                                                </div> --}}
                                                <div class="col-sm-11 mt-3 mb-3">
                                                    <label>หมายเหตุ</label>
                                                    <input name="remark" type="text" class="form-control" placeholder="หมายเหตุ" />
                                                </div>
                                                
                                                <script>
                                                    payPaymentMultipleRentBills();
                                                    document.getElementById("payment_list_not_paid").addEventListener("change", function () {
                                                        if (this.checked) {
                                                            // ยกเลิกการเลือกอย่างอื่นทั้งหมด
                                                            document.querySelectorAll(".list-payment-check-box").forEach(ch => ch.checked = false);
                                                        }
                                                        payPaymentMultipleRentBills();
                                                    });

                                                    // เมื่อเลือก option อื่น ๆ
                                                    document.querySelectorAll(".list-payment-check-box").forEach(ch => {
                                                        ch.addEventListener("change", function () {
                                                            if (this.checked) {
                                                                document.getElementById("payment_list_not_paid").checked = false; // ยกเลิก "เต็มจำนวน"
                                                            }
                                                            payPaymentMultipleRentBills();
                                                        });
                                                    });
                                                // new TomSelect(".select-room-payment-bill", {
                                                //     create: false,
                                                //     maxItems: 1,
                                                //     allowEmptyOption: true,
                                                //     sortField: { field: "text", direction: "desc" }
                                                // });
                                                function payPaymentMultipleRentBills() // modal ชำระเงินหลายห้อง
                                                {
                                                    let list = [];
                                                    $('.bill-list-payment-checkbox:checked').each(function() {
                                                        list.push($(this).val());
                                                    });

                                                    $.ajax({
                                                        type: "GET",
                                                        url: "{{$page_url}}/get-list-payment-by-id",
                                                        data: {
                                                            invoice_id: {{ $invoice->id }},
                                                            list: list
                                                        },
                                                        success: function(data) {
                                                            // $("#div-form-payment-rent-bill").html(data.html);
                                                            $("#div-form-payment-rent-bill").html(data);
                                                            // if(data.have == 1){
                                                            //     $('#submit_payment_bill_form_all').prop('disabled', false);
                                                            // }else{
                                                            //     $('#submit_payment_bill_form_all').prop('disabled', true);
                                                            // }
                                                        }
                                                    });
                                                }
                                                document.getElementById('add_expenses2').addEventListener('click', function() {
                                                    const tableBody = document.querySelector('#discount-table2 tbody');
                                                    const newRow = document.createElement('tr');
                                                    newRow.style.backgroundColor = 'rgb(255 240 225)'; // Set background color
                                                    newRow.innerHTML = `
                                                        <td>
                                                            <input name="payment_list[title][]" type="text" class="form-control payment_list_title" placeholder="หัวข้อรายการ" required />
                                                        </td>
                                                        <td class="text-end">
                                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                                <input name="payment_list[price][]" type="number" class="form-control calculate_2 add_expenses2_price" oninput="calculate_2Price()" placeholder="จำนวนเงิน" required style="flex: 1;" autocomplete=off />
                                                                <input type="hidden" name="payment_list[discount][]" value="0">
                                                                <button type="button" class="btn btn-danger btn-sm remove-row2">ลบ</button>
                                                            </div>
                                                        </td>
                                                    `;
                                                    
                                                    tableBody.appendChild(newRow);
                                                    addRemoveEvent_2(newRow);
                                                });
                                                document.getElementById('add_discount2').addEventListener('click', function() {
                                                    const tableBody = document.querySelector('#discount-table2 tbody');
                                                    const newRow = document.createElement('tr');
                                                    newRow.style.backgroundColor = '#ffe0e0'; // สีแดงอ่อนสำหรับส่วนลด

                                                    newRow.innerHTML = `
                                                        <td>
                                                            <input name="payment_list[title][]" type="text" class="form-control payment_list_title" placeholder="ส่วนลด" value="ส่วนลด" required />
                                                        </td>
                                                        <td class="text-end">
                                                            <div style="display: flex; align-items: center; gap: 10px;">
                                                                <input name="payment_list[price][]" type="number" class="form-control calculate_2 discount_price_2" oninput="calculate_2Price()" placeholder="จำนวนเงิน" required style="flex: 1;" autocomplete=off />
                                                                <input type="hidden" name="payment_list[discount][]" value="1">
                                                                <button type="button" class="btn btn-danger btn-sm remove-row2">ลบ</button>
                                                            </div>
                                                        </td>
                                                    `;

                                                    tableBody.appendChild(newRow);
                                                    addRemoveEvent_2(newRow);
                                                });
                                            
                                                function addRemoveEvent_2(row) {
                                                    row.querySelector('.remove-row2').addEventListener('click', function() {
                                                        row.remove();
                                                        calculate_2Price();
                                                    });
                                                }
                                                setTimeout(() => {
                                                    calculate_2Price();
                                                }, 1000);
                                                function calculate_2Price() { 
                                                    const inputs = document.querySelectorAll('.calculate_2');  // เลือกทุก input ที่มี class="calculate"
                                                    let total = 0;

                                                    inputs.forEach(input => {
                                                        // ลบเครื่องหมายจุลภาคจากค่าที่รับมา
                                                        let value = input.value.replace(/,/g, ''); 
                                                        
                                                        if (value.trim() !== "" && !isNaN(value)) {
                                                            // ตรวจสอบว่า input มี class="discount_price_2" หรือไม่
                                                            if (input.classList.contains('discount_price_2')) {
                                                                // ถ้ามี class="discount_price_2", ลบค่าออกจาก total
                                                                total -= parseFloat(value.replace(/[^0-9.-]+/g, ""));
                                                            } else {
                                                                // ถ้าไม่มี class="discount_price_2", เพิ่มค่าเข้าไปใน total
                                                                if (!isNaN(value) && value.trim() !== "") {
                                                                    total += parseFloat(value);
                                                                }
                                                            }
                                                        }
                                                    });
                                                    $('.total-price_2').html(total.toLocaleString());
                                                    $('.total-price_2').val(total);

                                                    // อัปเดตค่า total ใน span#total-price
                                                    // document.getElementById('total-price').innerText = total.toLocaleString();
                                                }

                                                </script>
                                    
                                    {{-- <b>ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price">{{ number_format($invoice->room_for_rent->room->rent + $invoice->water_amount+$invoice->electricity_amount) }}</span> &nbsp;บาท</b> --}}
                                </div>
                                        {{-- <div class="row mt-2" id="expenses-split-container">
                                        </div> --}}
                                <script>
                                    document.getElementById('checksplit').addEventListener('change', function() {
                                        // calculate_2Price();
                                        calculatePrice_2()
                                        document.getElementById('divsplit').style.display = this.checked ? 'block' : 'none';
                                        document.getElementById('totalsplit').style.display = this.checked ? 'block' : 'none';
                                        document.getElementById('totalpayfull').style.display = this.checked ? 'none' : 'block';
                                        $('.payment_list_title').attr('required', true);
                                    });

                                    document.getElementById('payfull').addEventListener('change', function() {
                                        document.getElementById('divsplit').style.display = this.checked ? 'none' : 'block';
                                        document.getElementById('totalsplit').style.display = this.checked ? 'none' : 'block';
                                        document.getElementById('totalpayfull').style.display = this.checked ? 'block' : 'none';
                                        $('.payment_list_title').removeAttr('required');

                                    });
                                </script>
                            </div>
                            </div>
                        </div>

                        <div class="mb-3 pb-4" style="border: 1px solid #dbdade;padding: 15px 2px;">
                            <div class="d-flex">
                                <div class="flex-grow-1 ms-3 g-3 row">
                                    <b class="text-black">ช่องทางการชำระเงิน</b> <br>
                                    <div class="col-sm-11">
                                        <input name="payment_channel" class="form-check-input" type="radio" id="defaultRadio1" value="1" checked onclick="togglePaymentFields()">
                                        <label class="form-check-label" for="defaultRadio1"> เงินสด </label>
                                    </div>
                                    
                                    <div id="paymentDetails2">
                                        <div class="col-sm-6 mb-2">
                                            <label for="payment_date">วันที่ชำระเงิน</label>
                                            <input type="text" name="payment_date" class="form-control" placeholder="" id="payment_date" required autocomplete="off" value="{{date('d/m/Y')}}"/>
                                        </div>
                                    </div>
                                    <div class="col-sm-11">
                                        <input name="payment_channel" class="form-check-input" type="radio" id="defaultRadio2" value="2" onclick="togglePaymentFields()"> 
                                        <label class="form-check-label" for="defaultRadio2"> โอนเงิน </label>
                                    </div>
                        
                                    <!-- แสดงเมื่อเลือก โอนเงิน -->
                                    <div id="paymentDetails" style="display:none;">
                                        
                                        <div class="col-sm-6 mb-2">
                                            <label>เลือกบัญชีธนาคาร</label>
                                            <select class="select2 form-select mb-2" name="ref_bank_id" id="exampleFormControlSelect1">
                                                {{-- <option value="" disabled="" selected="selected">บัญชีธนาคาร</option> --}}
                                                @foreach ($bank as $r_bank)
                                                    <option value="{{ $r_bank->id }}">{{ $r_bank->bank.' '.$r_bank->bank_account_name }}</option>
                                                @endforeach

                                        </div>
                                        <div class="col-sm-4 mb-2">
                                            <input type="hidden" name="">
                                        </div>
                                            <div class="col-sm-3 mb-2">
                                                <label for="transfer_time">เวลาโอนเงิน</label><span class="text-danger"> *</span>
                                                <input type="time" name="transfer_time" class="form-control" placeholder="" id="transfer_time" autocomplete="off" required/>
                                            </div>
                                            <div class="col-sm-6 mb-2">
                                                <label for="payment_date2">วันที่โอนเงิน</label><span class="text-danger"> *</span>
                                                <input type="text" name="payment_date2" class="form-control" placeholder="" id="payment_date2" autocomplete="off" value="{{date('d/m/Y')}}" required/>
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
                                         @if (count($invoice->receipt) == 0)
                                            <b id="totalpayfull">ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price">{{ number_format($invoice->total_amount - $receipt_total_amount) }}</span> &nbsp;บาท</b>
                                        @endif
                                            <b id="totalsplit" 
                                                @if (count($invoice->receipt) == 0)
                                                    style="display: none"
                                                @endif
                                            >ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price_2">0</span> &nbsp;บาท</b>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <script>
                            function togglePaymentFields() {
                                const paymentChannel = document.querySelector('input[name="payment_channel"]:checked').value;
                                const paymentDetails = document.getElementById('paymentDetails');
                                const paymentDetails2 = document.getElementById('paymentDetails2');
                                // หากเลือก โอนเงิน (value=2) ให้แสดงฟอร์มเพิ่ม
                                if (paymentChannel == '2') {
                                    paymentDetails.style.display = 'block';
                                    paymentDetails2.style.display = 'none';
                                    $('#ref_bank_id').attr('required', true);
                                    $('#transfer_time').attr('required', true);
                                    $('#payment_date2').attr('required', true);
                                } else {
                                    paymentDetails.style.display = 'none';
                                    paymentDetails2.style.display = 'block';
                                    $('#ref_bank_id').removeAttr('required');
                                    $('#transfer_time').removeAttr('required');
                                    $('#payment_date2').removeAttr('required')
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
                            togglePaymentFields();
                        </script>

                        <h4 class="text-center text-danger">ยอดค้างชำระเงินทั้งหมด&nbsp; <span class="">{{ number_format($invoice->total_amount - $receipt_total_amount ) }}</span> &nbsp;บาท
                        
                        
                        <div class="modal-footer d-flex justify-content-between rounded-0">
                            <div>
                                <button type="button" class="btn btn-primary waves-effect" onclick="printPdf({{ $invoice->id }})">
                                    <span class="ti-md ti ti-printer me-2"></span>พิมพ์ใบแจ้งหนี้
                                </button>
                            </div>
                            <div>
                                <button class="btn btn-info" type="submit" id="submit_payment">
                                    <span>
                                        <i class="ti-md ti ti-report-money"></i>
                                        <b class="dam">ชำระ</b>
                                    </span>
                                </button>
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </form>        
    </div>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    
        flatpickr('#payment_date', {
            dateFormat: 'd/m/Y',
            defaultDate: 'today',
            allowInput: true
        });
        flatpickr('#payment_date2', {
            dateFormat: 'd/m/Y',
            defaultDate: 'today',
            allowInput: true
        });

        
        function paymentChannel(i) {
            $('#payment_channel').val(i);
        }
        function calculatePrice_2() { 
            const inputs = document.querySelectorAll('.calculate_2');  // เลือกทุก input ที่มี class="calculate"
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
            if(total > 0){
                $('#submit_payment').prop('disabled', false);
            }else{
                $('#submit_payment').prop('disabled', true);
            }
            $('.total-price_2').html(total.toLocaleString());

            // อัปเดตค่า total ใน span#total-price
            // document.getElementById('total-price').innerText = total.toLocaleString();
        }
        
        $('#payment_bill').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ บันทึกการเปลี่ยนแปลง หรือไม่?',
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

                    var formData = new FormData($('#payment_bill')[0]);

                    $.ajax({
                        url: '{{ $page_url }}/payment_bill', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function(response) {
                            if(response == true){
                                $('#invoice').modal('hide');
                                summary();
                                loadData(page);
                                Swal.fire('บันทึกเรียบร้อยแล้ว', '', 'success');
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
</script>