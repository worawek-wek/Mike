<div class="modal-header rounded-0">
    <span class="modal-title">
        <span class="h5" style="color: white;">ห้อง {{ $invoice->room_for_rent->room->name }}</span>
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
<div class="modal-body">
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

                        {{ $payment_list_item->title }}

                    @if ($key == 1)
                        {{ number_format($payment_list_item->unit) }} = {{ $payment_list_item->unit-0 }} ยูนิต)
                            
                    @endif
                    </td>
                    <td class="text-end {{$payment_list_item->discount == 1 ? "text-danger fw-bold" : ""}}">
                    @if ($key == 1)
                        <input type="hidden" class="calculate" name="water_amount" id="water_amount" value="{{ $payment_list_item->price }}">
                            <span id="text_water_amount">
                                {{ $payment_list_item->price }}
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
</div>

<div class="modal-footer rounded-0 justify-content-start">
    <button type="button" class="btn btn-label-primary waves-effect" onclick="printPdf({{ $invoice->id }})"><span
            class="ti-md ti ti-printer me-2"></span>พิมพ์ใบแจ้งหนี้</button>
            
    {{-- <button type="button" class="btn btn-label-secondary waves-effect"><span
        class="ti-md ti ti-pencil"></span></button> --}}
    @if ($invoice->ref_status_id == 1)
        <button type="button" class="btn btn-label-{{ $invoice->status->color }} waves-effect ms-auto" onclick="changeStatusBill({{ $invoice->id }},7,'คอนเฟิร์มบิล')">
            <span class="ti-md ti {{ $invoice->status->icon }} me-2"></span>คอนเฟิร์มบิล
        </button>
    @elseif($invoice->ref_status_id == 2)
        {{-- <button type="button" class="btn btn-label-{{ $invoice->status->color }} waves-effect ms-auto" onclick="changeStatusBill({{ $invoice->id }},5,'ชำระเงิน')">
            <span class="ti-md ti ti-report-money me-2"></span>ชำระเงิน
        </button> --}}
    @endif
</div>