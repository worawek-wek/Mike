{{-- form จองห้อง --}}

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-tagsinput/0.8.0/bootstrap-tagsinput.min.js"></script>
<link rel="stylesheet" href="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<script src="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<style>
    .bootstrap-tagsinput {
      width: 100%;
    }
    .bootstrap-tagsinput .tag.invalid {
      background-color: #dc3545 !important;
      color: white;
    }

    .bootstrap-tagsinput .tag {
    color: white !important; 
    background-color: #007bff !important; 
    padding: 5px;
    border-radius: 4px;
    margin-right: 2px;
    }

    .bootstrap-tagsinput .tag.invalid {
    background-color: #dc3545 !important; /* สีแดง */
    color: white !important;
    }

  </style>
<div class="m-2" style="border: 1px solid #dbdbdb;border-radius: 5px;">
    <h5 class="border-bottom p-2" style="background-color: rgb(255, 248, 237);;">
        <i class="tf-icons ti ti-user text-main" style="font-size: 25px;vertical-align: baseline;"></i>
        ข้อมูลส่วนตัว
    </h5>
    <div class="row g-3 p-4 pt-1">
        <div class="col-sm-2">
            <label for="exampleFormControlSelect1" class="form-label">คำนำหน้า</label>
            <input type="text" name="prefix" class="form-control" id="exampleFormControlInput1" placeholder="" value="{{ $room->room_for_rent_main->renter->prefix }}" required readonly/>
            {{-- <select name="prefix" class="form-select" id="exampleFormControlSelect1"
                aria-label="Default select example" readonly>
                <option value="บริษัท" selected>บริษัท</option>
                <option value="นาย">นาย</option>
                <option value="นางสาว">นางสาว</option>
                <option value="นาง">นาง</option>
            </select> --}}
        </div>
        <div class="col-sm-5">
            <label for="exampleFormControlInput1" class="form-label">ชื่อจริง</label><span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="" value="{{ $room->room_for_rent_main->renter->name }}" required readonly/>
        </div>
        <div class="col-sm-5">
            <label for="exampleFormControlInput2" class="form-label">นามสกุล</label><span class="text-danger">*</span>
            <input type="text" name="surname" class="form-control" id="exampleFormControlInput2" placeholder="" value="{{ $room->room_for_rent_main->renter->surname }}" required readonly/>
        </div>
        <div class="col-sm-6">
            <label for="exampleFormControlInput3" class="form-label">เบอร์โทรศัพท์ (ตัวอย่าง. 0815578945)</label><span class="text-danger">*</span></label>
            <input type="text" name="phone" class="form-control" id="exampleFormControlInput3" placeholder="" value="{{ $room->room_for_rent_main->renter->phone }}" oninput="this.value=this.value.slice(0,10);" pattern="^\d{9,10}$" required readonly/>
        </div>
        <div class="col-sm-6">
            <label for="exampleFormControlInput4" class="form-label">เลขบัตรประชาชน/Passport</label><span class="text-danger">*</span></label>
            <input type="text" name="id_card_number" class="form-control" id="exampleFormControlInput4" placeholder="" value="{{ $room->room_for_rent_main->renter->id_card_number }}" oninput="this.value=this.value.slice(0,13);" pattern="^\d{13}$" required readonly/>
        </div>
        <div class="col-sm-12">
            <label for="exampleFormControlInput5" class="form-label">ที่อยู่ตามสำเนาทะเบียนบ้าน</label>
            <input type="text" name="address" class="form-control" id="exampleFormControlInput5" value="{{ $room->room_for_rent_main->renter->address }}" readonly/>
        </div>
        <div class="col-sm-4">
            <label for="exampleFormControlInput5" class="form-label">จังหวัด</label>
            <input type="text" name="provice" class="form-control" id="exampleFormControlInput5" value="{{ $room->room_for_rent_main->renter->province->name_in_thai ?? '' }}" readonly/>
        </div>
        <div class="col-sm-4">
            <label for="exampleFormControlInput5" class="form-label">อำภอ</label>
            <input type="text" name="district" class="form-control" id="exampleFormControlInput5" value="{{ $room->room_for_rent_main->renter->district->name_in_thai ?? '' }}" readonly/>
        </div>
        <div class="col-sm-4">
            <label for="exampleFormControlInput5" class="form-label">ตำบล</label>
            <input type="text" name="subdistrict" class="form-control" id="exampleFormControlInput5" value="{{ $room->room_for_rent_main->renter->subdistrict->name_in_thai ?? '' }}" readonly/>
        </div>
        <div class="col-sm-6">
            <label for="zipcode" class="form-label">รหัสไปรษณีย์</label>
            <input type="number" name="zipcode" class="form-control" id="zipcode" placeholder="รหัสไปรษณีย์" value="{{ $room->room_for_rent_main->renter->zipcode }}" readonly/>
        </div>
        <div class="col-sm-6">
            <label for="bs-datepicker-format2" class="form-label">วันที่จอง</label>
            <input type="text" name="booking_date" class="form-control" id="bs-datepicker-format2" placeholder="วัน/เดือน/ปี" value="{{ date('d/m/Y', strtotime($room->room_for_rent_main->renter->booking_date)) }}" required readonly/>
        </div>
        
        <div class="col-sm-6">
            <label for="exampleFormControlInput12" class="form-label">ช่องทางการจอง</label>
            <input type="text" name="booking_channel" class="form-control" id="exampleFormControlInput12" placeholder="ช่องทางการจอง" value="{{ $room->room_for_rent_main->renter->booking_channel }}"  readonly/>
        </div>
    </div>
