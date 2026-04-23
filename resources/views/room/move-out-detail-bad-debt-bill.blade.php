    @php
        $permission_bill_move_edit = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 32)->where('status', 0)->first();
    @endphp
<style>
    .table-detail-receipt th,
    .table-detail-receipt td {
        border: 1px solid #d9d9d9 !important;
    }
</style>
    <div class="my-3" style="border: 1px solid #dbdade;padding: 15px 2px;">
        <div class="d-flex">
            <div class="flex-grow-1 ms-3">
            <b class="text-black">รายละเอียดหัวบิล</b> <br>
                {{ $invoice->name }} <br>
                เลขประจำตัวผู้เสียภาษี {{ $invoice->id_card_number }} <br>
                โทร {{ $invoice->phone }}
            </div>
        </div>
    </div>
    <table class="table table-detail-receipt">
        <thead>
            <tr>
                <th>รายการ</th>
                <th width="20%">จำนวนเงิน (บาท)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($invoice->payment_list as $key => $payment_list_item)
                <tr>
                    <td>
                        {{ $payment_list_item->title }}
                    </td>
                    <td class="text-end {{$payment_list_item->discount == 1 ? "text-danger fw-bold" : ""}}">
                        @if ($payment_list_item->discount == 1)
                            {{ number_format(0-$payment_list_item->price) }}
                        @else
                            {{ number_format($payment_list_item->price) }}
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
    
    <div class="mt-4 col-12 d-flex justify-content-end gap-2"
            @if($permission_bill_move_edit)
                style="pointer-events: none;  /* ปิดคลิก */
                        opacity: 0.6;          /* ให้ดูจางลง */
                        cursor: not-allowed;   /* เปลี่ยนเมาส์เป็นรูปห้าม */"
            @endif>
        <button
            @if (@$receipt) disabled @endif
            style="padding-right: 14px;padding-left: 14px;"
            class="btn buttons-collection btn-warning waves-effect waves-light"
            type="button"
            onClick="editFormBadDebtBillt()"
        >
            <i class="fa fa-pencil me-1"></i> แก้ไขใบเสร็จ
        </button>
    </div>
    <div class="col-12">
        <h2 class="text-danger text-center">รายการหนี้สูญ " {{ number_format($invoice->total_amount) }} บาท "</h2>
    </div>
    
    
    </form>
    <script>
        setTimeout(() => {
            calculateTotal()
        }, 2000);

        $('#payment_receipt_move_out_bill').on('submit', function(event) { // บันทึกบิลย้ายออก ใบเสร็จย้ายออก function save_moveout_receipt()
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ ชำระเงิน ใบเสร็จย้ายออก หรือไม่?',
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
                    $.ajax({
                        url: '/room/payment-receipt-move-out-bill',
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response == true){
                                get_move_out();
                                calculateTotal()
                                calculate_2Price()
                                loadData(page);
                                summary();
                                Swal.fire('ชำระเงินใบเสร็จย้ายออกเรียบร้อยแล้ว', '', 'success');
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
        
        function changeDeleteReceipt(receipt_id, invoice_id){
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ ยกเลิก ใบเสร็จ หรือไม่?',
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
                    $.ajax({
                        type: "POST",
                        url: "bill/delete-receipt/"+receipt_id,
                        data: {
                            _token: "{{ csrf_token() }}",
                        },
                        success: function(response) {
                            if(response == true){
                                Swal.fire('ยกเลิก ใบเสร็จ เรียบร้อยแล้ว', '', 'success');
                                get_move_out();
                                calculateTotal()
                                calculate_2Price()
                                loadData(page);
                                summary();
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
        }
    setTimeout(() => {
        var deposit_amount = $('#deposit_amount').val();
        var bad_debt = {{ $invoice->total_amount }};
        
        var total = deposit_amount-bad_debt;
        console.log(deposit_amount);
        console.log(bad_debt);
        console.log(total);
        
        const formatted = total.toLocaleString('th-TH', { minimumFractionDigits: 2 });
        const amountText = document.querySelector('.amount');
            // เปลี่ยนสีตามค่าบวกหรือลบ
            if (total < 0) {
                total = total*(-1);
                const formatted = total.toLocaleString('th-TH', { minimumFractionDigits: 2 });
                amountText.style.color = 'red';
                amountText.textContent = `หนี้สูญ ${formatted} บาท`;
            } else if (total > 0) {
                amountText.style.color = '#28c76f';
                amountText.textContent = `หอพักได้รับเงินประกัน ${formatted} บาท`;
            } else {
                amountText.style.color = ''; // default
            }
        }, 2000);

    </script>