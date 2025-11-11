@php
    $permission_bill_edit = \App\Models\PermissionGroupHasUserBranch::where('ref_user_id', Auth::id())->where('ref_branch_id', session('branch_id'))->where('ref_permission_id', 32)->where('status', 0)->first();
@endphp
            @csrf
            <input type="hidden" name="invoice_id" value="{{ @$invoice->id }}">
            <input name="ref_room_for_rent_id" type="hidden" value="{{ $invoice->ref_room_for_rent_id ?? $room->room_for_rent_main->id }}">
            <input name="ref_room_id" type="hidden" value="{{ $invoice->ref_room_id ?? $room->id }}">
            <input name="ref_contract_id" type="hidden" value="{{ $invoice->ref_contract_id ?? $room->contract->id }}">
            <div class="row g-2 pt-1"
            @if($permission_bill_edit)
                style="pointer-events: none;  /* ปิดคลิก */
                        opacity: 0.6;          /* ให้ดูจางลง */
                        cursor: not-allowed;   /* เปลี่ยนเมาส์เป็นรูปห้าม */"
            @endif>
                <div class="p-2">
                    <label class="mb-1 text-black"><i class="ti ti-license text-main mb-1"></i> รายละเอียดหัวบิล</label>
                        <select name="ref_renter_id" id="select-renter2" class="select-renter" onchange="get_room_rental_bad_debt(this.value)" required>
                            <option selected disabled hidden value="no">เลือกข้อมูลจากผู้เช่า</option>
                            @foreach ($renter as $rent)
                                <option value="{{ $rent->id }}" @if (@$invoice->ref_room_for_rent_id == $rent->room_for_rents_id) selected @endif >{{ $rent->prefix.' '.$rent->name.' '.$rent->surname }}</option>
                            @endforeach
                        </select>
                </div>
                <div class="col-sm-12">
                    <label for="renter_name" class="form-label">ชื่อผู้เข้าพัก</label>
                    <input type="text" name="name" class="form-control" id="renter_bad_name" placeholder="ชื่อผู้เข้าพัก" value="{{ @$invoice->name }}" />
                </div>
                <div class="col-sm-12">
                    <label for="renter_address" class="form-label">ที่อยู่ผู้เข้าพัก</label>
                    <input type="text" name="homeland" class="form-control" id="renter_bad_address" placeholder="ที่อยู่ผู้เข้าพัก" value="{{ @$invoice->address }}" />
                </div>
                <div class="col-sm-12">
                    <label for="renter_phone" class="form-label">เบอร์โทรผู้เข้าพัก</label>
                    <input type="text" name="phone" class="form-control" id="renter_bad_phone" placeholder="เบอร์โทรผู้เข้าพัก" value="{{ @$invoice->phone }}" />
                </div>
                <div class="col-sm-12">
                    <label for="renter_id_card_number" class="form-label">หมายเลขบัตรประชาชนผู้เข้าพัก</label>
                    <input type="text" name="id_card_number" class="form-control" id="renter_bad_id_card_number" placeholder="หมายเลขบัตรประชาชนผู้เข้าพัก" value="{{ @$invoice->id_card_number }}" />
                </div>
                <div class="col-sm-12">
                    <label for="renter_remark" class="form-label">หมายเหตุ</label>
                    <textarea name="remark" class="form-control" id="renter_bad_remark" placeholder="หมายเหตุ">{{ @$invoice->remark }}</textarea>
                </div>
            </div>
            <label class="mt-4 text-black" style="font-weight: 500;font-size: large;" for="">
                รายการชำระเงิน
            </label>
            <table class="table table-bordered mt-2 table-detail" id="discount-table2"
            @if($permission_bill_edit)
                style="pointer-events: none;  /* ปิดคลิก */
                        opacity: 0.6;          /* ให้ดูจางลง */
                        cursor: not-allowed;   /* เปลี่ยนเมาส์เป็นรูปห้าม */"
            @endif>
                <thead>
                    <tr>
                        <th>รายการ</th>
                        <th width="35%">จำนวนเงิน (บาท)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($invoice?->payment_list ?? [] as $key => $payment_list_item_4)
                        <tr {{ $payment_list_item_4->discount == 1 ? "class=bg-lob" : "" ; }}>
                            <td>
                                <input name="payment_list[title][]" type="text" class="form-control payment_list_title" placeholder="หัวข้อรายการ" value="{{ $payment_list_item_4->title }}" required>
                            </td>
                            <td class="text-end gap-1">
                                <div class="d-flex">
                                    <input type="number" name="payment_list[price][]" class="form-control me-2 {{ $payment_list_item_4->discount == 1 ? "form-price_increase" : "form-discount-value" ; }} calculate_2" value="{{ $payment_list_item_4->price }}" placeholder="จำนวนเงิน" max="" oninput="calculate_2Price()" required>
                                    <input type="hidden" name="payment_list[discount][]" value="{{ $payment_list_item_4->discount }}">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove-row">ลบ</button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td>
                                <input name="payment_list[title][]" type="text" class="form-control payment_list_title" placeholder="หัวข้อรายการ" @if(@$invoice_rent_room) value="ค่าเช่าห้อง {{ $room->name .' เดือน '.$invoice_rent_room->month.'/'.$invoice_rent_room->year }}" @endif required>
                            </td>
                            <td class="text-end">
                                <input type="number" name="payment_list[price][]" class="form-control form-discount-value calculate_2" @if(@$invoice_rent_room) value="{{ $invoice_rent_room->total_amount }}" @endif placeholder="จำนวนเงิน" max="" oninput="calculate_2Price()" required>
                                <input type="hidden" name="payment_list[discount][]" value="0">
                                <input type="hidden" name="payment_list[bad_debt_rent_status][]" value="1">
                            </td>
                        </tr>

                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <th>รวม</th>
                        <th class="text-end mb-0 fw-bold total-price_2" id="amount_receipt_move_out">
                            0
                        </th>
                    </tr>
                </tfoot>
            </table>
        <div class="mt-4 text-end col-12"
        @if($permission_bill_edit)
                style="pointer-events: none;  /* ปิดคลิก */
                        opacity: 0.6;          /* ให้ดูจางลง */
                        cursor: not-allowed;   /* เปลี่ยนเมาส์เป็นรูปห้าม */"
            @endif>
            
            <button
                    id="add_meter"
                    style="padding-right: 14px;padding-left: 14px;"
                    class="btn btn-sm buttons-collection btn-info waves-effect waves-light me-2"
                    tabindex="0" aria-controls="DataTables_Table_0"
                    type="button" aria-haspopup="dialog"
                    aria-expanded="false"
                    onclick="editMeter()"
                    >
                <span>
                <i class="ti ti-plus"></i> ค่าน้ำ-ค่าไฟฟ้าสุดท้าย</span>
            </button>
            <button
                    id="add_discount"
                    style="padding-right: 14px;padding-left: 14px;"
                    class="btn btn-sm buttons-collection btn-danger waves-effect waves-light me-2"
                    tabindex="0" aria-controls="DataTables_Table_0"
                    type="button" aria-haspopup="dialog"
                    aria-expanded="false">
                <span>
                <i class="ti ti-plus"></i> เพิ่มส่วนลด</span>
            </button>
            <button
                    id="bad_debt_add_expenses"
                    style="padding-right: 14px;padding-left: 14px;"
                    class="btn btn-sm buttons-collection btn-warning waves-effect waves-light me-2"
                    tabindex="0" aria-controls="DataTables_Table_0"
                    type="button" aria-haspopup="dialog"
                    aria-expanded="false">
                <span>
                <i class="ti ti-plus"></i> เพิ่มรายการ</span>
            </button>
            <button 
                    style="padding-right: 14px;padding-left: 14px;"
                    class="btn buttons-collection btn-success waves-effect waves-light me-2"
                    tabindex="0" aria-controls="DataTables_Table_0"
                    type="submit" aria-haspopup="dialog"
                    aria-expanded="false">
                <span>
                <i class="fa fa-save me-1 fa-lg my-2"></i> บันทึกใบเสร็จ</span>
            </button>
        </div>
            <style>
                .bg-lob {
                    background-color: rgb(252 228 228);   
                }
            </style>
            <script>

                function addRow(title = '', price = '', isDiscount = 0) {
                    // alert(isDiscount);
                    const discountClass = isDiscount ? 'form-price_increase' : 'form-discount-value';
                    const trBackground = isDiscount ? 'bg-lob' : '';

                    const html = `
                        <tr class="${trBackground}">
                            <td>
                                <input name="payment_list[title][]" type="text" class="form-control payment_list_title" placeholder="หัวข้อรายการ" value="${title}" required>
                            </td>
                            <td class="text-end gap-1">
                                <div class="d-flex">
                                    <input type="number" name="payment_list[price][]" class="form-control calculate_2 me-2 ${discountClass}" value="${price}" placeholder="จำนวนเงิน" oninput="calculate_2Price()" required>
                                    <input type="hidden" name="payment_list[discount][]" value="${isDiscount}">
                                    <button type="button" class="btn btn-sm btn-danger btn-remove-row">ลบ</button>
                                </div>
                            </td>
                        </tr>`;
                    $('#discount-table2 tbody').append(html);
                    calculate_2Price();
                }

                // กดเพิ่มส่วนลด
                $('#add_discount').click(() => addRow('ส่วนลด', '', 1));

                // กดเพิ่มรายการปกติ
                $('#bad_debt_add_expenses').click(() => addRow('', '', 0));

                // กดเพิ่มรายการค่าน้ำค่าไฟฟ้าสุดท้าย
                function addWaterElectric() {
                    // ดึงค่ามิเตอร์น้ำ
                    const waterOld = parseFloat(document.querySelector('.water-old')?.value) || 0;
                    const waterNew = parseFloat(document.querySelector('.water-new')?.value) || 0;
                    const waterUsed = Math.max(waterNew - waterOld, 0);
                    const waterPricePerUnit = 20; // ใส่ราคาต่อหน่วยจริง
                    const waterPrice = waterUsed * waterPricePerUnit;

                    // ดึงค่ามิเตอร์ไฟฟ้า
                    const electricOld = parseFloat(document.querySelector('.electric-old')?.value) || 0;
                    const electricNew = parseFloat(document.querySelector('.electric-new')?.value) || 0;
                    const electricUsed = Math.max(electricNew - electricOld, 0);
                    const electricPricePerUnit = 5; // ใส่ราคาต่อหน่วยจริง
                    const electricPrice = electricUsed * electricPricePerUnit;

                    var modalEl = document.getElementById('move-out-edit-meter');
                    var modalInstance = bootstrap.Modal.getInstance(modalEl); // <-- ดึง instance ที่เปิดอยู่
                    if (modalInstance) {
                        modalInstance.hide(); // <-- ซ่อน modal ที่เปิดอยู่จริง
                    }
                    // เพิ่มรายการลงในตาราง
                    if (waterUsed > 0) {
                        addRow(`ค่าน้ำ (${waterNew} - ${waterOld} = ${waterUsed} ยูนิต)`, waterPrice.toFixed(2), 0);
                    }
                    if (electricUsed > 0) {
                        addRow(`ค่าไฟฟ้า (${electricNew} - ${electricOld} = ${electricUsed} ยูนิต)`, electricPrice.toFixed(2), 0);
                    }
                }

                // ลบแถวรายการ
                $(document).on('click', '.btn-remove-row', function () {
                    $(this).closest('tr').remove();
                    calculate_2Price();
                });

                // คำนวณราคาเมื่อพิมพ์ค่า
                $(document).on('input', '.calculate_2', function () {
                    calculate_2Price();
                });

                // เรียกคำนวณตอนโหลดหน้า
                $(document).ready(function () {
                    calculate_2Price();
                    
                    new TomSelect("#select-renter2", {
                        create: false,      // ไม่ให้พิมพ์เพิ่มเอง
                        maxItems: 1,        // จำกัดให้เลือกได้ 1 ค่า
                        allowEmptyOption: true, // แสดง option แรกที่ไม่มีค่า (เช่น "-- กรุณาเลือก --")
                        sortField: {
                            field: "text",
                            direction: "asc"
                        }
                    });

                });
            </script>