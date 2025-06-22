<div class="modal-header rounded-0">
    <span class="modal-title">
        <span class="h5" style="color: white;">ห้อง {{ $invoice->room_for_rent->room->name }}</span>
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
    <div class="mb-3" style="border: 1px solid #dbdade;padding: 15px 2px;">
        <div class="d-flex">
            <div class="flex-grow-1 ms-3">
            <b class="text-black">บิลเลขที่</b> <br>
                INV202410000010
            </div>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>รายการ</th>
                <th>จำนวนเงิน (บาท)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ค่าเช่าห้อง (Room rate) {{ $invoice->room_for_rent->room->name }} เดือน {{ '09/'.$invoice->year }}</td>
                <td>{{ number_format($invoice->room_for_rent->room->rent) }}</td>
            </tr>
            <tr>
                <td>ค่าน้ำ (Water rate) เดือน {{ '09/'.$invoice->year }} ( 911 - {{ $invoice->water_unit }} = 3 ยูนิต)</td>
                <td>{{ $invoice->water_amount }}</td>
            </tr>
            <tr>
                <td>ค่าไฟฟ้า (Electrical rate) เดือน {{ '09/'.$invoice->year }} ( 7194 - {{ $invoice->electricity_unit }} = 98 ยูนิต)</td>
                <td>{{ $invoice->electricity_amount }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>รวม</th>
                <th class=" mb-0 fw-bold">
                    {{ number_format($invoice->room_for_rent->room->rent + $invoice->water_amount+$invoice->electricity_amount) }}
                </th>
            </tr>
        </tfoot>
    </table>
    <hr class="my-4">
    <div class="mb-3" style="border: 1px solid #dbdade;padding: 15px 2px;">
        <div class="d-flex">
            <div class="flex-grow-1 ms-3">
            <b class="text-black">บิลเลขที่</b> <br>
                {{ $invoice->invoice_number }}
            </div>
        </div>
    </div>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>รายการ</th>
                <th>จำนวนเงิน (บาท)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>ค่าเช่าห้อง (Room rate) {{ $invoice->room_for_rent->room->name }} เดือน {{ $invoice->month.'/'.$invoice->year }}</td>
                <td>{{ number_format($invoice->room_for_rent->room->rent) }}</td>
            </tr>
            <tr>
                <td>ค่าน้ำ (Water rate) เดือน {{ $invoice->month.'/'.$invoice->year }} ( 911 - {{ $invoice->water_unit }} = 3 ยูนิต)</td>
                <td>{{ $invoice->water_amount }}</td>
            </tr>
            <tr>
                <td>ค่าไฟฟ้า (Electrical rate) เดือน {{ $invoice->month.'/'.$invoice->year }} ( 7194 - {{ $invoice->electricity_unit }} = 98 ยูนิต)</td>
                <td>{{ $invoice->electricity_amount }}</td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <th>รวม</th>
                <th class=" mb-0 fw-bold">
                    {{ number_format($invoice->room_for_rent->room->rent + $invoice->water_amount+$invoice->electricity_amount) }}
                </th>
            </tr>
        </tfoot>
    </table>
</div>