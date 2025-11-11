<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<link rel="stylesheet" href="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />
<script src="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
@php
    $thaiNames = [
        "กิตติ", "วราภรณ์", "อนันต์", "ศศิธร", "ธนพล", "พิชชา", "ศุภชัย", "นฤมล", "ธนวัฒน์", "อารยา",
        "ธนากร", "ณัฐชา", "ปริญญา", "อัญชลี", "สราวุฒิ", "จุฑารัตน์", "วิชาญ", "นงนุช", "ภูริ", "ชุติมา",
        "พีรพล", "ธัญญา", "ภานุวัฒน์", "อุไร", "ชลธี", "จิตราภรณ์", "ปกรณ์", "วาสนา", "ณัฐพล", "มยุรี",
        "พีระ", "นฤมาศ", "ชัยวัฒน์", "สายฝน", "วิทยา", "อรวรรณ", "วัฒนา", "สุรีย์พร", "พงศกร", "ธีราพร",
        "วรินทร", "สุนีย์", "จักรพงษ์", "ธิดารัตน์", "ประเสริฐ", "กมลวรรณ", "พชร", "วิลาสินี", "ศักดิ์สิทธิ์", "รัตนา",
        "สรยุทธ", "ปวีณา", "เจษฎา", "ปาริชาติ", "ธวัชชัย", "สุวิมล", "ภาณุ", "ทิพย์วรรณ", "สันติ", "อัญญา",
        "ปริวัฒน์", "ดารารัตน์", "ธีรพล", "พรรณี", "ชัยณรงค์", "สมหญิง", "สันติภาพ", "ลดาวัลย์", "ณัฐวุฒิ", "นฤดี",
        "พิสิษฐ์", "วราภรณ์", "กฤษณะ", "เบญจมาศ", "ภาสกร", "ชลธิชา", "ทรงพล", "อุษา", "อนุชา", "เพ็ญศรี",
        "ศรัณย์", "พัชรี", "อธิพงษ์", "ชไมพร", "ภัทรพล", "บุญรัตน์", "เกรียงไกร", "สุภาพร", "ภูวเดช", "สุนันทา",
        "กษิดิศ", "วิลาวัลย์", "อิทธิพล", "รุ่งทิพย์", "ณัฐพงษ์", "จารุวรรณ", "อมรชัย", "บุษกร", "ชาญชัย", "วิมล"
    ];
    $thaiSurnames = [
        "สุขสันต์", "ใจดี", "วัฒนากูล", "ศรีสุวรรณ", "พานิชย์", "บุญมี", "ประเสริฐศรี", "กุลวงศ์", "ธรรมรักษ์", "อินทร์แปลง",
        "สุทธิสาร", "พัฒนกิจ", "ศักดิ์ศรี", "จันทร์เพ็ญ", "ทองแท้", "ศิริวัฒน์", "เจริญสุข", "เรืองฤทธิ์", "สกุลไทย", "เจนจิตต์",
        "สาครินทร์", "รัตนคุณ", "มงคลชัย", "เศรษฐ์สิทธิ์", "อัครเดช", "ศิริวงศ์", "พงษ์พิพัฒน์", "พูนทรัพย์", "เพ็งดี", "กิตติพงษ์",
        "ธรรมวงศ์", "ชัยยศ", "ชาญณรงค์", "สังข์ทอง", "ปรีดารัตน์", "วงศ์วาน", "ทองใบ", "ทองคำ", "ทวีทรัพย์", "เกียรติชัย",
        "ยศธร", "เชิดชู", "มณีรัตน์", "สมหมาย", "วรรณพงษ์", "หงส์ทอง", "บุญศรี", "เนตรทิพย์", "ลิขิตวงศ์", "กาญจนวัฒน์",
        "เพ็ญนภา", "จันทร์แก้ว", "อนันต์ชัย", "ชนะชัย", "แสงทอง", "รุ่งเรือง", "ตั้งจิตต์", "ตระการไทย", "เผ่าพันธุ์", "อร่ามเรือง",
        "กิตติวงศ์", "ลิ้มทองคำ", "วงษ์สมบูรณ์", "กัลยาณมิตร", "สุนทรวัฒน์", "สุภกิจ", "อรุณรุ่ง", "อ่อนละม้าย", "พุฒิพงษ์", "จิตติธรรม",
        "ประดิษฐ์", "ธนวัฒน์", "อารีย์วงศ์", "อ่อนใจดี", "เครือวัลย์", "เศรษฐศักดิ์", "ประภากร", "กาญจนสุวรรณ", "อุทัยวรรณ", "พิทักษ์กิจ",
        "เพชรรัตน์", "ศักดากุล", "กิตติศักดิ์", "โสภา", "พิริยจิตร", "หาญกล้า", "ฤกษ์ดี", "รุ่งสว่าง", "กมลชัย", "วรสาร",
        "อ่อนละไม", "จิตรเจริญ", "บุญช่วย", "เพ็ญศิริ", "จิตต์กมล", "สุทธินันท์", "ภักดี", "ทองพูล", "สวัสดี", "ธีรพัฒน์"
    ];
