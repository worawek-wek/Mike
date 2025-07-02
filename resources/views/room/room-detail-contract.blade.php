        {{-- อันนี้แหละ หน้า สัญญาเช่า -> แสดงข้อมูลสัญญา --}}
        {{-- อันนี้แหละ หน้า สัญญาเช่า -> แสดงข้อมูลสัญญา --}}
        {{-- อันนี้แหละ หน้า สัญญาเช่า -> แสดงข้อมูลสัญญา --}}

        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0" style="color: black;">ข้อมูลสัญญา</h5>
            <button type="button" class="btn btn-warning" onclick="edit_contract()">
                <span>
                    <i class="ti ti-pencil"></i> แก้ไขข้อมูลสัญญา
                </span>
            </button>
        </div>
        <style>
        .table-detail td, .table-detail th {
            color: black;
        }
        </style>
            <table class="table table-detail table-bordered mb-4">
                <tbody>
                    <tr>
                        <td width="70%">ชื่อผู้เข้าพัก</td>
                        <td>{{ @$contract->renter->prefix.' '.@$contract->renter->name.' '.@$contract->renter->surname }}</td>
                    </tr>
                    <tr>
                        <td>เลขบัตรประชาชน/Passport</td>
                        <td>{{ @$contract->id_card_number }}</td>
                    </tr>
                    <tr>
                        <td>เบอร์โทร</td>
                        <td>{{ @$contract->phone }}</td>
                    </tr>
                    <tr>
                        <td>วันที่ทำสัญญา</td>
                        <td>{{ date('d/m/Y', strtotime(@$contract->contract_date)) }}</td>
                    </tr>
                    <tr>
                        <td>ระยะเวลาสัญญา</td>
                        <td>{{ @$contract->period }} เดือน</td>
                    </tr>
                    <tr>
                        <td>วันที่สิ้นสุดสัญญา</td>
                        <td>{{ @$contract_date_to }}</td>
                    </tr>
                    <tr>
                        <td>ค่าเช่าห้อง</td>
                        <td>{{ @number_format($room->rent) }}</td>
                    </tr>
                </tbody>    
            </table>
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0" style="color: black;">ข้อมูลเงินประกันห้อง</h5>
            <button class="btn btn-warning" onclick="openDe({{ @$rent_bill->id }} , {{ $contract->contract_id }})"
                role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-contract-edit" aria-controls="navs-pills-top-contract-edit" aria-selected="false" tabindex="-1"
                @if(($contract->security_deposit-$contract->deduction_booking_amount) <= $receipt->sum->amount)
                disabled
                @endif
                >
                <span>
                    <i class="ti ti-pencil"></i> แก้ไขการชำระเงิน
                </span>
            </button>
        </div>

{{--  --}}
        @if(($contract->security_deposit-$contract->deduction_booking_amount) > $receipt->sum->amount)

        <h5 class="text-center text-danger">ยอดค้างชำระเงินทั้งหมด&nbsp; <span>
            {{ number_format(($contract->security_deposit-$contract->deduction_booking_amount) - $receipt->sum->amount) }}
            {{-- {{ number_format($invoice->room_for_rent->room->rent + $invoice->water_amount+$invoice->electricity_amount) }} --}}
            </span> &nbsp;บาท
        </h5>

        @else

        <h5 class="text-center text-success">ชำระเงินแล้ว&nbsp;
            {{ number_format($contract->security_deposit) }} &nbsp;บาท
        </h5>
        
        @endif
{{--  --}}

    @foreach ($receipt as $key => $item_receipt)
        <div class="p-4" style="border: 1px solid #59d57a;border-radius: 5px;">
        <p align="right" style="color: black; font-weight: 500;">เลขที่ใบเสร็จ: &nbsp; <span class="text-success">{{ $item_receipt->receipt_number }}</span></p>
            <table class="table table-detail table-bordered">
                <thead>
                    <tr>
                        <td width="50%">
                            <span style="color: black; font-weight: 500;">รายละเอียดหัวบิล</span> <br>
                            {{ $contract->full_name }} <br>
                            เลขประจำตัวผู้เสียภาษี {{ $contract->id_card_number }} <br>
                            โทร {{ $contract->phone }}
                        </td>
                        <td style="color: black;">
                                    @php
                                        $date = new DateTime(date('Y-m-d', strtotime($item_receipt->created_at)));
                                        $englishDay = $date->format('l');
                                        
                                    @endphp
                                        <span style="color: black; font-weight: 500;">วันที่รับชำระเงิน</span> &nbsp; &nbsp; &nbsp; {!! $days[$englishDay].' &nbsp;'.date('d/m/Y', strtotime($item_receipt->created_at)) !!}<br>
                                        <span style="color: black; font-weight: 500;">ช่องทางการชำระเงิน</span> &nbsp; &nbsp; &nbsp; {{ $item_receipt->payment_channel == 1 ? "เงินสด": "โอนเงิน"; }}<br>
                                        <span style="color: black; font-weight: 500;">รับชำระโดย</span> &nbsp; &nbsp; &nbsp; {{ $item_receipt->user->name }}<br>
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
                    @foreach ($item_receipt->payment_list as $item_payment_list)
                    <tr>
                        <td class="{{$item_payment_list->discount == 1 ? "text-danger fw-bold" : ""}}">
                            {{ $item_payment_list->title }}
                            @if($item_payment_list->unit > 0 && $key == 1)    
                                {{ number_format($item_payment_list->unit) }} = {{ $item_payment_list->unit - 0 }} ยูนิต)
                            @endif
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
            <div class="modal-footer rounded-0 justify-content-start mt-2 pb-0">
                <button type="button" class="btn btn-label-primary waves-effect" onclick="printPdf({{$item_receipt->id}})"><span
                        class="ti-sm ti ti-printer me-2"></span>พิมพ์ใบเสร็จรับเงิน</button>
            </div>
            {{--  --}}
            @if ($key+1 < count($receipt))
                <hr class="mb-4">
            @endif
            {{--  --}}
        </div>
        
    @endforeach   
<iframe id="print-iframe" style="display: none;"></iframe>                   
<script>
    function printPdf(id) {
        $.ajax({
            url: '/pdf/receipt/'+id,
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
            error: function(xhr) {
                alert('เกิดข้อผิดพลาด');
                console.error(xhr.responseText);
            }
        });
    }
</script>