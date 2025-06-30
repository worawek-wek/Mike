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

<form id="payment_bill" enctype="multipart/form-data">
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
        <div class="tab-content" style="box-shadow: unset;padding:0px">
              {{-- <form id="insert_one_contract"> --}}
                    {{-- ////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////// --}}
                    {{-- <br><span class="text-truncate text-success">จ่ายแล้ว 1,000</span>
                    <br><span class="text-truncate text-danger">ค้างจ่าย 3,365</span> --}}
                    {{-- ////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////// --}}
                    {{-- ////////////////////////////////////////////////// --}}
                </h4>
                <div class="mb-3 pb-4" style="border: 1px solid #dbdade;padding: 15px 2px;">
                    <div class="d-flex">
                        <div class="flex-grow-1 ms-3 g-3 row">
                            <b class="text-black">รูปแบบการชำระเงิน</b> <br>
                                    <div class="col-sm-11">
                                        <input name="payment_format" class="form-check-input" type="radio" id="payfull" value="1" 
                                        @if (count($invoice->receipt) == 0)
                                        checked    
                                        @else
                                        disabled
                                        @endif
                                        >
                                        <label class="form-check-label" for="payfull"> จ่ายเต็มจำนวน </label>
                                    </div>
                                    <div class="col-sm-11">
                                        <input name="payment_format" class="form-check-input" type="radio" id="checksplit" value="2"
                                        @if (count($invoice->receipt) > 0)
                                        checked    
                                        @endif
                                        > 
                                        <label class="form-check-label" for="checksplit"> แบ่งจ่าย </label>
                                    </div>
                        
                                    <div class="col-sm-11" id="divsplit" 
                                        @if (count($invoice->receipt) == 0)
                                            style="display: none;"
                                        @endif
                                    >
                                        
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
                                        <table class="table table-bordered" id="discount-table2" >
                                            <thead>
                                                <tr>
                                                    <th>รายการ</th>
                                                    <th width="35%">จำนวนเงิน (บาท)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>
                                                        <input name="payment_list[title][]" type="text" class="form-control payment_list_title" value="แบ่งจ่ายค่าห้อง {{ $invoice->room_for_rent->room->name }}" placeholder="หัวข้อรายการ">
                                                    </td>
                                                    <td class="text-end">
                                                        <input type="number" name="payment_list[price][]" class="form-control calculate_2" value="" placeholder="จำนวนเงิน" max="" oninput="calculate_2Price()">
                                                    </td>
                                                </tr>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <th>รวม</th>
                                                    <th class="text-end mb-0 fw-bold total-price_2">
                                                        0
                                                    </th>
                                                </tr>
                                            </tfoot>
                                        </table>
                                        
                                        <div align="right">
                                            <button
                                                    id="add_expenses2"
                                                    style="padding-right: 14px;padding-left: 14px;"
                                                    class="btn btn-sm buttons-collection btn-label-warning waves-effect waves-light me-2 mt-2"
                                                    tabindex="0" aria-controls="DataTables_Table_0"
                                                    type="button" aria-haspopup="dialog"
                                                    aria-expanded="false">
                                                <span>
                                                <i class="ti ti-plus"></i> เพิ่มรายการ</span>
                                            </button>
                                        </div>
                                        <div class="col-sm-11 mt-3 mb-3">
                                            <label>หมายเหตุ</label>
                                            <input name="remark" type="text" class="form-control" placeholder="หมายเหตุ" />
                                        </div>
                                        
                                        <script>
                                            
                                        document.getElementById('add_expenses2').addEventListener('click', function() {
                                            const tableBody = document.querySelector('#discount-table2 tbody');
                                            const newRow = document.createElement('tr');
                                            newRow.style.backgroundColor = 'rgb(255 240 225)'; // Set background color
                                            newRow.innerHTML = `
                                                <td>
                                                    <input name="payment_list[title][]" type="text" class="form-control payment_list_title" placeholder="หัวข้อรายการ" required />
                                                </td>
                                                <td class="text-end">
                                                    <div style="display: flex; align-items: center; gap: 10px;">
                                                        <input name="payment_list[price][]" type="number" class="form-control calculate_2 add_expenses2_price" oninput="calculate_2Price()" placeholder="จำนวนเงิน" required style="flex: 1;" autocomplete=off />
                                                        <button type="button" class="btn btn-danger btn-sm remove-row2">ลบ</button>
                                                    </div>
                                                </td>
                                            `;
                                            
                                            tableBody.appendChild(newRow);
                                            addRemoveEvent_2(newRow);
                                        });
                                    
                                        function addRemoveEvent_2(row) {
                                            row.querySelector('.remove-row2').addEventListener('click', function() {
                                                row.remove();
                                                calculate_2Price();
                                            });
                                        }

                                        function calculate_2Price() { 
                                            const inputs = document.querySelectorAll('.calculate_2');  // เลือกทุก input ที่มี class="calculate"
                                            let total = 0;

                                            inputs.forEach(input => {
                                                // ลบเครื่องหมายจุลภาคจากค่าที่รับมา
                                                let value = input.value.replace(/,/g, ''); 
                                                
                                                if (value.trim() !== "" && !isNaN(value)) {
                                                    // ตรวจสอบว่า input มี class="discount_price_2" หรือไม่
                                                    if (input.classList.contains('discount_price_2')) {
                                                        // ถ้ามี class="discount_price_2", ลบค่าออกจาก total
                                                        total -= parseFloat(value.replace(/[^0-9.-]+/g, ""));
                                                    } else {
                                                        // ถ้าไม่มี class="discount_price_2", เพิ่มค่าเข้าไปใน total
                                                        if (!isNaN(value) && value.trim() !== "") {
                                                            total += parseFloat(value);
                                                        }
                                                    }
                                                }
                                            });
                                            $('.total-price_2').html(total.toLocaleString());
                                            $('.total-price_2').val(total);

                                            // อัปเดตค่า total ใน span#total-price
                                            // document.getElementById('total-price').innerText = total.toLocaleString();
                                        }

                                        </script>
                              
                              {{-- <b>ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price">{{ number_format($invoice->room_for_rent->room->rent + $invoice->water_amount+$invoice->electricity_amount) }}</span> &nbsp;บาท</b> --}}
                          </div>
                                  {{-- <div class="row mt-2" id="expenses-split-container">
                                  </div> --}}
                          <script>
                            document.getElementById('checksplit').addEventListener('change', function() {
                                document.getElementById('divsplit').style.display = this.checked ? 'block' : 'none';
                                document.getElementById('totalsplit').style.display = this.checked ? 'block' : 'none';
                                document.getElementById('totalpayfull').style.display = this.checked ? 'none' : 'block';
                                $('.payment_list_title').attr('required', true);
                            });

                            document.getElementById('payfull').addEventListener('change', function() {
                                document.getElementById('divsplit').style.display = this.checked ? 'none' : 'block';
                                document.getElementById('totalsplit').style.display = this.checked ? 'none' : 'block';
                                document.getElementById('totalpayfull').style.display = this.checked ? 'block' : 'none';
                                $('.payment_list_title').removeAttr('required');

                            });
                          </script>
                      </div>
                    </div>
                </div>

                <div class="mb-3 pb-4" style="border: 1px solid #dbdade;padding: 15px 2px;">
                    <div class="d-flex">
                        <div class="flex-grow-1 ms-3 g-3 row">
                            <b class="text-black">ช่องทางการชำระเงิน</b> <br>
                            <div class="col-sm-11">
                                <input name="payment_channel" class="form-check-input" type="radio" id="defaultRadio1" value="1" checked onclick="togglePaymentFields()">
                                <label class="form-check-label" for="defaultRadio1"> เงินสด </label>
                            </div>
                            
                            <div id="paymentDetails2">
                                <div class="col-sm-6 mb-2">
                                    <label for="payment_date">วันที่ชำระเงิน</label>
                                    <input type="text" name="payment_date" class="form-control" placeholder="" id="payment_date" required autocomplete="off" value="{{date('d/m/Y')}}"/>
                                </div>
                            </div>
                            <div class="col-sm-11">
                                <input name="payment_channel" class="form-check-input" type="radio" id="defaultRadio2" value="2" onclick="togglePaymentFields()"> 
                                <label class="form-check-label" for="defaultRadio2"> โอนเงิน </label>
                            </div>
                
                            <!-- แสดงเมื่อเลือก โอนเงิน -->
                            <div id="paymentDetails" style="display:none;">
                                
                                <div class="col-sm-6 mb-2">
                                      <label>เลือกบัญชีธนาคาร</label>
                                      <select class="select2 form-select mb-2" name="bank" id="exampleFormControlSelect1">
                                        {{-- <option value="" disabled="" selected="selected">บัญชีธนาคาร</option> --}}
                                        @foreach ($bank as $r_bank)
                                            <option value="{{ $r_bank->id }}">{{ $r_bank->bank.' '.$r_bank->bank_account_name }}</option>
                                        @endforeach

                                  </div>
                                <div class="col-sm-4 mb-2">
                                    <input type="hidden" name="">
                                </div>
                                    <div class="col-sm-3 mb-2">
                                        <label for="transfer_time">เวลาโอนเงิน</label><span class="text-danger"> *</span>
                                        <input type="time" name="transfer_time" class="form-control" placeholder="" id="transfer_time" autocomplete="off" required/>
                                    </div>
                                    <div class="col-sm-6 mb-2">
                                        <label for="payment_date2">วันที่โอนเงิน</label><span class="text-danger"> *</span>
                                        <input type="text" name="payment_date2" class="form-control" placeholder="" id="payment_date2" autocomplete="off" value="{{date('d/m/Y')}}" required/>
                                    </div>
                                <div class="col-sm-10 mt-3">
                                    <label for="paymentReceipt">แนบหลักฐานการโอน</label>
                                    <input name="evidence_of_money_transfer" type="file" class="form-control mb-2" id="paymentReceipt">
                                    <div class="preview-container">
                                        <img id="preview1" src="" alt="Preview 1" style="display: none; width:30%">
                                    </div>
                                </div>
                            </div>
                
                            <div class="col-sm-11 mt-2">
                                <b id="totalpayfull">ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price">{{ number_format($invoice->room_for_rent->room->rent + $invoice->water_amount+$invoice->electricity_amount) }}</span> &nbsp;บาท</b>
                                <b id="totalsplit" style="display: none">ยอดชำระเงินทั้งหมด&nbsp; <span class="total-price_2">0</span> &nbsp;บาท</b>
                            </div>
                        </div>
                    </div>
                </div>
                
                <script>
                    function togglePaymentFields() {
                        const paymentChannel = document.querySelector('input[name="payment_channel"]:checked').value;
                        const paymentDetails = document.getElementById('paymentDetails');
                        const paymentDetails2 = document.getElementById('paymentDetails2');
                        // หากเลือก โอนเงิน (value=2) ให้แสดงฟอร์มเพิ่ม
                        if (paymentChannel == '2') {
                            paymentDetails.style.display = 'block';
                            paymentDetails2.style.display = 'none';
                            $('#ref_bank_id').attr('required', true);
                            $('#transfer_time').attr('required', true);
                            $('#payment_date2').attr('required', true);
                        } else {
                            paymentDetails.style.display = 'none';
                            paymentDetails2.style.display = 'block';
                            $('#ref_bank_id').removeAttr('required');
                            $('#transfer_time').removeAttr('required');
                            $('#payment_date2').removeAttr('required')
                        }
                    }
                    function handleFileInput(fileInputId, previewId) {
                        const fileInput = document.getElementById(fileInputId);
                        const previewImage = document.getElementById(previewId);

                        fileInput.addEventListener('change', function () {
                            const file = fileInput.files[0];

                            if (file) {
                                const reader = new FileReader();

                                reader.onload = function (e) {
                                    previewImage.src = e.target.result;
                                    previewImage.style.display = 'block';  // แสดงภาพพรีวิว
                                };

                                reader.readAsDataURL(file);
                            } else {
                                previewImage.style.display = 'none'; // ซ่อนพรีวิวถ้าไม่ได้เลือกไฟล์
                            }
                        });
                    }
                
                    handleFileInput('paymentReceipt', 'preview1');
                    // เรียกใช้ฟังก์ชั่นเริ่มต้นเมื่อเพจโหลด
                    togglePaymentFields();
                </script>

                <h4 class="text-center text-danger">ยอดค้างชำระเงินทั้งหมด&nbsp; <span class="">{{ number_format($invoice->total_amount - $invoice->receipt->pluck('payment_list')->flatten()->sum('price')) }}</span> &nbsp;บาท
                
                  
                  <div class="modal-footer rounded-0 justify-content-center">
                      {{-- <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ยกเลิก</button> --}}
                      <button class="btn btn-info" type="submit">
                        <span>
                        <i class="ti-md ti ti-report-money"></i>
                        <b class="dam">
                          ชำระ
                        </b>
                      </span></button>
                  </div>
        </div>
        
    </div>

    <div class="modal-footer rounded-0 justify-content-start">
        <button type="button" class="btn btn-primary waves-effect" onclick="printPdf({{ $invoice->id }})"><span
                class="ti-md ti ti-printer me-2"></span>พิมพ์ใบแจ้งหนี้</button>
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

        
        function paymentChannel(i) {
            $('#payment_channel').val(i);
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
        
        $('#payment_bill').on('submit', function(event) {
            event.preventDefault(); // ป้องกันการส่งฟอร์มปกติ
            if(!this.checkValidity()) {
                // ถ้าฟอร์มไม่ถูกต้อง
                this.reportValidity();
                return console.log('ฟอร์มไม่ถูกต้อง');
            }
            // return alert(123);
            Swal.fire({
                title: 'ยืนยันการดำเนินการ?',
                text: 'คุณต้องการ บันทึกการเปลี่ยนแปลง หรือไม่?',
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

                    var formData = new FormData($('#payment_bill')[0]);

                    $.ajax({
                        url: '{{ $page_url }}/payment_bill', // เปลี่ยน URL เป็นจุดหมายที่ต้องการ
                        type: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
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