</div>
<div class="m-2 mt-4" style="border: 1px solid #dbdbdb;border-radius: 5px;">
    <h5 class="border-bottom p-2" style="background-color: rgb(255, 248, 237);">
        <i class="tf-icons ti ti-device-ipad-dollar text-main" style="font-size: 25px;vertical-align: baseline;"></i>
        ข้อมูลการชำระเงิน
    </h5>
        <div class="p-4 m-4" style="border: 1px solid #59d57a;border-radius: 5px;">
        <p align="right" style="color: black; font-weight: 500;">เลขที่ใบเสร็จ: &nbsp; <span class="text-success">{{ $receipt_jong->receipt_number }}</span></p>
            <table class="table table-detail table-bordered">
                <thead>
                    <tr>
                        <td width="50%">
                            <span style="color: black; font-weight: 500;">รายละเอียดหัวบิล</span> <br>
                            {{ $room->room_for_rent_main->renter->full_name }} <br>
                            เลขประจำตัวผู้เสียภาษี {{ $room->room_for_rent_main->renter->id_card_number }} <br>
                            โทร {{ $room->room_for_rent_main->renter->phone }}
                        </td>
                        <td style="color: black;">
                                    @php
                                        $date = new DateTime(date('Y-m-d', strtotime($receipt_jong->created_at)));
                                        $englishDay = $date->format('l');
                                        
                                    @endphp
                                        <span style="color: black; font-weight: 500;">วันที่รับชำระเงิน</span> &nbsp; &nbsp; &nbsp; {!! $days[$englishDay].' &nbsp;'.date('d/m/Y', strtotime($receipt_jong->created_at)) !!}<br>
                                        <span style="color: black; font-weight: 500;">ช่องทางการชำระเงิน</span> &nbsp; &nbsp; &nbsp; {{ $receipt_jong->payment_channel == 1 ? "เงินสด": "โอนเงิน"; }}<br>
                                        <span style="color: black; font-weight: 500;">รับชำระโดย</span> &nbsp; &nbsp; &nbsp; {{ $receipt_jong->user->name }}<br>
                                        &nbsp;
                        </td>
                        
                    </tr>
                </thead>
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
                    @foreach ($receipt_jong->payment_list as $item_payment_list)
                    <tr>
                        <td class="{{$item_payment_list->discount == 1 ? "text-danger fw-bold" : ""}}">
                            {{ $item_payment_list->title }}
                            @if($item_payment_list->unit > 0 && $key == 1)    
                                {{ number_format($item_payment_list->unit) }} = {{ $item_payment_list->unit - 0 }} ยูนิต)
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
            {{--  --}}
            <div class="modal-footer rounded-0 justify-content-start mt-2 pb-0">
                <button type="button" class="btn btn-label-primary waves-effect" onclick="printPdf({{$receipt_jong->id}})"><span
                        class="ti-sm ti ti-printer me-2"></span>พิมพ์ใบเสร็จรับเงิน</button>
            </div>
            {{--  --}}
            {{-- @if ($key+1 < count($receipt))
                <hr class="mb-4">
            @endif --}}
            {{--  --}}
        </div>
</div>
<iframe id="print-iframe" style="display: none;"></iframe>                   
<script>
    function printPdf(id) {
        $.ajax({
            url: '/pdf/receipt/'+id,
            type: 'GET',
            success: function(html) {
                const iframe = document.getElementById('print-iframe');
                const doc = iframe.contentWindow.document;
                doc.open();
                doc.write(html);
                doc.close();

                // รอโหลดก่อนค่อยพิมพ์
                iframe.onload = function () {
                    iframe.contentWindow.focus();
                    iframe.contentWindow.print();
                };
            },
            error: function(xhr) {
                alert('เกิดข้อผิดพลาด');
                console.error(xhr.responseText);
            }
        });
    }
</script>