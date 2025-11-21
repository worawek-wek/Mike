<div class="modal-header rounded-0">
    <span class="modal-title">
        <span class="h5" style="color: white;">
        {{ \Carbon\Carbon::parse($income_expenses->date)->locale('th')->translatedFormat('l, j F Y') }}
        </span>
    </span>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>
<div class="modal-body">
    <div class="col-sm-12">
        <table class="table table-bordered mt-3 mb-4">
            <thead>
                <tr>
                    <th width="75%">รายละเอียด</th>
                    <th class="text-end">{{ $income_expenses->label }}</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>ห้อง</td>
                    <td class="text-end">{{ $income_expenses->room->name ?? "รายจ่ายของ Office" }}</td>
                </tr>
                <tr>
                    <td>เวลา</td>
                    <td class="text-end">{{ date('H:i น.', strtotime($income_expenses->time)) }}</td>
                </tr>
                <tr>
                    <td>วันที่</td>
                    <td class="text-end">{{ date('d/m/Y', strtotime($income_expenses->date)) }}</td>
                </tr>
            </tbody>
            @if ($income_expenses->type == 2)
                <tbody>
                    <tr>
                        <td>หมวดหมู่</td>
                        <td class="text-end">{{ $income_expenses->category->name }}</td>
                    </tr>
                </tbody>
            @endif
            <tbody>
                <tr>
                    <td>จำนวนเงิน</td>
                    @if ($income_expenses->type == 1)
                        <td class="text-success text-end">{{ number_format($income_expenses->receipt->total_amount ?? $income_expenses->total_amount) }} บาท</td>
                    @else
                        <td class="text-danger text-end">- {{ $income_expenses->amount }} บาท</td>
                    @endif
                </tr>
            </tbody>
            <tbody>
                <tr>
                    <td>โดย</td>
                    <td class="text-end">{{ $income_expenses->user->name }}</td>
                </tr>
            </tbody>
        </table>
    </div>
    @if ($income_expenses->type == 1)
        <div class="mb-3" style="border: 1px solid #dbdade;padding: 15px 2px;">
            <div class="d-flex">
                <div class="flex-grow-1 ms-3">
                <b class="text-black">รายละเอียดหัวบิล</b> <br>
                    {{ $income_expenses->name.' '.$income_expenses->address.' '.$income_expenses->branch }} <br>
                    เลขประจำตัวผู้เสียภาษี {{ $income_expenses->id_card_number }} <br>
                    โทร {{ $income_expenses->phone }}
                </div>
            </div>
        </div>

        <table class="table table-bordered" id="discount-table">
            <thead>
                <tr>
                    <th>รายการ</th>
                    <th class="text-end">จำนวนเงิน (บาท)</th>
                </tr>
            </thead>
            <tbody>
                @if (@$income_expenses->receipt->payment_list)
                    @foreach ($income_expenses->receipt->payment_list as $key => $payment_list_item)
                        <tr>
                            {{-- <td>ค่าเช่าห้อง (Room rate) {{ $invoice->room_for_rent->room->name }} เดือน {{ $invoice->month.'/'.$invoice->year }}</td> --}}
                            <td class="{{$payment_list_item->discount == 1 ? "text-danger fw-bold" : ""}}" style="display: flex; align-items: center;">
                                {{ $payment_list_item->title }}
                            </td>
                            <td class="text-end {{$payment_list_item->discount == 1 ? "text-danger fw-bold" : ""}}">
                            {{-- @if ($key == 1)
                                <input type="hidden" class="calculate" name="water_amount" id="water_amount" value="{{ $payment_list_item->price }}">
                                    <span id="text_water_amount">
                                        - {{ number_format($payment_list_item->price) }}
                                    </span>
                            @else --}}
                                @if ($payment_list_item->discount == 1)
                                    {{ number_format(0-$payment_list_item->price) }}
                                    <input type="hidden" class="calculate" value="{{0-$payment_list_item->price}}">
                                @else
                                    {{ number_format($payment_list_item->price) }}
                                    <input type="hidden" class="calculate" value="{{$payment_list_item->price}}">
                                @endif
                            {{-- @endif --}}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>
                    <th>รวม</th>
                    <th class="text-end mb-0 fw-bold total-price">
                        {{ number_format($income_expenses->receipt->total_amount ?? $income_expenses->total_amount) }}
                    </th>
                </tr>
            </tfoot>
        </table>
    <label class="mt-4"><b>หมายเหตุ :</b> {{ $income_expenses->remark }}</label>
    @else
        <label for="exampleFormControlInput1" class="form-label h4">หลักฐานการจ่ายเงิน</label>
        <div class="col-sm-6 mb-3">
            <img src="/upload/expenses/{{ $income_expenses->proof_of_payment }}" width="100%">
        </div>
        <label for="exampleFormControlInput1" class="form-label h4">หลักฐานการจ่ายเงิน</label>
        <div class="col-sm-6">
            <img src="/upload/expenses/{{ $income_expenses->payment_voucher }}" width="100%">
        </div>
    @endif
</div>