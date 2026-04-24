    <table class="table table-bordered mb-4" id="discount-table2" >
        <thead>
            <tr>
                <th>รายการ</th>
                <th width="35%">จำนวนเงิน (บาท)</th>
            </tr>
        </thead>
        <tbody>
            @if ($list[0] == "installment_payment") {{-- ถ้าติ๊ก แบ่งจ่าย --}}
                <tr>
                    <td>
                            <input
                            name="payment_list[title][]"
                            type="text"
                            class="form-control payment_list_title"
                            value="แบ่งจ่ายค่าห้อง {{ $invoice->room->name }}" placeholder="หัวข้อรายการ">
                    </td>
                    <td class="text-end">
                        <input type="number" name="payment_list[price][]" class="form-control calculate_1_room" value="0" placeholder="จำนวนเงิน" max="" oninput="calculate_1_room_price()">
                        <input type="hidden" name="payment_list[discount][]" value="0">
                        {{-- <input type="hidden" name="payment_list[id][]" value="installment_payment"> --}}

                    </td>
                </tr>
            @else
            {{-- แสดงรายการตามที่ติ๊ก --}}
                @foreach ($list as $item_list)
                    @foreach ($invoice[$item_list] as $key_2 => $payment_list)
                        @continue($payment_list->discount == 1)
                        <tr>
                            <td>
                                    <input
                                    name="payment_list[title][]"
                                    type="text"
                                    class="form-control payment_list_title"
                                    value="{{ $payment_list->title }}@if (strpos($payment_list->title, 'Water rate') !== false){{(int)$payment_list->unit}}&nbsp; - &nbsp;{{ $invoice->previous_water_unit ?? 0 }} = &nbsp;{{ $payment_list->unit-$invoice->previous_water_unit }}&nbsp; ยูนิต)@endif" placeholder="หัวข้อรายการ" readonly>
                            </td>
                            <td class="text-end">
                                <input type="number" name="payment_list[price][]" class="form-control calculate_1_room" value="{{ $payment_list->price }}" placeholder="จำนวนเงิน" max="" oninput="calculate_1_room_price()" readonly>
                                <input type="hidden" name="payment_list[discount][]" value="0">
                                <input type="hidden" name="payment_list[id][]" value="{{ $payment_list->id }}">
                            </td>
                        </tr>
                    @endforeach
                @endforeach
            {{-- แสดงรายการตามที่ติ๊ก --}}
            {{-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------}}
                {{-- แสดงรายการส่วนลดของ ใบแจ้งหนี้ "rent_bills" --}}
                @foreach ($invoice['payment_discount_array'] as $key_2 => $payment_discount)
                    <tr style="background-color: rgb(252, 228, 228);">
                        <td>
                            <input name="payment_list[title][]" type="text" class="form-control payment_list_title" value="{{ $payment_discount->title }}" placeholder="หัวข้อรายการ" readonly>
                        </td>
                        <td class="text-end">
                            <input type="number" name="payment_list[price][]" class="form-control calculate_1_room discount_price" value="{{ $payment_discount->price }}" placeholder="จำนวนเงิน" max="" oninput="calculate_1_room_price()" readonly>
                            <input type="hidden" name="payment_list[discount][]" value="1">
                            <input type="hidden" name="payment_list[id][]" value="{{ $payment_discount->id }}">
                        </td>
                    </tr>
                @endforeach
                {{-- แสดงรายการส่วนลดของ ใบแจ้งหนี้ "rent_bills" --}}
            {{-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------}}
                {{-- แสดงยอดแบ่งจ่าย ที่ยังไม่ได้เอามาเป็นส่วนลด" --}}
                @if ($total_installment_payment_price > 0)
                    <tr style="background-color: rgb(252, 228, 228);">
                        <td>
                            <input name="payment_list[title][]" type="text" class="form-control payment_list_title" value="หักจากยอดแบ่งจ่าย" placeholder="หัวข้อรายการ" readonly>
                        </td>
                        <td class="text-end">
                            <input type="number" name="payment_list[price][]" class="form-control calculate_1_room discount_price" value="{{ $total_installment_payment_price }}" placeholder="จำนวนเงิน" max="" oninput="calculate_1_room_price()" readonly>
                            <input type="hidden" name="payment_list[discount][]" value="1">
                            <input type="hidden" name="payment_list[id][]" value="installment_payment">
                        </td>
                    </tr>
                @endif
                {{-- แสดงยอดแบ่งจ่าย ที่ยังไม่ได้เอามาเป็นส่วนลด" --}}
            @endif
        </tbody>
    </table>
<script>
    // alert(789);
                    calculatePrice_2();
</script>