@endphp
<input type="hidden" name="room_id" value="{{ $room->id }}">
@if (@$renter_edit->id)
    <input id="renter_edit" type="hidden" name="renter_id" value="{{ $renter_edit->id }}">
@endif
<div class="m-2" style="border: 1px solid #dbdbdb;border-radius: 5px;">
    <h5 class="border-bottom p-2" style="background-color: rgb(255, 248, 237);;">
        <i class="tf-icons ti ti-user text-main" style="font-size: 25px;vertical-align: baseline;"></i>
        ข้อมูลส่วนตัว
    </h5>
    <div class="row g-3 p-4 pt-1">
        <div class="col-sm-2">
            <label for="exampleFormControlSelect1" class="form-label">คำนำหน้า</label>
            <select name="prefix" class="form-select" id="exampleFormControlSelect1"
                aria-label="Default select example">
                <option @if (@$renter_edit->prefix == 'บริษัท') selected @endif value="บริษัท" selected>บริษัท</option>
                <option @if (@$renter_edit->prefix == 'นาย') selected @endif  value="นาย">นาย</option>
                <option @if (@$renter_edit->prefix == 'นางสาว') selected @endif  value="นางสาว">นางสาว</option>
                <option @if (@$renter_edit->prefix == 'นาง') selected @endif  value="นาง">นาง</option>
            </select>
        </div>
        <div class="col-sm-5">
            <label for="exampleFormControlInput1" class="form-label">ชื่อจริง</label><span class="text-danger">*</span>
            <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="ชื่อจริง" value="{{ @$renter_edit->name }}" required/>
        </div>
        <div class="col-sm-5">
            <label for="exampleFormControlInput2" class="form-label">นามสกุล</label><span class="text-danger">*</span>
            <input type="text" name="surname" class="form-control" id="exampleFormControlInput2" placeholder="นามสกุล" value="{{ @$renter_edit->surname }}" required/>
        </div>
        <div class="col-sm-6">
            <label for="exampleFormControlInput6" class="form-label">เงินเดือน</label>
            <input type="number" name="salary" class="form-control" id="exampleFormControlInput6" placeholder="เงินเดือน" value="{{ @$renter_edit->salary }}"/>
        </div>
        <div class="col-sm-6"></div>
        <div class="col-sm-6">
            <label for="exampleFormControlInput3" class="form-label">เบอร์โทรศัพท์ (ตัวอย่าง. 0815578945)</label><span class="text-danger">*</span>
            <input type="text" name="phone" class="form-control" id="exampleFormControlInput3" placeholder="เบอร์โทรศัพท์ (ตัวอย่าง. 0815578945)" value="{{ @$renter_edit->phone }}" required/>
        </div>
        <div class="col-sm-6">
            <label for="exampleFormControlInput4" class="form-label">หมายเลขบัตรประชาชน</label><span class="text-danger">*</span>
            <input type="text" name="id_card_number" class="form-control" id="exampleFormControlInput4" placeholder="หมายเลขบัตรประชาชน" value="{{ @$renter_edit->id_card_number }}" required/>
        </div>
        <div class="col-sm-12">
            <label for="exampleFormControlInput5" class="form-label">ที่อยู่ตามสำเนาทะเบียนบ้าน</label>
            <input type="text" name="address" class="form-control" id="exampleFormControlInput5" placeholder="เลขที่ ซอย ถนน อาคาร ห้องเลขที่ หรือหมู่บ้าน" value="{{ @$renter_edit->address }}"/>
        </div>
        <div class="col-sm-4">
            <label>เลือกจังหวัด</label>
            <select name="ref_province_id" id="select2BasicAddRenter">
                <option selected disabled hidden value="">เลือกจังหวัด</option>
                @foreach ($province as $pro)
                    <option value="{{ $pro->id }}" @if ($pro->id == @$renter_edit->ref_province_id) selected @endif>{{ $pro->name_in_thai }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-4">
            <label>เลือกอำเภอ</label>
            <select name="ref_district_id" id="select2DistrictAddRenter">
                <option selected disabled hidden value="">เลือกอำเภอ</option>
                @foreach ($district as $dis)
                    <option value="{{ $dis->id }}" @if ($dis->id == @$renter_edit->ref_district_id) selected @endif>{{ $dis->name_in_thai }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-4">
            <label>เลือกตำบล</label>
            <select name="ref_subdistrict_id" id="select2SubdistrictAddRenter">
                <option selected disabled hidden value="">เลือกตำบล</option>
                @foreach ($subdistrict as $sub_dis)
                    <option value="{{ $sub_dis->id }}" @if ($sub_dis->id == @$renter_edit->ref_subdistrict_id) selected @endif>{{ $sub_dis->name_in_thai }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-sm-6">
            <label for="zipcode" class="form-label">รหัสไปรษณีย์</label>
            <input type="text" name="zipcode" class="form-control" id="zipcodeAddRenter" placeholder="รหัสไปรษณีย์" value="{{ @$renter_edit->zipcode }}" />
        </div>
        <div class="col-sm-12">
            <label for="birthdate" class="form-label">วันเดือนปีเกิดผู้จอง</label>
            <input type="text" name="birthdate" class="form-control" id="add_birthdate" placeholder="วัน/เดือน/ปี" required value="{{ @$renter_edit->birthdate != null ? date('d/m/Y', strtotime($renter_edit->birthdate)) : ''; }}" autocomplete="off"/>
        </div>
        {{-- <div class="col-sm-6">
            <label for="bs-datepicker-format2" class="form-label">วันที่จอง</label>
            <input type="text" name="booking_date" value="24/04/2025" class="form-control" id="bs-datepicker-format2" placeholder="วัน/เดือน/ปี" required value="24/04/2025"/>
        </div>
        <div class="col-sm-6">
            <label for="exampleFormControlInput12" class="form-label">ช่องทางการจอง</label>
            <input type="text" name="booking_channel" class="form-control" id="exampleFormControlInput12" placeholder="ช่องทางการจอง" value="จองโดยตรงกับที่พัก" />
        </div> --}}
    </div>
</div>

<div class="m-2 mt-4" style="border: 1px solid #dbdbdb;border-radius: 5px;">
    <h5 class="border-bottom p-2" style="background-color: rgb(255, 248, 237);">
        <i class="tf-icons ti ti-device-ipad-dollar text-main" style="font-size: 25px;vertical-align: baseline;"></i>
        ยานพาหนะที่นำมาใช้
    </h5>
    @php
    $vehicles = $renter_edit->vehicles ?? [];
    @endphp

    <div class="row g-3 p-4 pt-1" id="vehicleContainer">
        @foreach ($vehicles as $key => $veh)
        @php
            if($veh->ref_room_id != $room->id){
                continue;
            }
        @endphp
            <div class="vehicle-group row g-3 mb-2">
                <div class="col-sm-2">
                    <label class="form-label">คันที่ {{ $key+1 }}</label>
                    <select name="vehicles[{{$key}}][ref_type_id]" class="form-control w-100" data-style="btn-default" required>
                        <option value="1" {{ @$veh->ref_type_id == 1 ? 'selected' : '' }}>รถยนต์</option>
                        <option value="2" {{ @$veh->ref_type_id == 2 ? 'selected' : '' }}>มอเตอร์ไซค์</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <label class="form-label">ทะเบียนรถ</label>
                    <input type="text" name="vehicles[{{$key}}][car_registration]" class="form-control" placeholder="ทะเบียนรถ" value="{{ @$veh->car_registration }}" />
                </div>
                <div class="col-sm-5">
                    <label class="form-label">รายละเอียด</label>
                    <input type="text" name="vehicles[{{$key}}][detail]" class="form-control" placeholder="รายละเอียด" value="{{ @$veh->detail }}" />
                </div>
                <div class="col-sm-1 d-flex align-items-end">
                    <button type="button" class="btn btn-sm btn-danger remove-vehicle w-100">
                        <i class="ti ti-trash"></i> ลบ
                    </button>
                </div>
            </div>
        @endforeach
            <div class="vehicle-group row g-3 mb-2">
                <div class="col-sm-2">
                    <label class="form-label">คันที่ {{ count($vehicles)+1 }}</label>
                    <select name="vehicles[{{ count($vehicles) }}][ref_type_id]" class="form-control w-100" data-style="btn-default" required>
                        <option value="1" {{ @$veh->ref_type_id == 1 ? 'selected' : '' }}>รถยนต์</option>
                        <option value="2" {{ @$veh->ref_type_id == 2 ? 'selected' : '' }}>มอเตอร์ไซค์</option>
                    </select>
                </div>
                <div class="col-sm-4">
                    <label class="form-label">ทะเบียนรถ</label>
                    <input type="text" name="vehicles[{{ count($vehicles) }}][car_registration]" class="form-control" placeholder="ทะเบียนรถ" value="" />
                </div>
                <div class="col-sm-5">
                    <label class="form-label">รายละเอียด</label>
                    <input type="text" name="vehicles[{{ count($vehicles) }}][detail]" class="form-control" placeholder="รายละเอียด" value="" />
                </div>
                <div class="col-sm-1 d-flex align-items-end">
                    <button type="button" class="btn btn-sm btn-danger remove-vehicle w-100">
                        <i class="ti ti-trash"></i> ลบ
                    </button>
                </div>
            </div>
    </div>

    <!-- ปุ่มเพิ่ม -->
    <div class="p-4">
        <button
            id="add_vehicles"
            class="btn btn-sm btn-warning mt-3"
            type="button">
            <i class="ti ti-plus"></i> เพิ่ม
        </button>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    $(document).ready(function () {
        let vehicleIndex = {{ count($vehicles) + 1 }};

        $('#add_vehicles').on('click', function () {
            vehicleIndex++;

            let html = `
                <div class="vehicle-group row g-3 mb-2">
                    <div class="col-sm-2">
                        <label class="form-label">คันที่ ${vehicleIndex}</label>
                        <select name="vehicles[${vehicleIndex - 1}][ref_type_id]" class="form-control w-100" required>
                            <option value="1">รถยนต์</option>
                            <option value="2">มอเตอร์ไซค์</option>
                        </select>
                    </div>
                    <div class="col-sm-4">
                        <label class="form-label">ทะเบียนรถ</label>
                        <input type="text" name="vehicles[${vehicleIndex - 1}][car_registration]" class="form-control" placeholder="ทะเบียนรถ" />
                    </div>
                    <div class="col-sm-5">
                        <label class="form-label">รายละเอียด</label>
                        <input type="text" name="vehicles[${vehicleIndex - 1}][detail]" class="form-control" placeholder="รายละเอียด" />
                    </div>
                    <div class="col-sm-1 d-flex align-items-end">
                        <button type="button" class="btn btn-sm btn-danger remove-vehicle w-100">
                            <i class="ti ti-trash"></i> ลบ
                        </button>
                    </div>
                </div>
            `;

            $('#vehicleContainer').append(html);
        });

        // ใช้ event delegation สำหรับปุ่มลบ
        $(document).on('click', '.remove-vehicle', function () {
            $(this).closest('.vehicle-group').remove();
        });
    });

    $(document).ready(function() {
        $('#select2BasicAddRenter').on('change', function () {
            const provinceId = $(this).val();
            if (provinceId) {
            
                document.getElementById('loadingOverlay').style.display = 'flex';

            if (tomDistrict2) {
                tomDistrict2.destroy();
            }
            $('#select2DistrictAddRenter').html('<option selected disabled hidden value="">เลือกอำเภอ</option>');

                $.ajax({
                    url: '/get-districts/' + provinceId,
                    type: 'GET',
                    success: function (data) {
                        data.forEach(function (district) {
                            $('#select2DistrictAddRenter').append(
                                `<option value="${district.id}">${district.name_in_thai}</option>`
                            );
                        });

                        tomDistrict2 = new TomSelect("#select2DistrictAddRenter", {
                            create: false,
                            maxItems: 1,
                            allowEmptyOption: true,
                            sortField: { field: "text", direction: "asc" }
                        });
                        document.getElementById('loadingOverlay').style.display = 'none';
                    },
                    error: function(error) {
                        document.getElementById('loadingOverlay').style.display = 'none';
                        Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                        console.error('เกิดข้อผิดพลาด:', error);
                    }
                });
            }
        });

        $('#select2DistrictAddRenter').on('change', function () {
            var districtId = $(this).val();
            
            if (districtId) {
            
                document.getElementById('loadingOverlay').style.display = 'flex';

            if (tomSubdistrict2) {
                tomSubdistrict2.destroy();
            }
            $('#select2SubdistrictAddRenter').html('<option selected disabled hidden value="">เลือกตำบล</option>');

                $.ajax({
                    url: '/get-subdistricts/' + districtId,
                    type: 'GET',
                    success: function (data) {
                        data.forEach(function (subdistrict) {
                            $('#select2SubdistrictAddRenter').append(
                                `<option value="${subdistrict.id}">${subdistrict.name_in_thai}</option>`
                            );
                        });

                        tomSubdistrict2 = new TomSelect("#select2SubdistrictAddRenter", {
                            create: false,
                            maxItems: 1,
                            allowEmptyOption: true,
                            sortField: { field: "text", direction: "asc" }
                        });
                        document.getElementById('loadingOverlay').style.display = 'none';
                    },
                    error: function(error) {
                        document.getElementById('loadingOverlay').style.display = 'none';
                        Swal.fire('เกิดข้อผิดพลาด', '', 'error');
                        console.error('เกิดข้อผิดพลาด:', error);
                    }
                });
            }
        });
        
        $('#select2SubdistrictAddRenter').change(function() {
            var subdistrictsid = $(this).val();
            if (subdistrictsid) {
                $.ajax({
                    url: '/get-zipcode/' + subdistrictsid,
                    type: 'GET',
                    success: function(data) {
                        $('#zipcode').val(data);
                    }
                });
            }
        });
        
    });
</script>
<script>
    $('#add_birthdate').datepicker({
        format: 'dd/mm/yyyy', // กำหนดรูปแบบวันที่
        autoclose: true,      // ปิด datepicker เมื่อเลือกวันที่
        todayHighlight: true  // ไฮไลต์วันที่ปัจจุบัน
    });
</script>