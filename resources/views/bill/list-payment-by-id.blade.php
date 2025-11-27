
    <table class="table table-bordered mb-4" id="discount-table2" >
        <thead>
            <tr>
                <th>รายการ</th>
                <th width="35%">จำนวนเงิน (บาท)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($list as $item_list)
                @foreach ($invoice[$item_list] as $key_2 => $payment_list)
                    <tr>
                        <td>
                            <input name="payment_list[title][]" type="text" class="form-control payment_list_title" value="{{ $payment_list->title }}" placeholder="หัวข้อรายการ" readonly>
                        </td>
                        <td class="text-end">
                            <input type="number" name="payment_list[price][]" class="form-control calculate_2" value="{{ $payment_list->price }}" placeholder="จำนวนเงิน" max="" oninput="calculate_2Price()" readonly>
                            <input type="hidden" name="payment_list[discount][]" value="0">
                            <input type="hidden" name="payment_list[id][]" value="{{ $payment_list->id }}">
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>
<script>
    // alert(789);
                    calculatePrice_2();
</script>