<div class="modal-header rounded-0">
    <span class="modal-title">
        <span class="h5" style="color: white;">ห้อง {{ $room->name }}</span>
        <span class="ms-2">
            {{-- {{ date('m/Y', strtotime($invoice->month.' '.$invoice->year)) }} --}}
            @php
            $monthNames = [
                            '1' => 'มกราคม', '2' => 'กุมภาพันธ์', '3' => 'มีนาคม', '4' => 'เมษายน',
                            '5' => 'พฤษภาคม', '6' => 'มิถุนายน', '7' => 'กรกฎาคม', '8' => 'สิงหาคม',
                            '9' => 'กันยายน', '10' => 'ตุลาคม', '11' => 'พฤศจิกายน', '12' => 'ธันวาคม'
                        ];
            $type = [ 3 => "ค่าจองห้อง", 2 => "ค่าเงินประกันห้อง", 1 => "ค่าเช่ารายเดือน"]
            @endphp

        </span>
        {{-- <span class="ms-2" style="border: 1px solid #69c2c1;padding: 7px 12px;border-radius: 5px;font-size: smaller;">{{ $invoice->invoice_number }}</span> --}}
    </span>
    {{-- <span class="badge bg-label-{{ $invoice->status->color }} m-auto" text-capitalized="" style="font-size: unset;" >
        <span class="ti-md ti {{ $invoice->status->icon }} me-2"></span>{{ $invoice->status->name }}
    </span> --}}
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="mb-3" style="border: 1px solid #dbdade;padding: 15px 2px;">
        <div class="d-flex">
            <div class="flex-grow-1 ms-3">
            <b class="text-black">รายละเอียดหัวบิล</b> <br>
                {{ $invoice[0]->room_for_rent->renter->prefix.' '.$invoice[0]->room_for_rent->renter->name.' '.$invoice[0]->room_for_rent->renter->surname }} <br>
                เลขประจำตัวผู้เสียภาษี {{ $invoice[0]->room_for_rent->renter->id_card_number }} <br>
                โทร {{ $invoice[0]->room_for_rent->renter->phone }}
            </div>
        </div>
    </div>
    <b class="text-black">รายการค้างชำระ</b> <br>
    <table class="table table-bordered mt-3" id="discount-table">
        <thead>
            <tr class="table-warning">
                <th class="text-center" width="1px">ลำดับ</th>
                <th class="text-center">เดือน</th>
                <th class="text-center">เลขที่เอกสาร</th>
                <th class="text-center">ประเภท</th>
                <th class="text-center">ยอดเงิน</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice as $key => $row)
                <tr>
                    <td class="text-center">{{ $key+1 }}</td>
                    <td class="text-center">{{ $row->invoice_number }}</td>
                    <td class="text-center">{{ $monthNames[$row->month].' '.$row->year }}</td>
                    <td class="text-center">{{ $type[$row->ref_type_id] }}</td>
                    <td class="text-end">{{ number_format($row->total_amount) }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="table-danger">
                <th colspan="4" class="text-center">รวม</th>
                <th class="text-end mb-0 fw-bold total-price">
                    {{ number_format($invoice->sum->total_amount) }}
                </th>
            </tr>
        </tfoot>
    </table>
</div>

<div class="modal-footer d-flex justify-content-between rounded-0 mt-4">
    <button type="button" class="btn btn-label-primary waves-effect" onclick="printPdf({{ $room->id }})"><span
            class="ti-md ti ti-printer me-2"></span>พิมพ์ใบแจ้งหนี้</button>
{{-- @foreach ($invoice->receipt as $key => $item_receipt)
                        
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
                        @if($item_payment_list->unit > 0 && $key == 1)    
                            {{ number_format($item_payment_list->unit) }} = {{ $item_payment_list->unit - $meterPrevious->unit }} ยูนิต)
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
    <div class="modal-footer rounded-0 justify-content-start mt-2 pb-0">
        <button type="button" class="btn btn-label-primary waves-effect" onclick="printPdfReceipt({{$item_receipt->id}})"><span
                class="ti-sm ti ti-printer me-2"></span>พิมพ์ใบเสร็จรับเงิน</button>
    </div>
    @if ($key+1 < count($invoice->receipt))
        <hr class="mb-4">
    @endif
    @if ($invoice->ref_status_id == 5)
        <button class="btn btn-danger me-2" onclick="changeDeleteReceipt({{ $item_receipt->id }},{{$invoice->id}})">
            <span>
                <i class="ti-md ti ti-x"></i>
                ยกเลิกใบเสร็จ
            </span>
        </button>
    @endif
@endforeach --}}
</div>
