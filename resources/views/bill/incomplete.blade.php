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

<form id="incomplete_update">
    @csrf
    
    <input name="ref_room_id" type="hidden" value="{{ $contract->ref_room_id }}">
    <input name="ref_rent_bill_id" type="hidden" value="{{ $invoice->id }}">
    <input name="ref_contract_id" type="hidden" value="{{ $contract->id }}">
    <input name="ref_renter_id" type="hidden" value="{{ $contract->ref_renter_id }}">
    <input name="ref_type_id" type="hidden" value="1">
    <input name="amount" class="total-price" type="hidden">

    <input type="hidden" name="id" value="{{$invoice->id}}">
    <div class="modal-body pb-1">
        {{-- ////////////////////////////////////////////////// --}}
        
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
                    {{-- <li class="nav-item" role="presentation">
                      <button type="button" class="btn btn-outline-info nav-link" 
                        role="tab" data-bs-toggle="tab" data-bs-target="#navs-pills-top-contract" aria-controls="navs-pills-top-contract" aria-selected="false" tabindex="-1">
                        <span>
                          <i class="ti-md ti ti-report-money"></i>
                          <b class="dam">
                            คอนเฟิร์มบิล
                          </b>
                        </span>
                      </button>
                    </li> --}}
                </ul>
        </div>
        <div class="tab-content" style="box-shadow: unset;padding:0px">
            <div class="tab-pane fade active show mb-5" id="navs-pills-top-edit" role="tabpanel">
              
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
                                    <input name="water_unit" style="width: 18%;background-color: #d6f7fb;border-color: #00bad1;"
                                        type="number" class="form-control" id="water_unit" oninput="calculatePrice()" placeholder="จำนวนเงิน" value="{{ $payment_list_item->unit }}" required />
                                        = {{ $payment_list_item->unit-0 }} ยูนิต)
                                        
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

                        {{-- <tr>
                            <td style="display: flex; align-items: center;">ค่าน้ำ (Water rate) เดือน {{ $invoice->month.'/'.$invoice->year }} ( 0 - 
                                <input name="water_unit" style="width: 18%;background-color: #d6f7fb;border-color: #00bad1;" type="number" class="form-control" id="water_unit" oninput="calculatePrice()" placeholder="จำนวนเงิน" value="{{ $invoice->water_unit }}" required />
                                = {{ $invoice->water_unit-0 }} ยูนิต)
                            </td>
                            <td class="text-end">
                                <input type="hidden" class="calculate" name="water_amount" id="water_amount" value="{{ $invoice->water_amount }}">
                                <span id="text_water_amount">
                                    {{ $invoice->water_amount }}
                                </span>
                            </td>
                        </tr>
                        <tr>
                            <td>ค่าไฟฟ้า (Electrical rate) เดือน {{ $invoice->month.'/'.$invoice->year }} ( 7194 - {{ $invoice->electricity_unit }} = 98 ยูนิต)</td>
                            <td class="text-end">
                                {{ $invoice->electricity_amount }}
                            </td>
                        </tr> --}}
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>รวม</th>
                            <th class="text-end mb-0 fw-bold total-price">
                                {{ number_format($invoice->room_for_rent->room->rent + $invoice->water_amount+$invoice->electricity_amount) }}
                            </th>
                        </tr>
                    </tfoot>
                </table>
                
        {{-- ////////////////////////////////////////////////// --}}
        <div class="mt-4 text-end col-12">
            <button
                    id="add_discount"
                    style="padding-right: 14px;padding-left: 14px;"
                    class="btn btn-sm buttons-collection btn-label-danger waves-effect waves-light me-2"
                    tabindex="0" aria-controls="DataTables_Table_0"
                    type="button" aria-haspopup="dialog"
                    aria-expanded="false">
                <span>
                <i class="ti ti-plus"></i> เพิ่มส่วนลด</span>
            </button>
            <button
                    id="add_expenses"
                    style="padding-right: 14px;padding-left: 14px;"
                    class="btn btn-sm buttons-collection btn-label-warning waves-effect waves-light me-2"
                    tabindex="0" aria-controls="DataTables_Table_0"
                    type="button" aria-haspopup="dialog"
                    aria-expanded="false">
                <span>
                <i class="ti ti-plus"></i> เพิ่มรายการ</span>
            </button>
        </div>
        
        <div class="col-sm-11 mt-3">
            <label>หมายเหตุ</label>
            <input type="text" class="form-control" placeholder="หมายเหตุ" />
        </div>
          </div>
        </div>
        
    </div>

    <div class="modal-footer rounded-0 justify-content-start">
        {{-- <button type="button" class="btn btn-primary waves-effect"><span
                class="ti-md ti ti-printer me-2"></span>พิมพ์ใบแจ้งหนี้</button> --}}
        <button type="submit" class="btn btn-info waves-effect">
            <span class="fas fa-paper-plane me-2" style="font-size: x-large;"></span>คอนเฟิร์มบิล</button>
    </div>
</form>
<script>
    
        $('#transfer_date').datepicker({
            format: 'dd/mm/yyyy', // กำหนดรูปแบบของวันที่
            todayBtn: "linked",   // เพิ่มปุ่มวันนี้
            clearBtn: true,       // เพิ่มปุ่มล้างข้อมูล
            autoclose: true       // เมื่อเลือกวันที่แล้วจะปิดปฏิทิน
        })
        $('#transfer_date2').datepicker({
            format: 'dd/mm/yyyy', // กำหนดรูปแบบของวันที่
            todayBtn: "linked",   // เพิ่มปุ่มวันนี้
            clearBtn: true,       // เพิ่มปุ่มล้างข้อมูล
            autoclose: true       // เมื่อเลือกวันที่แล้วจะปิดปฏิทิน
        })
        calculatePrice();
        document.getElementById('add_discount').addEventListener('click', function() {
            const tableBody = document.querySelector('#discount-table tbody');
            const newRow = document.createElement('tr');
            newRow.style.backgroundColor = 'rgb(252 228 228)'; // Set background color
            
            newRow.innerHTML = `
                <td>
                    <input name="payment_sd_list[title][]" type="text" class="form-control" placeholder="หัวข้อส่วนลด" required />
                </td>
                <td class="text-end">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <input name="payment_sd_list[price][]" type="number" class="form-control calculate discount_price" oninput="calculatePrice()" placeholder="จำนวนเงิน" required style="flex: 1;" autocomplete=off/>
                        <input type="hidden" name="payment_sd_list[discount][]" value='1'>
                        <button type="button" class="btn btn-danger btn-sm remove-row">ลบ</button>
                    </div>
                </td>
            `;
            
            tableBody.appendChild(newRow);
            addRemoveEvent(newRow);
        });

        document.getElementById('add_expenses').addEventListener('click', function() {
            const tableBody = document.querySelector('#discount-table tbody');
            const newRow = document.createElement('tr');
            newRow.style.backgroundColor = 'rgb(255 240 225)'; // Set background color
            
            newRow.innerHTML = `
                <td>
                    <input name="payment_sd_list[title][]" type="text" class="form-control" placeholder="หัวข้อรายการ" required />
                </td>
                <td class="text-end">
                    <div style="display: flex; align-items: center; gap: 10px;">
                        <input name="payment_sd_list[price][]" type="number" class="form-control calculate add_expenses_price" oninput="calculatePrice()" placeholder="จำนวนเงิน" required style="flex: 1;" autocomplete=off/>
                        <input type="hidden" name="payment_sd_list[discount][]" value='0'>
                        <button type="button" class="btn btn-danger btn-sm remove-row">ลบ</button>
                    </div>
                </td>
            `;
            
            tableBody.appendChild(newRow);
            addRemoveEvent(newRow);
        });

        function addRemoveEvent(row) {
            row.querySelector('.remove-row').addEventListener('click', function() {
                row.remove();
                calculatePrice();
            });
        }


        
        function paymentChannel(i) {
            $('#payment_channel').val(i);
        }
        function calculatePrice() { 
            var water_amount = ($('#water_unit').val()-0)*18
            $('#text_water_amount').html(water_amount.toLocaleString());
            $('#water_amount').val(water_amount);
            const inputs = document.querySelectorAll('.calculate');  // เลือกทุก input ที่มี class="calculate"
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
            $('.total-price').html(total.toLocaleString());

            // อัปเดตค่า total ใน span#total-price
            // document.getElementById('total-price').innerText = total.toLocaleString();
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
            $('.total-price_2').html(total.toLocaleString());

            // อัปเดตค่า total ใน span#total-price
            // document.getElementById('total-price').innerText = total.toLocaleString();
        }
        
        $('#incomplete_update').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ คอนเฟิร์มบิล หรือไม่?',
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
                        url: '{{ $page_url }}/incomplete_update', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: $(this).serialize(),
                        success: function(response) {
                            if(response == true){
                                $('#invoice').modal('hide');
                                summary();
                                loadData(page);
                                Swal.fire('บันทึกเรียบร้อยแล้ว', '', 'success');
                            }
                        },
                        error: function(error) {
                            Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                            console.error('เกิดข้อผิดพลาด:', error);
                        }
                    });
                } else if (result.isDismissed) {
                    // Swal.fire('ยกเลิกการดำเนินการ', '', 'info');
                }
            });
        });
</script>