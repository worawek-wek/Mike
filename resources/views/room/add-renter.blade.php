<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
<link rel="stylesheet" href="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.css" />

<script src="assets/vendor/libs/bootstrap-datepicker/bootstrap-datepicker.js"></script>
<div class="modal fade modalHeadDecor" id="addRenter" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content rounded-0">
            <div class="modal-header rounded-0">
                <h5 class="modal-title" id="exampleModalLabel1">เพิ่มผู้เช่าห้อง</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
                <form id="insert_renterAddRenter">
                    @csrf
            <div class="modal-body">
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
                                <option value="บริษัท" selected>บริษัท</option>
                                <option value="นาย">นาย</option>
                                <option value="นางสาว">นางสาว</option>
                                <option value="นาง">นาง</option>
                            </select>
                        </div>
                        <div class="col-sm-5">
                            <label for="exampleFormControlInput1" class="form-label">ชื่อจริง</label>
                            <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="" value="วรเวก"/>
                        </div>
                        <div class="col-sm-5">
                            <label for="exampleFormControlInput2" class="form-label">นามสกุล</label>
                            <input type="text" name="surname" class="form-control" id="exampleFormControlInput2" placeholder="" value="ชึรัมย์" />
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput3" class="form-label">เบอร์โทรศัพท์ (ตัวอย่าง. 0815578945)</label>
                            <input type="text" name="phone" class="form-control" id="exampleFormControlInput3" placeholder="" value="0987776543"/>
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput4" class="form-label">หมายเลขบัตรประชาชน</label>
                            <input type="text" name="id_card_number" class="form-control" id="exampleFormControlInput4" placeholder="" value="1234567890123"/>
                        </div>
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput5" class="form-label">ที่อยู่ตามสำเนาทะเบียนบ้าน</label>
                            <input type="text" name="address" class="form-control" id="exampleFormControlInput5" placeholder="เลขที่ ซอย ถนน อาคาร ห้องเลขที่ หรือหมู่บ้าน" value="12/34"/>
                        </div>
                        <div class="col-sm-4">
                            <label>เลือกจังหวัด</label>
                            <select name="ref_province_id" id="select2BasicAddRenter" class="select2 form-select form-select-lg" required>
                                <option selected disabled hidden value="">เลือกจังหวัด</option>
                                @foreach ($province as $pro)
                                    <option value="{{ $pro->id }}" @if ($pro->id == 2) selected @endif>{{ $pro->name_in_thai }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label>เลือกอำเภอ</label>
                            <select name="ref_district_id" id="select2DistrictAddRenter" class="select2 form-select form-select-lg" required>
                                <option selected disabled hidden value="">เลือกอำเภอ</option>
                                @foreach ($district as $dis)
                                    <option value="{{ $dis->id }}" @if ($dis->id == 53) selected @endif>{{ $dis->name_in_thai }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-4">
                            <label>เลือกตำบล</label>
                            <select name="ref_subdistrict_id" id="select2SubdistrictAddRenter" class="select2 form-select form-select-lg" required>
                                <option selected disabled hidden value="">เลือกตำบล</option>
                                @foreach ($subdistrict as $sub_dis)
                                    <option value="{{ $sub_dis->id }}" @if ($sub_dis->id == 176) selected @endif>{{ $sub_dis->name_in_thai }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="zipcode" class="form-label">รหัสไปรษณีย์</label>
                            <input type="text" name="zipcode" class="form-control" id="zipcodeAddRenter" placeholder="รหัสไปรษณีย์" value="10540" />
                        </div>
                        <div class="col-sm-12">
                            <label for="bs-datepicker-format" class="form-label">วันเดือนปีเกิดผู้จอง</label>
                            <input type="text" name="birthdate" class="form-control" id="bs-datepicker-format" placeholder="วัน/เดือน/ปี" required value="24/04/2025"/>
                        </div>
                        <div class="col-sm-6">
                            <label for="bs-datepicker-format2" class="form-label">วันที่จอง</label>
                            <input type="text" name="booking_date" value="24/04/2025" class="form-control" id="bs-datepicker-format2" placeholder="วัน/เดือน/ปี" required value="24/04/2025"/>
                        </div>
                        <div class="col-sm-6">
                            <label for="exampleFormControlInput12" class="form-label">ช่องทางการจอง</label>
                            <input type="text" name="booking_channel" class="form-control" id="exampleFormControlInput12" placeholder="ช่องทางการจอง" value="จองโดยตรงกับที่พัก" />
                        </div>
                    </div>
                </div>

                <div class="m-2 mt-4" style="border: 1px solid #dbdbdb;border-radius: 5px;">
                    <h5 class="border-bottom p-2" style="background-color: rgb(255, 248, 237);">
                        <i class="tf-icons ti ti-device-ipad-dollar text-main" style="font-size: 25px;vertical-align: baseline;"></i>
                        รายละเอียดการชำระเงิน
                    </h5>
                    <div class="row g-3 p-4 pt-1">
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput30" class="form-label">ค่ามัดจำ (บาท)</label>
                            <input type="text" name="deposit" class="form-control" id="exampleFormControlInput30" placeholder="" value="2000"/>
                        </div>
                        <div class="col-sm-12">
                            <div>
                                <label for="exampleFormControlInput31" class="form-label">วิธีการชำระเงิน</label>
                            </div>
                            <div class="ms-3">
                            <input
                                name="payment_method"
                                class="form-check-input"
                                type="radio"
                                value="1"
                                id="defaultRadio1"
                                checked />
                            <label class="form-check-label" for="defaultRadio1">&nbsp; เงินสด </label>
                            <input
                                name="payment_method"
                                class="form-check-input ms-2"
                                type="radio"
                                value="2"
                                id="defaultRadio2" />
                            <label class="form-check-label" for="defaultRadio2">&nbsp; โอนเงิน </label>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <label for="exampleFormControlInput33" class="form-label">วันที่รับชำระเงิน</label>
                            <input type="text" name="payment_received_date" class="form-control" id="exampleFormControlInput33" placeholder="วัน/เดือน/ปี" value="24/04/2025" required/>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer rounded-0 justify-content-center">
                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">ปิด</button>
                <button type="submit" class="btn btn-main">บันทึก</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
            $('#select2BasicAddRenter').change(function() {
                var provinceId = $(this).val();
                
                // เคลียร์ dropdown สำหรับอำเภอและตำบล
                $('#select2DistrictAddRenter').empty().append('<option selected disabled hidden value="">เลือกอำเภอ</option>');
                $('#select2SubdistrictAddRenter').empty().append('<option selected disabled hidden value="">เลือกตำบล</option>');

                if (provinceId) {
                    $.ajax({
                        url: '/get-districts/' + provinceId,
                        type: 'GET',
                        success: function(data) {
                            data.forEach(function(district) {
                                $('#select2DistrictAddRenter').append('<option value="' + district.id + '">' + district.name_in_thai + '</option>');
                            });
                        }
                    });
                }
            });

            $('#select2DistrictAddRenter').change(function() {
                var districtId = $(this).val();
                
                // เคลียร์ dropdown สำหรับตำบล
                $('#select2SubdistrictAddRenter').empty().append('<option selected disabled hidden value="">เลือกตำบล</option>');

                if (districtId) {
                    $.ajax({
                        url: '/get-subdistricts/' + districtId,
                        type: 'GET',
                        success: function(data) {
                            data.forEach(function(subdistrict) {
                                $('#select2SubdistrictAddRenter').append('<option value="' + subdistrict.id + '">' + subdistrict.name_in_thai + '</option>');
                            });
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
                            $('#zipcodeAddRenter').val(data);
                        }
                    });
                }
            });
        });
</script>